jQuery(document).ready(function($) {
    
    // Inicializar color picker
    $('.color-picker').wpColorPicker();
    
    // Función para copiar shortcode
    $('.smt-copy-btn').on('click', function() {
        var text = $(this).data('clipboard');
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
        
        // Feedback visual
        var $btn = $(this);
        var originalText = $btn.text();
        $btn.text('✅ Copiado!');
        setTimeout(function() {
            $btn.text(originalText);
        }, 2000);
    });
    
    // Abrir modal de edición
    $('.smt-edit-btn').on('click', function() {
        var itemId = $(this).data('id');
        
        // Obtener datos del item via AJAX
        $.ajax({
            url: smtAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'smt_get_ticker_item',
                item_id: itemId,
                nonce: smtAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    var item = response.data;
                    
                    // Llenar el formulario
                    $('#edit_item_id').val(item.id);
                    $('#edit_ticker_value').val(item.ticker_value);
                    $('#edit_ticker_label').val(item.ticker_label);
                    $('#edit_ticker_color').val(item.ticker_color);
                    
                    // Inicializar color picker en el modal
                    if ($('.color-picker-edit').hasClass('wp-color-picker')) {
                        $('.color-picker-edit').wpColorPicker('color', item.ticker_color);
                    } else {
                        $('.color-picker-edit').wpColorPicker();
                    }
                    
                    // Mostrar modal
                    $('#smt-edit-modal').fadeIn(300);
                } else {
                    alert('Error al cargar el elemento: ' + response.data);
                }
            },
            error: function() {
                alert('Error de conexión al servidor.');
            }
        });
    });
    
    // Cerrar modal
    $('.smt-modal-close').on('click', function() {
        $('#smt-edit-modal').fadeOut(300);
    });
    
    // Cerrar modal al hacer clic fuera
    $(window).on('click', function(event) {
        if ($(event.target).is('#smt-edit-modal')) {
            $('#smt-edit-modal').fadeOut(300);
        }
    });
    
    // Cerrar modal con ESC
    $(document).on('keydown', function(event) {
        if (event.key === 'Escape') {
            $('#smt-edit-modal').fadeOut(300);
        }
    });
    
    // Validación del formulario principal
    $('.smt-form').on('submit', function(e) {
        var value = $('#ticker_value').val().trim();
        var label = $('#ticker_label').val().trim();
        
        if (value === '' || label === '') {
            e.preventDefault();
            alert('Por favor, completa todos los campos requeridos.');
            return false;
        }
    });
    
    // Validación del formulario de edición
    $('#smt-edit-form').on('submit', function(e) {
        var value = $('#edit_ticker_value').val().trim();
        var label = $('#edit_ticker_label').val().trim();
        
        if (value === '' || label === '') {
            e.preventDefault();
            alert('Por favor, completa todos los campos requeridos.');
            return false;
        }
    });
    
    // Auto-dismiss notices after 5 seconds
    setTimeout(function() {
        $('.notice.is-dismissible').fadeOut(300);
    }, 5000);
});


