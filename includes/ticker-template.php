<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Obtener instancia del plugin para acceder a las configuraciones
$smt_plugin = new Stock_Market_Ticker();

// Obtener configuraciones
$speed = isset($atts['speed']) ? intval($atts['speed']) : $smt_plugin->get_config('animation_speed', 20);
$height = isset($atts['height']) ? intval($atts['height']) : $smt_plugin->get_config('ticker_height', 80);

$background_color = $smt_plugin->get_config('background_color', '#ffffff');
$border_color = $smt_plugin->get_config('border_color', '#e0e0e0');
$border_radius = $smt_plugin->get_config('border_radius', '8');
$font_family = $smt_plugin->get_config('font_family', 'Roboto');
$font_size = $smt_plugin->get_config('font_size', '16');
$font_weight = $smt_plugin->get_config('font_weight', '400');
$text_color = $smt_plugin->get_config('text_color', '#333333');
$value_color = $smt_plugin->get_config('value_color', '#0066ff');
$value_font_size = $smt_plugin->get_config('value_font_size', '24');
$value_font_weight = $smt_plugin->get_config('value_font_weight', '700');
$label_color = $smt_plugin->get_config('label_color', '#666666');
$label_font_size = $smt_plugin->get_config('label_font_size', '14');
$label_font_weight = $smt_plugin->get_config('label_font_weight', '400');
$padding_horizontal = $smt_plugin->get_config('padding_horizontal', '20');
$padding_vertical = $smt_plugin->get_config('padding_vertical', '15');
$box_shadow = $smt_plugin->get_config('box_shadow', '0 2px 8px rgba(0,0,0,0.1)');
$hover_effect = $smt_plugin->get_config('hover_effect', '1');

// Crear estilos CSS dinámicos
$ticker_styles = "
    background-color: {$background_color};
    border: 1px solid {$border_color};
    border-radius: {$border_radius}px;
    font-family: '{$font_family}', sans-serif;
    font-size: {$font_size}px;
    font-weight: {$font_weight};
    color: {$text_color};
    padding: {$padding_vertical}px {$padding_horizontal}px;
    box-shadow: {$box_shadow};
";

$value_styles = "
    color: {$value_color};
    font-size: {$value_font_size}px;
    font-weight: {$value_font_weight};
";

$label_styles = "
    color: {$label_color};
    font-size: {$label_font_size}px;
    font-weight: {$label_font_weight};
";

$hover_class = $hover_effect == '1' ? 'smt-hover-effect' : '';
?>

<div class="smt-ticker-container <?php echo $hover_class; ?>" style="height: <?php echo $height; ?>px;">
    <div class="smt-ticker-wrapper" style="animation-duration: <?php echo $speed; ?>s;">
        <?php
        // Crear 3 copias para loop infinito
        for ($copy = 0; $copy < 3; $copy++) :
            foreach ($items as $item) :
        ?>
            <div class="smt-ticker-item" style="<?php echo $ticker_styles; ?>">
                <div class="smt-color-square" style="background-color: <?php echo esc_attr($item->ticker_color); ?>"></div>
                <span class="smt-ticker-value" style="<?php echo $value_styles; ?>"><?php echo esc_html($item->ticker_value); ?></span>
                <span class="smt-ticker-label" style="<?php echo $label_styles; ?>"><?php echo esc_html($item->ticker_label); ?></span>
            </div>
        <?php
            endforeach;
        endfor;
        ?>
    </div>
</div>


