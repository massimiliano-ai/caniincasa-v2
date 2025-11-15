/**
 * Archivi Filtri JavaScript
 * Handles AJAX filtering for archive pages
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    /**
     * Archive Filters Handler
     */
    function initArchiveFilters() {
        const $filterSelect = $('#filter-provincia');
        const $resetButton = $('#reset-filters');
        const $itemsGrid = $('#items-grid');
        const $resultsInfo = $('.results-info');
        const $loadingSpinner = $('#loading-spinner');

        if (!$filterSelect.length) {
            return;
        }

        const postType = $filterSelect.data('post-type');

        /**
         * Perform AJAX filter
         */
        function performFilter() {
            const provincia = $filterSelect.val();

            // Show loading
            $loadingSpinner.fadeIn(200);
            $itemsGrid.css('opacity', '0.5');

            $.ajax({
                url: canincasaAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'filter_archive_by_provincia',
                    nonce: canincasaAjax.nonce,
                    post_type: postType,
                    provincia: provincia
                },
                success: function(response) {
                    if (response.success) {
                        // Update grid
                        $itemsGrid.html(response.data.html);

                        // Update results count
                        $resultsInfo.html(response.data.results_info);

                        // Animate
                        $itemsGrid.css('opacity', '1');
                        $loadingSpinner.fadeOut(200);

                        // Scroll to results
                        $('html, body').animate({
                            scrollTop: $resultsInfo.offset().top - 100
                        }, 500);
                    } else {
                        console.error('Filter error:', response.data);
                        alert('Errore durante il filtraggio. Riprova.');
                        $loadingSpinner.fadeOut(200);
                        $itemsGrid.css('opacity', '1');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    alert('Errore di connessione. Riprova.');
                    $loadingSpinner.fadeOut(200);
                    $itemsGrid.css('opacity', '1');
                }
            });
        }

        /**
         * Reset filters
         */
        function resetFilters() {
            $filterSelect.val('');
            performFilter();
        }

        // Event listeners
        $filterSelect.on('change', performFilter);
        $resetButton.on('click', function(e) {
            e.preventDefault();
            resetFilters();
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        initArchiveFilters();
    });

})(jQuery);
