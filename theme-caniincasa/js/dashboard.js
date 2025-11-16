/**
 * Dashboard JavaScript
 * Handles dashboard interactions
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    /**
     * Profile Form Handler
     */
    function initProfileForm() {
        const $form = $('#profile-form');

        if (!$form.length) {
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData();
            formData.append('action', 'caniincasa_update_profile');
            formData.append('nonce', $form.find('input[name="profile_nonce"]').val());
            formData.append('first_name', $('#first_name').val().trim());
            formData.append('last_name', $('#last_name').val().trim());
            formData.append('email', $('#email').val().trim());
            formData.append('telefono', $('#telefono').val().trim());
            formData.append('bio', $('#bio').val().trim());

            const currentPassword = $('#current_password').val();
            const newPassword = $('#new_password').val();
            const confirmPassword = $('#confirm_password').val();

            if (currentPassword || newPassword || confirmPassword) {
                if (!currentPassword) {
                    showFormMessage($form, 'error', 'Inserisci la password attuale per cambiarla');
                    return;
                }

                if (newPassword.length < 8) {
                    showFormMessage($form, 'error', 'La nuova password deve essere almeno 8 caratteri');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    showFormMessage($form, 'error', 'Le nuove password non coincidono');
                    return;
                }

                formData.append('current_password', currentPassword);
                formData.append('new_password', newPassword);
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

                        // Clear password fields
                        $('#current_password, #new_password, #confirm_password').val('');
                    } else {
                        showFormMessage($form, 'error', response.data.message);
                    }

                    $submitBtn.prop('disabled', false);
                    $btnText.show();
                    $btnLoading.hide();
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
     * Cucciolata Form Handler
     */
    function initCucciolataForm() {
        const $form = $('#cucciolata-form');

        if (!$form.length) {
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            // Validate
            if (!$('#terms').is(':checked')) {
                showFormMessage($form, 'error', 'Devi accettare i Termini e Condizioni');
                return;
            }

            // Get form data
            const formData = new FormData();
            formData.append('action', 'caniincasa_submit_cucciolata');
            formData.append('nonce', $form.find('input[name="cucciolata_nonce"]').val());
            formData.append('titolo', $('#titolo').val().trim());
            formData.append('razza', $('#razza').val());
            formData.append('data_nascita', $('#data_nascita').val());
            formData.append('numero_maschi', $('#numero_maschi').val());
            formData.append('numero_femmine', $('#numero_femmine').val());
            formData.append('prezzo', $('#prezzo').val());
            formData.append('pedigree', $('#pedigree').val());
            formData.append('provincia', $('#provincia').val());
            formData.append('descrizione', $('#descrizione').val().trim());

            // Add images
            const images = $('#immagini')[0].files;
            if (images.length > 5) {
                showFormMessage($form, 'error', 'Puoi caricare massimo 5 immagini');
                return;
            }

            for (let i = 0; i < images.length; i++) {
                if (images[i].size > 2 * 1024 * 1024) {
                    showFormMessage($form, 'error', 'Ogni immagine deve essere massimo 2MB');
                    return;
                }
                formData.append('immagini[]', images[i]);
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

                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = '?tab=annunci';
                        }, 2000);
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
     * Delete Annuncio Handler
     */
    function initDeleteAnnuncio() {
        $(document).on('click', '.delete-annuncio', function(e) {
            e.preventDefault();

            if (!confirm('Sei sicuro di voler eliminare questo annuncio?')) {
                return;
            }

            const $btn = $(this);
            const postId = $btn.data('id');
            const $card = $btn.closest('.annuncio-card');

            $btn.prop('disabled', true).text('Eliminazione...');

            $.ajax({
                url: caniincasaDashboard.ajaxurl,
                type: 'POST',
                data: {
                    action: 'caniincasa_delete_annuncio',
                    post_id: postId,
                    nonce: caniincasaDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $card.fadeOut(300, function() {
                            $(this).remove();

                            // Check if no more annunci
                            if ($('.annuncio-card').length === 0) {
                                location.reload();
                            }
                        });
                    } else {
                        alert(response.data.message);
                        $btn.prop('disabled', false).text('Elimina');
                    }
                },
                error: function() {
                    alert('Si è verificato un errore. Riprova.');
                    $btn.prop('disabled', false).text('Elimina');
                }
            });
        });
    }

    /**
     * Approve Post Handler (Moderation)
     */
    function initApprovePost() {
        $(document).on('click', '.approve-post', function(e) {
            e.preventDefault();

            const $btn = $(this);
            const postId = $btn.data('id');
            const $card = $btn.closest('.moderation-card');

            $btn.prop('disabled', true).text('Approvazione...');

            $.ajax({
                url: caniincasaDashboard.ajaxurl,
                type: 'POST',
                data: {
                    action: 'caniincasa_approve_post',
                    post_id: postId,
                    nonce: caniincasaDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $card.fadeOut(300, function() {
                            $(this).remove();

                            // Check if no more pending
                            if ($('.moderation-card').length === 0) {
                                location.reload();
                            }
                        });
                    } else {
                        alert(response.data.message);
                        $btn.prop('disabled', false).text('✓ Approva');
                    }
                },
                error: function() {
                    alert('Si è verificato un errore. Riprova.');
                    $btn.prop('disabled', false).text('✓ Approva');
                }
            });
        });
    }

    /**
     * Reject Post Handler (Moderation)
     */
    function initRejectPost() {
        $(document).on('click', '.reject-post', function(e) {
            e.preventDefault();

            const reason = prompt('Inserisci il motivo del rifiuto (opzionale):');
            if (reason === null) {
                return; // User cancelled
            }

            const $btn = $(this);
            const postId = $btn.data('id');
            const $card = $btn.closest('.moderation-card');

            $btn.prop('disabled', true).text('Rifiuto...');

            $.ajax({
                url: caniincasaDashboard.ajaxurl,
                type: 'POST',
                data: {
                    action: 'caniincasa_reject_post',
                    post_id: postId,
                    reason: reason,
                    nonce: caniincasaDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $card.fadeOut(300, function() {
                            $(this).remove();

                            // Check if no more pending
                            if ($('.moderation-card').length === 0) {
                                location.reload();
                            }
                        });
                    } else {
                        alert(response.data.message);
                        $btn.prop('disabled', false).text('✗ Rifiuta');
                    }
                },
                error: function() {
                    alert('Si è verificato un errore. Riprova.');
                    $btn.prop('disabled', false).text('✗ Rifiuta');
                }
            });
        });
    }

    /**
     * New Segnalazione Handler
     */
    function initNuovaSegnalazione() {
        $('#btn-nuova-segnalazione').on('click', function() {
            const tipo = prompt('Che tipo di segnalazione vuoi inviare?\n(es: Informazione errata, Contenuto mancante, Altro)');
            if (!tipo) return;

            const contenuto = prompt('Descrivi la segnalazione:');
            if (!contenuto) return;

            const postId = prompt('ID del post/razza da segnalare (opzionale, premi OK se non applicabile):');

            $.ajax({
                url: caniincasaDashboard.ajaxurl,
                type: 'POST',
                data: {
                    action: 'caniincasa_submit_segnalazione',
                    tipo: tipo,
                    contenuto: contenuto,
                    post_id: postId || '',
                    nonce: caniincasaDashboard.nonce
                },
                success: function(response) {
                    if (response.success) {
                        alert('Segnalazione inviata con successo!');
                        location.reload();
                    } else {
                        alert(response.data.message);
                    }
                },
                error: function() {
                    alert('Si è verificato un errore. Riprova.');
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
     * Date input max date (today)
     */
    function initDateLimits() {
        const today = new Date().toISOString().split('T')[0];
        $('#data_nascita').attr('max', today);
    }

    /**
     * Image preview
     */
    function initImagePreview() {
        $('#immagini').on('change', function(e) {
            const files = e.target.files;

            // Remove existing preview
            $('.image-preview-container').remove();

            if (files.length === 0) {
                return;
            }

            const $preview = $('<div class="image-preview-container"></div>');

            for (let i = 0; i < Math.min(files.length, 5); i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const $img = $('<div class="image-preview"><img src="' + e.target.result + '" alt="Preview"></div>');
                    $preview.append($img);
                };

                reader.readAsDataURL(file);
            }

            $(this).after($preview);
        });
    }

    /**
     * Struttura Form - Dynamic Fields
     */
    function initStrutturaForm() {
        // Handle radio button change
        $('input[name="tipo_struttura"]').on('change', function() {
            const selectedType = $(this).val();

            // Hide all specific fields
            $('.specific-fields').hide();

            // Show common fields
            $('#common-fields').slideDown(300);

            // Show specific fields for selected type
            $('#' + selectedType + '-fields').slideDown(300);

            // Show submit section
            $('#submit-section').slideDown(300);
        });

        // Handle form submission
        const $form = $('#struttura-form');

        if (!$form.length) {
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            // Validate
            if (!$('#terms_struttura').is(':checked')) {
                showFormMessage($form, 'error', 'Devi accettare i Termini e Condizioni');
                return;
            }

            const tipoStruttura = $('input[name="tipo_struttura"]:checked').val();
            if (!tipoStruttura) {
                showFormMessage($form, 'error', 'Seleziona il tipo di struttura');
                return;
            }

            // Get form data
            const formData = new FormData();
            formData.append('action', 'caniincasa_submit_struttura');
            formData.append('nonce', $form.find('input[name="struttura_nonce"]').val());
            formData.append('tipo_struttura', tipoStruttura);
            formData.append('titolo_struttura', $('#titolo_struttura').val().trim());
            formData.append('descrizione_struttura', $('#descrizione_struttura').val().trim());
            formData.append('indirizzo', $('#indirizzo').val().trim());
            formData.append('comune', $('#comune').val().trim());
            formData.append('provincia_struttura', $('#provincia_struttura').val());
            formData.append('cap', $('#cap').val().trim());
            formData.append('telefono_struttura', $('#telefono_struttura').val().trim());
            formData.append('email_struttura', $('#email_struttura').val().trim());
            formData.append('sito_web', $('#sito_web').val().trim());

            // Add specific fields based on structure type
            if (tipoStruttura === 'allevamenti') {
                formData.append('affisso', $('#affisso').val().trim());
                formData.append('proprietario', $('#proprietario').val().trim());
            } else if (tipoStruttura === 'struttureveterinarie') {
                formData.append('tipologia', $('#tipologia').val());
                formData.append('direttore_sanitario', $('#direttore_sanitario').val().trim());
                formData.append('pronto_soccorso_h24', $('input[name="pronto_soccorso_h24"]').is(':checked') ? '1' : '0');
                formData.append('reperibilita_h24', $('input[name="reperibilita_h24"]').is(':checked') ? '1' : '0');
                formData.append('orari_apertura', $('#orari_apertura').val().trim());
            } else if (tipoStruttura === 'centri_cinofili') {
                formData.append('servizi_offerti', $('#servizi_offerti').val().trim());
            } else if (tipoStruttura === 'pensioni_per_cani') {
                formData.append('servizi_pensione', $('#servizi_pensione').val().trim());
            } else if (tipoStruttura === 'canili') {
                formData.append('riferimento', $('#riferimento').val().trim());
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

                        // Redirect after 2 seconds
                        setTimeout(function() {
                            window.location.href = '?tab=profilo';
                        }, 2000);
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
     * Initialize on document ready
     */
    $(document).ready(function() {
        initProfileForm();
        initCucciolataForm();
        initStrutturaForm();
        initDeleteAnnuncio();
        initApprovePost();
        initRejectPost();
        initNuovaSegnalazione();
        initDateLimits();
        initImagePreview();
    });

})(jQuery);
