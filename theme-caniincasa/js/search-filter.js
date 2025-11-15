/**
 * Search and Filter Functionality
 *
 * @package CaninCasa
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * AJAX Filter Handler
     */
    class FilterHandler {
        constructor(formSelector, resultsSelector) {
            this.form = $(formSelector);
            this.results = $(resultsSelector);
            this.loading = false;

            this.init();
        }

        init() {
            if (!this.form.length) return;

            // Bind events
            this.form.on('submit', (e) => this.handleSubmit(e));
            this.form.find('input, select').on('change', () => this.autoSubmit());
        }

        handleSubmit(e) {
            e.preventDefault();
            this.filterResults();
        }

        autoSubmit() {
            // Debounce auto-submit
            clearTimeout(this.submitTimer);
            this.submitTimer = setTimeout(() => {
                this.filterResults();
            }, 500);
        }

        filterResults() {
            if (this.loading) return;

            this.loading = true;
            this.showLoading();

            const formData = this.form.serialize();

            $.ajax({
                url: canincasaAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_razze',
                    nonce: canincasaAjax.nonce,
                    ...this.getFormData()
                },
                success: (response) => {
                    this.handleSuccess(response);
                },
                error: (xhr, status, error) => {
                    this.handleError(error);
                },
                complete: () => {
                    this.loading = false;
                    this.hideLoading();
                }
            });
        }

        getFormData() {
            const data = {};
            this.form.find('input, select, textarea').each(function() {
                const input = $(this);
                const name = input.attr('name');
                const value = input.val();

                if (name && value) {
                    data[name] = value;
                }
            });
            return data;
        }

        handleSuccess(response) {
            if (response.success) {
                this.results.html(response.html);

                // Update count if exists
                if (response.found !== undefined) {
                    $('.results-count').text(response.found + ' risultati trovati');
                }

                // Scroll to results
                $('html, body').animate({
                    scrollTop: this.results.offset().top - 100
                }, 500);
            } else {
                this.handleError(response.data?.message || 'Errore durante il caricamento');
            }
        }

        handleError(message) {
            this.results.html(
                '<div class="alert alert-error">' +
                '<p>' + message + '</p>' +
                '</div>'
            );
        }

        showLoading() {
            this.results.addClass('loading');

            // Add loading spinner
            if (!this.results.find('.loading-spinner').length) {
                this.results.prepend(
                    '<div class="loading-spinner">' +
                    '<div class="spinner"></div>' +
                    '<p>Caricamento...</p>' +
                    '</div>'
                );
            }
        }

        hideLoading() {
            this.results.removeClass('loading');
            this.results.find('.loading-spinner').remove();
        }
    }

    /**
     * Range Slider Display
     */
    function initRangeSliders() {
        $('input[type="range"]').each(function() {
            const range = $(this);
            const output = $('<output class="range-value"></output>');

            range.after(output);

            function updateOutput() {
                output.text(range.val());
            }

            updateOutput();
            range.on('input change', updateOutput);
        });
    }

    /**
     * Reset Filters
     */
    function initResetButton() {
        $('.filter-reset').on('click', function(e) {
            e.preventDefault();

            const form = $(this).closest('form');
            form[0].reset();
            form.trigger('submit');
        });
    }

    /**
     * Initialize on DOM Ready
     */
    $(document).ready(function() {
        // Initialize filter for razze
        if ($('#filter-form-razze').length) {
            new FilterHandler('#filter-form-razze', '#filter-results');
        }

        // Initialize filter for allevamenti
        if ($('#filter-form-allevamenti').length) {
            new FilterHandler('#filter-form-allevamenti', '#filter-results');
        }

        // Initialize range sliders
        initRangeSliders();

        // Initialize reset button
        initResetButton();
    });

})(jQuery);
