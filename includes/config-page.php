<?php
// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Obtener instancia del plugin
$smt_plugin = new Stock_Market_Ticker();
?>

<div class="wrap smt-admin-wrap">
    <h1>🎨 Configuraciones de Diseño</h1>
    
    <?php
    // Mostrar mensajes de estado
    if (isset($_GET['status'])) {
        $status = sanitize_text_field($_GET['status']);
        switch ($status) {
            case 'saved':
                echo '<div class="notice notice-success is-dismissible"><p>¡Configuraciones guardadas correctamente!</p></div>';
                break;
        }
    }
    ?>
    
    <div class="smt-config-container">
        <!-- Panel izquierdo: Configuraciones -->
        <div class="smt-panel smt-config-panel">
            <h2>⚙️ Configuraciones del Ticker</h2>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="smt-config-form">
                <?php wp_nonce_field('smt_save_config', 'smt_nonce'); ?>
                <input type="hidden" name="action" value="smt_save_config">
                
                <!-- Colores -->
                <div class="smt-config-section">
                    <h3>🎨 Colores</h3>
                    
                    <div class="smt-form-group">
                        <label for="background_color">
                            <strong>Color de Fondo:</strong>
                            <span class="description">Color de fondo del ticker</span>
                        </label>
                        <input type="text" 
                               id="background_color" 
                               name="background_color" 
                               class="color-picker" 
                               value="<?php echo esc_attr($smt_plugin->get_config('background_color', '#ffffff')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="border_color">
                            <strong>Color del Borde:</strong>
                            <span class="description">Color del borde del ticker</span>
                        </label>
                        <input type="text" 
                               id="border_color" 
                               name="border_color" 
                               class="color-picker" 
                               value="<?php echo esc_attr($smt_plugin->get_config('border_color', '#e0e0e0')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="text_color">
                            <strong>Color del Texto:</strong>
                            <span class="description">Color general del texto</span>
                        </label>
                        <input type="text" 
                               id="text_color" 
                               name="text_color" 
                               class="color-picker" 
                               value="<?php echo esc_attr($smt_plugin->get_config('text_color', '#333333')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="value_color">
                            <strong>Color del Valor:</strong>
                            <span class="description">Color de los números/valores</span>
                        </label>
                        <input type="text" 
                               id="value_color" 
                               name="value_color" 
                               class="color-picker" 
                               value="<?php echo esc_attr($smt_plugin->get_config('value_color', '#0066ff')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="label_color">
                            <strong>Color de la Etiqueta:</strong>
                            <span class="description">Color de las descripciones</span>
                        </label>
                        <input type="text" 
                               id="label_color" 
                               name="label_color" 
                               class="color-picker" 
                               value="<?php echo esc_attr($smt_plugin->get_config('label_color', '#666666')); ?>">
                    </div>
                </div>
                
                <!-- Tipografía -->
                <div class="smt-config-section">
                    <h3>📝 Tipografía</h3>
                    
                    <div class="smt-form-group">
                        <label for="font_family">
                            <strong>Fuente de Google:</strong>
                            <span class="description">Nombre de la fuente de Google Fonts</span>
                        </label>
                        <select id="font_family" name="font_family" class="regular-text">
                            <option value="Roboto" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Roboto'); ?>>Roboto</option>
                            <option value="Open Sans" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Open Sans'); ?>>Open Sans</option>
                            <option value="Lato" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Lato'); ?>>Lato</option>
                            <option value="Montserrat" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Montserrat'); ?>>Montserrat</option>
                            <option value="Poppins" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Poppins'); ?>>Poppins</option>
                            <option value="Source Sans Pro" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Source Sans Pro'); ?>>Source Sans Pro</option>
                            <option value="Nunito" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Nunito'); ?>>Nunito</option>
                            <option value="Inter" <?php selected($smt_plugin->get_config('font_family', 'Roboto'), 'Inter'); ?>>Inter</option>
                        </select>
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="font_size">
                            <strong>Tamaño de Fuente General:</strong>
                            <span class="description">Tamaño base en píxeles</span>
                        </label>
                        <input type="number" 
                               id="font_size" 
                               name="font_size" 
                               class="regular-text" 
                               min="10" 
                               max="30"
                               value="<?php echo esc_attr($smt_plugin->get_config('font_size', '16')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="font_weight">
                            <strong>Peso de Fuente General:</strong>
                            <span class="description">Grosor de la fuente</span>
                        </label>
                        <select id="font_weight" name="font_weight" class="regular-text">
                            <option value="300" <?php selected($smt_plugin->get_config('font_weight', '400'), '300'); ?>>300 - Light</option>
                            <option value="400" <?php selected($smt_plugin->get_config('font_weight', '400'), '400'); ?>>400 - Normal</option>
                            <option value="500" <?php selected($smt_plugin->get_config('font_weight', '400'), '500'); ?>>500 - Medium</option>
                            <option value="600" <?php selected($smt_plugin->get_config('font_weight', '400'), '600'); ?>>600 - Semi Bold</option>
                            <option value="700" <?php selected($smt_plugin->get_config('font_weight', '400'), '700'); ?>>700 - Bold</option>
                        </select>
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="value_font_size">
                            <strong>Tamaño de Fuente del Valor:</strong>
                            <span class="description">Tamaño de los números en píxeles</span>
                        </label>
                        <input type="number" 
                               id="value_font_size" 
                               name="value_font_size" 
                               class="regular-text" 
                               min="12" 
                               max="40"
                               value="<?php echo esc_attr($smt_plugin->get_config('value_font_size', '24')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="value_font_weight">
                            <strong>Peso de Fuente del Valor:</strong>
                            <span class="description">Grosor de los números</span>
                        </label>
                        <select id="value_font_weight" name="value_font_weight" class="regular-text">
                            <option value="400" <?php selected($smt_plugin->get_config('value_font_weight', '700'), '400'); ?>>400 - Normal</option>
                            <option value="500" <?php selected($smt_plugin->get_config('value_font_weight', '700'), '500'); ?>>500 - Medium</option>
                            <option value="600" <?php selected($smt_plugin->get_config('value_font_weight', '700'), '600'); ?>>600 - Semi Bold</option>
                            <option value="700" <?php selected($smt_plugin->get_config('value_font_weight', '700'), '700'); ?>>700 - Bold</option>
                            <option value="800" <?php selected($smt_plugin->get_config('value_font_weight', '700'), '800'); ?>>800 - Extra Bold</option>
                        </select>
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="label_font_size">
                            <strong>Tamaño de Fuente de la Etiqueta:</strong>
                            <span class="description">Tamaño de las descripciones en píxeles</span>
                        </label>
                        <input type="number" 
                               id="label_font_size" 
                               name="label_font_size" 
                               class="regular-text" 
                               min="10" 
                               max="20"
                               value="<?php echo esc_attr($smt_plugin->get_config('label_font_size', '14')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="label_font_weight">
                            <strong>Peso de Fuente de la Etiqueta:</strong>
                            <span class="description">Grosor de las descripciones</span>
                        </label>
                        <select id="label_font_weight" name="label_font_weight" class="regular-text">
                            <option value="300" <?php selected($smt_plugin->get_config('label_font_weight', '400'), '300'); ?>>300 - Light</option>
                            <option value="400" <?php selected($smt_plugin->get_config('label_font_weight', '400'), '400'); ?>>400 - Normal</option>
                            <option value="500" <?php selected($smt_plugin->get_config('label_font_weight', '400'), '500'); ?>>500 - Medium</option>
                            <option value="600" <?php selected($smt_plugin->get_config('label_font_weight', '400'), '600'); ?>>600 - Semi Bold</option>
                        </select>
                    </div>
                </div>
                
                <!-- Dimensiones y Espaciado -->
                <div class="smt-config-section">
                    <h3>📏 Dimensiones y Espaciado</h3>
                    
                    <div class="smt-form-group">
                        <label for="ticker_height">
                            <strong>Altura del Ticker:</strong>
                            <span class="description">Altura en píxeles</span>
                        </label>
                        <input type="number" 
                               id="ticker_height" 
                               name="ticker_height" 
                               class="regular-text" 
                               min="50" 
                               max="200"
                               value="<?php echo esc_attr($smt_plugin->get_config('ticker_height', '80')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="border_radius">
                            <strong>Radio del Borde:</strong>
                            <span class="description">Redondez de las esquinas en píxeles</span>
                        </label>
                        <input type="number" 
                               id="border_radius" 
                               name="border_radius" 
                               class="regular-text" 
                               min="0" 
                               max="20"
                               value="<?php echo esc_attr($smt_plugin->get_config('border_radius', '8')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="padding_horizontal">
                            <strong>Padding Horizontal:</strong>
                            <span class="description">Espaciado horizontal interno en píxeles</span>
                        </label>
                        <input type="number" 
                               id="padding_horizontal" 
                               name="padding_horizontal" 
                               class="regular-text" 
                               min="5" 
                               max="50"
                               value="<?php echo esc_attr($smt_plugin->get_config('padding_horizontal', '20')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="padding_vertical">
                            <strong>Padding Vertical:</strong>
                            <span class="description">Espaciado vertical interno en píxeles</span>
                        </label>
                        <input type="number" 
                               id="padding_vertical" 
                               name="padding_vertical" 
                               class="regular-text" 
                               min="5" 
                               max="30"
                               value="<?php echo esc_attr($smt_plugin->get_config('padding_vertical', '15')); ?>">
                    </div>
                </div>
                
                <!-- Animación -->
                <div class="smt-config-section">
                    <h3>🎬 Animación</h3>
                    
                    <div class="smt-form-group">
                        <label for="animation_speed">
                            <strong>Velocidad de Animación:</strong>
                            <span class="description">Duración en segundos para completar un ciclo</span>
                        </label>
                        <input type="number" 
                               id="animation_speed" 
                               name="animation_speed" 
                               class="regular-text" 
                               min="5" 
                               max="60"
                               step="1"
                               value="<?php echo esc_attr($smt_plugin->get_config('animation_speed', '20')); ?>">
                    </div>
                    
                    <div class="smt-form-group">
                        <label for="hover_effect">
                            <strong>Efecto Hover:</strong>
                            <span class="description">Activar efecto al pasar el mouse</span>
                        </label>
                        <select id="hover_effect" name="hover_effect" class="regular-text">
                            <option value="1" <?php selected($smt_plugin->get_config('hover_effect', '1'), '1'); ?>>Activado</option>
                            <option value="0" <?php selected($smt_plugin->get_config('hover_effect', '1'), '0'); ?>>Desactivado</option>
                        </select>
                    </div>
                </div>
                
                <!-- Efectos Visuales -->
                <div class="smt-config-section">
                    <h3>✨ Efectos Visuales</h3>
                    
                    <div class="smt-form-group">
                        <label for="box_shadow">
                            <strong>Sombra:</strong>
                            <span class="description">Sombra CSS (ej: 0 2px 8px rgba(0,0,0,0.1))</span>
                        </label>
                        <input type="text" 
                               id="box_shadow" 
                               name="box_shadow" 
                               class="regular-text" 
                               placeholder="0 2px 8px rgba(0,0,0,0.1)"
                               value="<?php echo esc_attr($smt_plugin->get_config('box_shadow', '0 2px 8px rgba(0,0,0,0.1)')); ?>">
                    </div>
                </div>
                
                <div class="smt-form-actions">
                    <button type="submit" class="button button-primary button-large">
                        💾 Guardar Configuraciones
                    </button>
                    <button type="button" class="button button-secondary" onclick="resetToDefaults()">
                        🔄 Restaurar Valores por Defecto
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Panel derecho: Vista previa -->
        <div class="smt-panel smt-preview-panel">
            <h2>👁️ Vista Previa</h2>
            <div class="smt-preview-container">
                <div class="smt-preview-ticker" id="preview-ticker">
                    <div class="smt-ticker-item">
                        <div class="smt-item-color" style="background-color: #F7DC6F;"></div>
                        <div class="smt-item-info">
                            <div class="smt-item-value">282</div>
                            <div class="smt-item-label">cuadras pavimentadas</div>
                        </div>
                    </div>
                    <div class="smt-ticker-item">
                        <div class="smt-item-color" style="background-color: #82E0AA;"></div>
                        <div class="smt-item-info">
                            <div class="smt-item-value">32,750</div>
                            <div class="smt-item-label">baches reparados</div>
                        </div>
                    </div>
                    <div class="smt-ticker-item">
                        <div class="smt-item-color" style="background-color: #85C1E9;"></div>
                        <div class="smt-item-info">
                            <div class="smt-item-value">4,931</div>
                            <div class="smt-item-label">árboles plantados</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="smt-preview-info">
                <h3>📌 Información</h3>
                <p>Esta es una vista previa de cómo se verá el ticker con las configuraciones actuales.</p>
                <p>Los cambios se aplicarán automáticamente cuando guardes las configuraciones.</p>
            </div>
        </div>
    </div>
    
    <!-- Pie de página del desarrollador -->
    <div class="smt-footer">
        <hr>
        <p class="smt-developer-info">
            Plugin realizado por <a href="https://www.marindelafuente.com.ar" target="_blank" rel="noopener">José Marin de la Fuente</a>
        </p>
    </div>
</div>

<script>
function resetToDefaults() {
    if (confirm('¿Estás seguro de restaurar todos los valores por defecto?')) {
        document.getElementById('background_color').value = '#ffffff';
        document.getElementById('border_color').value = '#e0e0e0';
        document.getElementById('border_radius').value = '8';
        document.getElementById('font_family').value = 'Roboto';
        document.getElementById('font_size').value = '16';
        document.getElementById('font_weight').value = '400';
        document.getElementById('text_color').value = '#333333';
        document.getElementById('value_color').value = '#0066ff';
        document.getElementById('value_font_size').value = '24';
        document.getElementById('value_font_weight').value = '700';
        document.getElementById('label_color').value = '#666666';
        document.getElementById('label_font_size').value = '14';
        document.getElementById('label_font_weight').value = '400';
        document.getElementById('animation_speed').value = '20';
        document.getElementById('ticker_height').value = '80';
        document.getElementById('padding_horizontal').value = '20';
        document.getElementById('padding_vertical').value = '15';
        document.getElementById('box_shadow').value = '0 2px 8px rgba(0,0,0,0.1)';
        document.getElementById('hover_effect').value = '1';
        
        updatePreview();
    }
}

function updatePreview() {
    const preview = document.getElementById('preview-ticker');
    const bgColor = document.getElementById('background_color').value;
    const borderColor = document.getElementById('border_color').value;
    const borderRadius = document.getElementById('border_radius').value + 'px';
    const fontFamily = document.getElementById('font_family').value;
    const fontSize = document.getElementById('font_size').value + 'px';
    const fontWeight = document.getElementById('font_weight').value;
    const textColor = document.getElementById('text_color').value;
    const valueColor = document.getElementById('value_color').value;
    const valueFontSize = document.getElementById('value_font_size').value + 'px';
    const valueFontWeight = document.getElementById('value_font_weight').value;
    const labelColor = document.getElementById('label_color').value;
    const labelFontSize = document.getElementById('label_font_size').value + 'px';
    const labelFontWeight = document.getElementById('label_font_weight').value;
    const tickerHeight = document.getElementById('ticker_height').value + 'px';
    const paddingH = document.getElementById('padding_horizontal').value + 'px';
    const paddingV = document.getElementById('padding_vertical').value + 'px';
    const boxShadow = document.getElementById('box_shadow').value;
    
    preview.style.cssText = `
        background-color: ${bgColor};
        border: 1px solid ${borderColor};
        border-radius: ${borderRadius};
        height: ${tickerHeight};
        padding: ${paddingV} ${paddingH};
        box-shadow: ${boxShadow};
        font-family: '${fontFamily}', sans-serif;
        font-size: ${fontSize};
        font-weight: ${fontWeight};
        color: ${textColor};
    `;
    
    // Actualizar estilos de los valores
    const values = preview.querySelectorAll('.smt-item-value');
    values.forEach(value => {
        value.style.cssText = `
            color: ${valueColor};
            font-size: ${valueFontSize};
            font-weight: ${valueFontWeight};
        `;
    });
    
    // Actualizar estilos de las etiquetas
    const labels = preview.querySelectorAll('.smt-item-label');
    labels.forEach(label => {
        label.style.cssText = `
            color: ${labelColor};
            font-size: ${labelFontSize};
            font-weight: ${labelFontWeight};
        `;
    });
}

// Actualizar vista previa cuando cambien los valores
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('change', updatePreview);
        input.addEventListener('input', updatePreview);
    });
    
    // Inicializar vista previa
    updatePreview();
});
</script>
