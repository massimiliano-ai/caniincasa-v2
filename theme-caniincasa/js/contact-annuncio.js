/**
 * Contact Annuncio Form Handler
 * Gestisce l'invio dei messaggi agli autori degli annunci
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        /**
         * Handle Contact Form Submission
         */
        $('#contact-annuncio-form').on('submit', function(e) {
            e.preventDefault();

            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');
            var $responseDiv = $('#contact-response');

            // Get form data
            var formData = {
                action: 'caniincasa_send_message',
                nonce: $form.find('#message_nonce').val(),
                annuncio_id: $form.find('input[name="annuncio_id"]').val(),
                tipo_annuncio: $form.find('input[name="tipo_annuncio"]').val(),
                messaggio: $form.find('#messaggio').val(),
                telefono: $form.find('#telefono').val()
            };

            // Validate
            if (!formData.messaggio.trim()) {
                showMessage('error', 'Per favore inserisci un messaggio');
                return;
            }

            // Disable submit button
            $submitBtn.prop('disabled', true).html('⏳ Invio in corso...');
            $responseDiv.html('');

            // Send AJAX request
            $.ajax({
                url: caniincasa_ajax.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showMessage('success', response.data.message);
                        $form[0].reset();

                        // Scroll to message
                        $('html, body').animate({
                            scrollTop: $responseDiv.offset().top - 100
                        }, 500);
                    } else {
                        showMessage('error', response.data.message || 'Errore durante l\'invio del messaggio');
                    }
                },
                error: function() {
                    showMessage('error', 'Errore di connessione. Riprova più tardi.');
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).html('📤 Invia Messaggio');
                }
            });
        });

        /**
         * Show Response Message
         */
        function showMessage(type, message) {
            var $responseDiv = $('#contact-response');
            var className = type === 'success' ? 'form-message success' : 'form-message error';
            var icon = type === 'success' ? '✓' : '✗';

            $responseDiv.html(
                '<div class="' + className + '">' +
                '<strong>' + icon + '</strong> ' + message +
                '</div>'
            );

            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
                setTimeout(function() {
                    $responseDiv.fadeOut(function() {
                        $(this).html('').show();
                    });
                }, 5000);
            }
        }

    });

})(jQuery);
