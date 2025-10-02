<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap smt-admin-wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php
    // Mostrar mensajes de estado
    if (isset($_GET['status'])) {
        $status = sanitize_text_field($_GET['status']);
        switch ($status) {
            case 'saved':
                echo '<div class="notice notice-success is-dismissible"><p>¡Elemento guardado correctamente!</p></div>';
                break;
            case 'updated':
                echo '<div class="notice notice-success is-dismissible"><p>¡Elemento actualizado correctamente!</p></div>';
                break;
            case 'deleted':
                echo '<div class="notice notice-success is-dismissible"><p>¡Elemento eliminado correctamente!</p></div>';
                break;
        }
    }
    ?>
    
    <div class="smt-container">
        <!-- Panel izquierdo: Formulario -->
        <div class="smt-panel smt-form-panel">
            <h2>➕ Agregar Nuevo Elemento</h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="smt-form">
                <?php wp_nonce_field('smt_save_item', 'smt_nonce'); ?>
                <input type="hidden" name="action" value="smt_save_ticker_item">
                
                <div class="smt-form-group">
                    <label for="ticker_value">
                        <strong>Valor:</strong>
                        <span class="description">El número o dato a mostrar</span>
                    </label>
                    <input type="text" 
                           id="ticker_value" 
                           name="ticker_value" 
                           class="regular-text" 
                           placeholder="Ej: 282 o 32,750"
                           required>
                </div>
                
                <div class="smt-form-group">
                    <label for="ticker_label">
                        <strong>Etiqueta:</strong>
                        <span class="description">Descripción del dato</span>
                    </label>
                    <input type="text" 
                           id="ticker_label" 
                           name="ticker_label" 
                           class="regular-text" 
                           placeholder="Ej: cuadras pavimentadas"
                           required>
                </div>
                
                <div class="smt-form-group">
                    <label for="ticker_color">
                        <strong>Color:</strong>
                        <span class="description">Color del cuadrado indicador</span>
                    </label>
                    <input type="text" 
                           id="ticker_color" 
                           name="ticker_color" 
                           class="color-picker" 
                           value="#F7DC6F">
                </div>
                
                <div class="smt-form-actions">
                    <button type="submit" class="button button-primary button-large">
                        💾 Guardar Elemento
                    </button>
                </div>
            </form>
            
            <!-- Información del shortcode -->
            <div class="smt-shortcode-info">
                <h3>📌 Cómo usar el ticker</h3>
                <p>Copia y pega este shortcode en cualquier página, entrada o widget:</p>
                <div class="smt-shortcode-box">
                    <code>[stock_ticker]</code>
                    <button class="button button-small smt-copy-btn" data-clipboard="[stock_ticker]">
                        📋 Copiar
                    </button>
                </div>
                
                <h4>Parámetros opcionales:</h4>
                <ul class="smt-params-list">
                    <li><code>[stock_ticker speed="20"]</code> - Velocidad de animación en segundos</li>
                    <li><code>[stock_ticker height="80"]</code> - Altura del ticker en píxeles</li>
                    <li><code>[stock_ticker speed="15" height="100"]</code> - Combinar parámetros</li>
                </ul>
            </div>
        </div>
        
        <!-- Panel derecho: Lista de elementos -->
        <div class="smt-panel smt-items-panel">
            <h2>📊 Elementos del Ticker (<?php echo count($items); ?>)</h2>
            
            <?php if (empty($items)) : ?>
                <div class="smt-empty-state">
                    <p>No hay elementos en el ticker.</p>
                    <p>Agrega tu primer elemento usando el formulario de la izquierda.</p>
                </div>
            <?php else : ?>
                <div class="smt-items-list">
                    <?php foreach ($items as $item) : ?>
                        <div class="smt-item" data-id="<?php echo esc_attr($item->id); ?>">
                            <div class="smt-item-content">
                                <div class="smt-item-color" style="background-color: <?php echo esc_attr($item->ticker_color); ?>"></div>
                                <div class="smt-item-info">
                                    <div class="smt-item-value"><?php echo esc_html($item->ticker_value); ?></div>
                                    <div class="smt-item-label"><?php echo esc_html($item->ticker_label); ?></div>
                                </div>
                            </div>
                            <div class="smt-item-actions">
                                <button class="button button-small smt-edit-btn" data-id="<?php echo esc_attr($item->id); ?>">
                                    ✏️ Editar
                                </button>
                                <a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=smt_delete_ticker_item&id=' . $item->id), 'smt_delete_item_' . $item->id); ?>" 
                                   class="button button-small button-link-delete smt-delete-btn"
                                   onclick="return confirm('¿Estás seguro de eliminar este elemento?');">
                                    🗑️ Eliminar
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para editar -->
<div id="smt-edit-modal" class="smt-modal" style="display: none;">
    <div class="smt-modal-content">
        <span class="smt-modal-close">&times;</span>
        <h2>✏️ Editar Elemento</h2>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" id="smt-edit-form">
            <?php wp_nonce_field('smt_update_item', 'smt_nonce'); ?>
            <input type="hidden" name="action" value="smt_update_ticker_item">
            <input type="hidden" name="item_id" id="edit_item_id">
            
            <div class="smt-form-group">
                <label for="edit_ticker_value"><strong>Valor:</strong></label>
                <input type="text" id="edit_ticker_value" name="ticker_value" class="regular-text" required>
            </div>
            
            <div class="smt-form-group">
                <label for="edit_ticker_label"><strong>Etiqueta:</strong></label>
                <input type="text" id="edit_ticker_label" name="ticker_label" class="regular-text" required>
            </div>
            
            <div class="smt-form-group">
                <label for="edit_ticker_color"><strong>Color:</strong></label>
                <input type="text" id="edit_ticker_color" name="ticker_color" class="color-picker-edit">
            </div>
            
            <div class="smt-form-actions">
                <button type="submit" class="button button-primary">💾 Actualizar</button>
                <button type="button" class="button smt-modal-close">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Pie de página del desarrollador -->
<div class="smt-footer">
    <hr>
    <p class="smt-developer-info">
        Plugin realizado por <a href="https://www.marindelafuente.com.ar" target="_blank" rel="noopener">José Marin de la Fuente</a>
    </p>
</div>

