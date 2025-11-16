/**
 * Richieste Strutture JavaScript
 * Handles richieste strutture form
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    /**
     * Richiesta Form Handler
     */
    function initRichiestaForm() {
        const $form = $('#richiesta-struttura-form');

        if (!$form.length) {
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            const tipoAzione = $form.data('azione');

            // Validate motivazione for modifica/rimozione
            if (tipoAzione === 'modifica' || tipoAzione === 'rimozione') {
                const motivazione = $('#motivazione').val().trim();
                if (motivazione.length < 50) {
                    showFormMessage($form, 'error', 'La motivazione deve essere almeno 50 caratteri (attualmente: ' + motivazione.length + ')');
                    return;
                }
            }

            // Get form data
            const formData = new FormData();
            formData.append('action', 'caniincasa_submit_richiesta');
            formData.append('nonce', $form.find('input[name="richiesta_nonce"]').val());
            formData.append('tipo_struttura', $('input[name="tipo_struttura"]').val());
            formData.append('tipo_azione', $('input[name="tipo_azione"]').val());

            // Add all form fields
            const fields = [
                'nome_struttura_esistente',
                'nome_struttura',
                'indirizzo',
                'provincia',
                'comune',
                'cap',
                'telefono',
                'email',
                'sito_web',
                'descrizione',
                'motivazione',
                'note',
                'razze_allevate'
            ];

            fields.forEach(function(field) {
                const value = $('[name="' + field + '"]').val();
                if (value) {
                    formData.append(field, value);
                }
            });

            // Add checkbox
            if ($('[name="enci_riconosciuto"]:checked').length) {
                formData.append('enci_riconosciuto', '1');
            }

            // Show loading state
            const $submitBtn = $form.find('button[type="submit"]');
            const $btnText = $submitBtn.find('.btn-text');
            const $btnLoading = $submitBtn.find('.btn-loading');

            $submitBtn.prop('disabled', true);
            $btnText.hide();
            $btnLoading.show();

            // AJAX request
            $.ajax({
                url: caniincasaDashboard.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        showFormMessage($form, 'success', response.data.message);

                        // Clear form
                        $form[0].reset();

                        // Redirect after 3 seconds
                        setTimeout(function() {
                            window.location.href = '/dashboard/';
                        }, 3000);
                    } else {
                        showFormMessage($form, 'error', response.data.message);
                        $submitBtn.prop('disabled', false);
                        $btnText.show();
                        $btnLoading.hide();
                    }
                },
                error: function() {
                    showFormMessage($form, 'error', 'Si è verificato un errore. Riprova.');
                    $submitBtn.prop('disabled', false);
                    $btnText.show();
                    $btnLoading.hide();
                }
            });
        });
    }

    /**
     * Show form message
     */
    function showFormMessage($form, type, message) {
        const $messageBox = $form.find('.form-message').last();

        $messageBox
            .removeClass('success error info')
            .addClass(type)
            .html(message)
            .slideDown(300);

        // Scroll to message
        $('html, body').animate({
            scrollTop: $messageBox.offset().top - 100
        }, 300);
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        initRichiestaForm();
    });

})(jQuery);
