/**
 * Authentication Forms JavaScript
 * Handles AJAX registration and login
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    /**
     * Registration Form Handler
     */
    function initRegistrationForm() {
        const $form = $('#registration-form');

        if (!$form.length) {
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            clearFormErrors($form);

            // Get form data
            const formData = {
                action: 'caniincasa_register',
                nonce: $form.find('input[name="nonce"]').val(),
                nome: $form.find('#nome').val().trim(),
                cognome: $form.find('#cognome').val().trim(),
                username: $form.find('#username').val().trim(),
                email: $form.find('#email').val().trim(),
                telefono: $form.find('#telefono').val().trim(),
                password: $form.find('#password').val(),
                password_confirm: $form.find('#password_confirm').val(),
                privacy: $form.find('#privacy').is(':checked') ? '1' : '0'
            };

            // Client-side validation
            if (!validateRegistrationForm(formData, $form)) {
                return false;
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
                url: caniincasaAuth.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showFormMessage($form, 'success', response.data.message);

                        // Redirect to dashboard after 1 second
                        setTimeout(function() {
                            window.location.href = response.data.redirect;
                        }, 1000);
                    } else {
                        showFormMessage($form, 'error', response.data.message);
                        $submitBtn.prop('disabled', false);
                        $btnText.show();
                        $btnLoading.hide();
                    }
                },
                error: function(xhr, status, error) {
                    showFormMessage($form, 'error', 'Si è verificato un errore. Riprova più tardi.');
                    $submitBtn.prop('disabled', false);
                    $btnText.show();
                    $btnLoading.hide();
                }
            });
        });
    }

    /**
     * Login Form Handler
     */
    function initLoginForm() {
        const $form = $('#login-form');

        if (!$form.length) {
            return;
        }

        $form.on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            clearFormErrors($form);

            // Get form data
            const formData = {
                action: 'caniincasa_login',
                nonce: $form.find('input[name="nonce"]').val(),
                username: $form.find('#username').val().trim(),
                password: $form.find('#password').val(),
                remember: $form.find('#remember').is(':checked') ? '1' : '0'
            };

            // Client-side validation
            if (!validateLoginForm(formData, $form)) {
                return false;
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
                url: caniincasaAuth.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        showFormMessage($form, 'success', response.data.message);

                        // Redirect to dashboard after 1 second
                        setTimeout(function() {
                            window.location.href = response.data.redirect;
                        }, 1000);
                    } else {
                        showFormMessage($form, 'error', response.data.message);
                        $submitBtn.prop('disabled', false);
                        $btnText.show();
                        $btnLoading.hide();
                    }
                },
                error: function(xhr, status, error) {
                    showFormMessage($form, 'error', 'Si è verificato un errore. Riprova più tardi.');
                    $submitBtn.prop('disabled', false);
                    $btnText.show();
                    $btnLoading.hide();
                }
            });
        });
    }

    /**
     * Validate Registration Form
     */
    function validateRegistrationForm(data, $form) {
        let isValid = true;

        // Nome
        if (data.nome.length < 2) {
            showFieldError($form.find('#nome'), 'Il nome deve contenere almeno 2 caratteri');
            isValid = false;
        }

        // Cognome
        if (data.cognome.length < 2) {
            showFieldError($form.find('#cognome'), 'Il cognome deve contenere almeno 2 caratteri');
            isValid = false;
        }

        // Username
        if (data.username.length < 4) {
            showFieldError($form.find('#username'), 'Lo username deve contenere almeno 4 caratteri');
            isValid = false;
        } else if (!/^[a-zA-Z0-9_]+$/.test(data.username)) {
            showFieldError($form.find('#username'), 'Lo username può contenere solo lettere, numeri e underscore');
            isValid = false;
        }

        // Email
        if (!isValidEmail(data.email)) {
            showFieldError($form.find('#email'), 'Inserisci un indirizzo email valido');
            isValid = false;
        }

        // Telefono (optional but validate if provided)
        if (data.telefono && data.telefono.length > 0) {
            if (!/^[0-9+\s\-()]+$/.test(data.telefono)) {
                showFieldError($form.find('#telefono'), 'Inserisci un numero di telefono valido');
                isValid = false;
            }
        }

        // Password
        if (data.password.length < 8) {
            showFieldError($form.find('#password'), 'La password deve contenere almeno 8 caratteri');
            isValid = false;
        }

        // Password confirm
        if (data.password !== data.password_confirm) {
            showFieldError($form.find('#password_confirm'), 'Le password non coincidono');
            isValid = false;
        }

        // Privacy
        if (data.privacy !== '1') {
            showFormMessage($form, 'error', 'Devi accettare la Privacy Policy per registrarti');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Validate Login Form
     */
    function validateLoginForm(data, $form) {
        let isValid = true;

        // Username
        if (data.username.length === 0) {
            showFieldError($form.find('#username'), 'Inserisci username o email');
            isValid = false;
        }

        // Password
        if (data.password.length === 0) {
            showFieldError($form.find('#password'), 'Inserisci la password');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Show field error
     */
    function showFieldError($field, message) {
        $field.addClass('error');

        // Add or update error message
        let $errorMsg = $field.siblings('.field-error');

        if (!$errorMsg.length) {
            $errorMsg = $('<span class="field-error"></span>');
            $field.after($errorMsg);
        }

        $errorMsg.text(message).addClass('active');

        // Remove error on input
        $field.one('input', function() {
            $field.removeClass('error');
            $errorMsg.removeClass('active');
        });
    }

    /**
     * Clear form errors
     */
    function clearFormErrors($form) {
        $form.find('.error').removeClass('error');
        $form.find('.field-error').removeClass('active');
        $form.find('.form-message').hide().removeClass('success error info');
    }

    /**
     * Show form message
     */
    function showFormMessage($form, type, message) {
        const $messageBox = $form.find('.form-message');

        $messageBox
            .removeClass('success error info')
            .addClass(type)
            .html(message)
            .slideDown(300);
    }

    /**
     * Validate email format
     */
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    /**
     * Real-time username validation (check availability)
     */
    function initUsernameCheck() {
        const $usernameField = $('#username');

        if (!$usernameField.length || $usernameField.closest('#login-form').length) {
            return; // Only for registration form
        }

        let checkTimeout;

        $usernameField.on('input', function() {
            clearTimeout(checkTimeout);

            const username = $(this).val().trim();

            if (username.length < 4) {
                return;
            }

            checkTimeout = setTimeout(function() {
                $.ajax({
                    url: caniincasaAuth.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'caniincasa_check_username',
                        username: username
                    },
                    success: function(response) {
                        if (!response.success) {
                            showFieldError($usernameField, response.data.message);
                        }
                    }
                });
            }, 500);
        });
    }

    /**
     * Real-time email validation (check availability)
     */
    function initEmailCheck() {
        const $emailField = $('#email');

        if (!$emailField.length || $emailField.closest('#login-form').length) {
            return; // Only for registration form
        }

        let checkTimeout;

        $emailField.on('input', function() {
            clearTimeout(checkTimeout);

            const email = $(this).val().trim();

            if (!isValidEmail(email)) {
                return;
            }

            checkTimeout = setTimeout(function() {
                $.ajax({
                    url: caniincasaAuth.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'caniincasa_check_email',
                        email: email
                    },
                    success: function(response) {
                        if (!response.success) {
                            showFieldError($emailField, response.data.message);
                        }
                    }
                });
            }, 500);
        });
    }

    /**
     * Password strength indicator
     */
    function initPasswordStrength() {
        const $passwordField = $('#password');

        if (!$passwordField.length || $passwordField.closest('#login-form').length) {
            return; // Only for registration form
        }

        // Add strength indicator after password field
        const $strengthIndicator = $('<div class="password-strength"><div class="strength-bar"></div><span class="strength-text"></span></div>');
        $passwordField.after($strengthIndicator);

        $passwordField.on('input', function() {
            const password = $(this).val();
            const strength = calculatePasswordStrength(password);

            const $bar = $strengthIndicator.find('.strength-bar');
            const $text = $strengthIndicator.find('.strength-text');

            $bar.removeClass('weak medium strong').addClass(strength.class);
            $bar.css('width', strength.width);
            $text.text(strength.text);
        });
    }

    /**
     * Calculate password strength
     */
    function calculatePasswordStrength(password) {
        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        if (strength <= 2) {
            return { class: 'weak', width: '33%', text: 'Debole' };
        } else if (strength <= 4) {
            return { class: 'medium', width: '66%', text: 'Media' };
        } else {
            return { class: 'strong', width: '100%', text: 'Forte' };
        }
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        initRegistrationForm();
        initLoginForm();
        initUsernameCheck();
        initEmailCheck();
        initPasswordStrength();
    });

})(jQuery);
