<?php
/**
 * Plugin Name: Stock Market Ticker | San Miguel de Tucumán
 * Plugin URI: https://www.marindelafuente.com.ar
 * Description: Un ticker animado para mostrar datos municipales o cualquier información con loop infinito. Agrega datos desde el panel de administración y usa el shortcode [stock_ticker] para mostrar el ticker.
 * Version: 1.0.0
 * Author: Jose Marin de la Fuente
 * Author URI: https://www.marindelafuente.com.ar
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: stock-market-ticker
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes
define('SMT_VERSION', '1.0.0');
define('SMT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SMT_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Clase principal del plugin
 */
class Stock_Market_Ticker {
    
    public function __construct() {
        // Hooks de activación/desactivación
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Hooks de WordPress
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_post_smt_save_ticker_item', array($this, 'save_ticker_item'));
        add_action('admin_post_smt_delete_ticker_item', array($this, 'delete_ticker_item'));
        add_action('admin_post_smt_update_ticker_item', array($this, 'update_ticker_item'));
        add_action('admin_post_smt_save_config', array($this, 'save_config_settings'));
        
        // Registrar shortcode
        add_shortcode('stock_ticker', array($this, 'render_ticker_shortcode'));
        
        // AJAX handlers
        add_action('wp_ajax_smt_get_ticker_item', array($this, 'ajax_get_ticker_item'));
    }
    
    /**
     * Activar plugin - Crear tabla en la base de datos
     */
    public function activate() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        $config_table = $wpdb->prefix . 'stock_ticker_config';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            ticker_value varchar(100) NOT NULL,
            ticker_label varchar(255) NOT NULL,
            ticker_color varchar(7) DEFAULT '#F7DC6F',
            ticker_order int(11) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        $config_sql = "CREATE TABLE IF NOT EXISTS $config_table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            config_key varchar(100) NOT NULL,
            config_value text NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY config_key (config_key)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        dbDelta($config_sql);
        
        // Inicializar configuraciones por defecto
        $this->initialize_default_configs();
        
        // Agregar datos de ejemplo si la tabla está vacía
        $count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        if ($count == 0) {
            $sample_data = array(
                array('value' => '282', 'label' => 'cuadras pavimentadas', 'color' => '#F7DC6F'),
                array('value' => '32,750', 'label' => 'baches reparados', 'color' => '#82E0AA'),
                array('value' => '4,931', 'label' => 'árboles plantados', 'color' => '#85C1E9'),
                array('value' => '623', 'label' => 'prestaciones en Asistencia Pública', 'color' => '#F1948A'),
                array('value' => '62', 'label' => 'plazas revalorizadas', 'color' => '#D7BDE2'),
            );
            
            foreach ($sample_data as $index => $item) {
                $wpdb->insert(
                    $table_name,
                    array(
                        'ticker_value' => $item['value'],
                        'ticker_label' => $item['label'],
                        'ticker_color' => $item['color'],
                        'ticker_order' => $index
                    )
                );
            }
        }
    }
    
    /**
     * Desactivar plugin
     */
    public function deactivate() {
        // Puedes agregar código de limpieza aquí si es necesario
    }
    
    /**
     * Inicializar configuraciones por defecto
     */
    private function initialize_default_configs() {
        global $wpdb;
        $config_table = $wpdb->prefix . 'stock_ticker_config';
        
        $default_configs = array(
            'background_color' => '#ffffff',
            'border_color' => '#e0e0e0',
            'border_radius' => '8',
            'font_family' => 'Roboto',
            'font_size' => '16',
            'font_weight' => '400',
            'text_color' => '#333333',
            'value_color' => '#0066ff',
            'value_font_size' => '24',
            'value_font_weight' => '700',
            'label_color' => '#666666',
            'label_font_size' => '14',
            'label_font_weight' => '400',
            'animation_speed' => '20',
            'ticker_height' => '80',
            'padding_horizontal' => '20',
            'padding_vertical' => '15',
            'box_shadow' => '0 2px 8px rgba(0,0,0,0.1)',
            'hover_effect' => '1'
        );
        
        foreach ($default_configs as $key => $value) {
            $existing = $wpdb->get_var($wpdb->prepare("SELECT config_value FROM $config_table WHERE config_key = %s", $key));
            if (!$existing) {
                $wpdb->insert(
                    $config_table,
                    array(
                        'config_key' => $key,
                        'config_value' => $value
                    )
                );
            }
        }
    }
    
    /**
     * Obtener configuración
     */
    public function get_config($key, $default = '') {
        global $wpdb;
        $config_table = $wpdb->prefix . 'stock_ticker_config';
        $value = $wpdb->get_var($wpdb->prepare("SELECT config_value FROM $config_table WHERE config_key = %s", $key));
        return $value ? $value : $default;
    }
    
    /**
     * Guardar configuración
     */
    public function save_config($key, $value) {
        global $wpdb;
        $config_table = $wpdb->prefix . 'stock_ticker_config';
        
        $existing = $wpdb->get_var($wpdb->prepare("SELECT id FROM $config_table WHERE config_key = %s", $key));
        
        if ($existing) {
            $wpdb->update(
                $config_table,
                array('config_value' => $value),
                array('config_key' => $key)
            );
        } else {
            $wpdb->insert(
                $config_table,
                array(
                    'config_key' => $key,
                    'config_value' => $value
                )
            );
        }
    }
    
    /**
     * Agregar menú de administración
     */
    public function add_admin_menu() {
        add_menu_page(
            'Stock Market Ticker',
            'Ticker SMT',
            'manage_options',
            'stock-market-ticker',
            array($this, 'render_admin_page'),
            'dashicons-chart-line',
            30
        );
        
        add_submenu_page(
            'stock-market-ticker',
            'Configuraciones de Diseño',
            'Configuraciones',
            'manage_options',
            'stock-market-ticker-config',
            array($this, 'render_config_page')
        );
    }
    
    /**
     * Cargar scripts en el admin
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook != 'toplevel_page_stock-market-ticker' && $hook != 'ticker-smt_page_stock-market-ticker-config') {
            return;
        }
        
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('smt-admin-css', SMT_PLUGIN_URL . 'assets/css/admin.css', array(), SMT_VERSION);
        wp_enqueue_script('smt-admin-js', SMT_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'wp-color-picker'), SMT_VERSION, true);
        
        wp_localize_script('smt-admin-js', 'smtAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('smt_nonce')
        ));
    }
    
    /**
     * Cargar scripts en el frontend
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_style('smt-ticker-css', SMT_PLUGIN_URL . 'assets/css/ticker.css', array(), SMT_VERSION);
        wp_enqueue_script('smt-ticker-js', SMT_PLUGIN_URL . 'assets/js/ticker.js', array('jquery'), SMT_VERSION, true);
    }
    
    /**
     * Renderizar página de administración
     */
    public function render_admin_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        $items = $wpdb->get_results("SELECT * FROM $table_name ORDER BY ticker_order ASC");
        
        include SMT_PLUGIN_DIR . 'includes/admin-page.php';
    }
    
    /**
     * Renderizar página de configuraciones
     */
    public function render_config_page() {
        include SMT_PLUGIN_DIR . 'includes/config-page.php';
    }
    
    /**
     * Guardar nuevo item del ticker
     */
    public function save_ticker_item() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos para realizar esta acción.');
        }
        
        check_admin_referer('smt_save_item', 'smt_nonce');
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        
        $value = sanitize_text_field($_POST['ticker_value']);
        $label = sanitize_text_field($_POST['ticker_label']);
        $color = sanitize_hex_color($_POST['ticker_color']);
        
        $max_order = $wpdb->get_var("SELECT MAX(ticker_order) FROM $table_name");
        
        $wpdb->insert(
            $table_name,
            array(
                'ticker_value' => $value,
                'ticker_label' => $label,
                'ticker_color' => $color,
                'ticker_order' => $max_order + 1
            )
        );
        
        wp_redirect(admin_url('admin.php?page=stock-market-ticker&status=saved'));
        exit;
    }
    
    /**
     * Actualizar item del ticker
     */
    public function update_ticker_item() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos para realizar esta acción.');
        }
        
        check_admin_referer('smt_update_item', 'smt_nonce');
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        
        $id = intval($_POST['item_id']);
        $value = sanitize_text_field($_POST['ticker_value']);
        $label = sanitize_text_field($_POST['ticker_label']);
        $color = sanitize_hex_color($_POST['ticker_color']);
        
        $wpdb->update(
            $table_name,
            array(
                'ticker_value' => $value,
                'ticker_label' => $label,
                'ticker_color' => $color
            ),
            array('id' => $id)
        );
        
        wp_redirect(admin_url('admin.php?page=stock-market-ticker&status=updated'));
        exit;
    }
    
    /**
     * Eliminar item del ticker
     */
    public function delete_ticker_item() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos para realizar esta acción.');
        }
        
        check_admin_referer('smt_delete_item_' . $_GET['id']);
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        $id = intval($_GET['id']);
        
        $wpdb->delete($table_name, array('id' => $id));
        
        wp_redirect(admin_url('admin.php?page=stock-market-ticker&status=deleted'));
        exit;
    }
    
    /**
     * AJAX: Obtener item del ticker
     */
    public function ajax_get_ticker_item() {
        check_ajax_referer('smt_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('No tienes permisos.');
        }
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        $id = intval($_POST['item_id']);
        
        $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
        
        if ($item) {
            wp_send_json_success($item);
        } else {
            wp_send_json_error('Item no encontrado.');
        }
    }
    
    /**
     * Guardar configuraciones de diseño
     */
    public function save_config_settings() {
        if (!current_user_can('manage_options')) {
            wp_die('No tienes permisos para realizar esta acción.');
        }
        
        check_admin_referer('smt_save_config', 'smt_nonce');
        
        $config_keys = array(
            'background_color', 'border_color', 'border_radius', 'font_family',
            'font_size', 'font_weight', 'text_color', 'value_color',
            'value_font_size', 'value_font_weight', 'label_color',
            'label_font_size', 'label_font_weight', 'animation_speed',
            'ticker_height', 'padding_horizontal', 'padding_vertical',
            'box_shadow', 'hover_effect'
        );
        
        foreach ($config_keys as $key) {
            if (isset($_POST[$key])) {
                $value = sanitize_text_field($_POST[$key]);
                $this->save_config($key, $value);
            }
        }
        
        wp_redirect(admin_url('admin.php?page=stock-market-ticker-config&status=saved'));
        exit;
    }
    
    /**
     * Shortcode para renderizar el ticker
     */
    public function render_ticker_shortcode($atts) {
        $atts = shortcode_atts(array(
            'speed' => '20',
            'height' => '80'
        ), $atts);
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_ticker_items';
        $items = $wpdb->get_results("SELECT * FROM $table_name ORDER BY ticker_order ASC");
        
        if (empty($items)) {
            return '<p>No hay datos en el ticker. Por favor, agrega algunos datos desde el panel de administración.</p>';
        }
        
        ob_start();
        include SMT_PLUGIN_DIR . 'includes/ticker-template.php';
        return ob_get_clean();
    }
}

// Inicializar el plugin
new Stock_Market_Ticker();


