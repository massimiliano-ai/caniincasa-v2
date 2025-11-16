/**
 * Page Template: Archivio Razze - AJAX Filters
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    // State
    let currentPage = 1;
    let isLoading = false;
    let lastFilters = {};
    let currentView = 'grid';

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        init();
    });

    /**
     * Initialize filters
     */
    function init() {
        // Verifica che razzeFilters sia definito
        if (typeof razzeFilters === 'undefined') {
            console.error('ERRORE CRITICO: razzeFilters non è definito!');
            console.error('Il template potrebbe non aver caricato correttamente lo script PHP.');
            $('#razze-results').html('<div class="error-message" style="padding: 20px; background: #fee; border: 2px solid #c33; margin: 20px 0;">' +
                '<h3>Errore di configurazione</h3>' +
                '<p>Le variabili JavaScript non sono state caricate correttamente.</p>' +
                '<p>Verifica che il template sia attivo e che non ci siano errori PHP.</p>' +
                '</div>');
            return;
        }

        console.log('Init razze filters');
        console.log('razzeFilters:', razzeFilters);

        // Load initial results
        applyFilters();

        // Event listeners
        bindEvents();

        // Update range slider displays
        updateRangeDisplays();
    }

    /**
     * Bind event listeners
     */
    function bindEvents() {
        // Search input con debounce
        let searchTimeout;
        $('#search-breed').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentPage = 1;
                applyFilters();
            }, 500);
        });

        // Checkboxes dimensione
        $('.filter-input[type="checkbox"]').on('change', function() {
            currentPage = 1;
            applyFilters();
        });

        // Range sliders - update display
        $('.range-slider').on('input', function() {
            updateRangeDisplays();
        });

        // Range sliders - apply filters
        $('.range-slider').on('change', function() {
            currentPage = 1;
            applyFilters();
        });

        // Sort select
        $('#filter-sort').on('change', function() {
            currentPage = 1;
            applyFilters();
        });

        // Reset button
        $('#reset-filters').on('click', resetFilters);

        // Load more button
        $('#load-more').on('click', loadMore);

        // View toggle buttons
        $('.view-btn').on('click', function() {
            const view = $(this).data('view');
            toggleView(view);
        });
    }

    /**
     * Update range slider value displays
     */
    function updateRangeDisplays() {
        // Energy
        const energy = parseFloat($('#filter-energy').val());
        $('#energy-value').text(energy === 0 ? 'Tutti' : energy.toFixed(1));

        // Apartment
        const apartment = parseFloat($('#filter-apartment').val());
        $('#apartment-value').text(apartment === 0 ? 'Tutti' : apartment.toFixed(1));

        // Affection (Affettuosità)
        const affection = parseFloat($('#filter-affection').val());
        $('#affection-value').text(affection === 0 ? 'Tutti' : affection.toFixed(1));

        // Strangers (Tolleranza Estranei)
        const strangers = parseFloat($('#filter-strangers').val());
        $('#strangers-value').text(strangers === 0 ? 'Tutti' : strangers.toFixed(1));

        // Vocality (Vocalità)
        const vocality = parseFloat($('#filter-vocality').val());
        $('#vocality-value').text(vocality === 0 ? 'Tutti' : vocality.toFixed(1));

        // Kids
        const kids = parseFloat($('#filter-kids').val());
        $('#kids-value').text(kids === 0 ? 'Tutti' : kids.toFixed(1));

        // Experience
        const experience = parseFloat($('#filter-experience').val());
        if (experience === 5) {
            $('#experience-value').text('Tutti');
        } else {
            $('#experience-value').text(experience.toFixed(1));
        }
    }

    /**
     * Collect current filter values
     */
    function collectFilters() {
        const filters = {
            search: $('#search-breed').val(),
            sizes: [],
            energy: parseFloat($('#filter-energy').val()),
            apartment: parseFloat($('#filter-apartment').val()),
            affection: parseFloat($('#filter-affection').val()),
            strangers: parseFloat($('#filter-strangers').val()),
            vocality: parseFloat($('#filter-vocality').val()),
            kids: parseFloat($('#filter-kids').val()),
            experience: parseFloat($('#filter-experience').val()),
            sort_by: $('#filter-sort').val() || 'name-asc',
            paged: currentPage,
            action: 'filter_razze',
            nonce: razzeFilters.nonce
        };

        // Collect selected sizes
        $('.filter-input[name="size"]:checked').each(function() {
            filters.sizes.push($(this).val());
        });

        return filters;
    }

    /**
     * Apply filters via AJAX
     */
    function applyFilters() {
        if (isLoading) return;

        isLoading = true;
        const filters = collectFilters();
        lastFilters = filters;

        // Show loading state
        if (currentPage === 1) {
            $('#razze-results').empty();
            showLoading(true);
            hideNoResults();
            hideLoadMore();
        }

        // AJAX request
        $.ajax({
            url: razzeFilters.ajaxurl,
            type: 'POST',
            data: filters,
            success: function(response) {
                isLoading = false;
                showLoading(false);

                console.log('AJAX Response:', response);

                if (response.success && response.data) {
                    handleSuccess(response.data);
                } else {
                    console.error('Response not successful:', response);
                    handleError(response);
                }
            },
            error: function(xhr, status, error) {
                isLoading = false;
                showLoading(false);
                console.error('AJAX Error:', error);
                console.error('Status:', status);
                console.error('Response Text:', xhr.responseText);
                console.error('Status Code:', xhr.status);

                // Mostra messaggio di errore più dettagliato
                if (xhr.status === 403) {
                    console.error('Errore 403: Problema di sicurezza (nonce). Ricarica la pagina.');
                }

                showNoResults();
            }
        });
    }

    /**
     * Handle successful AJAX response
     */
    function handleSuccess(data) {
        const $grid = $('#razze-results');

        // Append or replace results
        if (currentPage === 1) {
            $grid.empty();
        }

        // Add breed cards
        if (data.breeds && data.breeds.length > 0) {
            hideNoResults();

            data.breeds.forEach(function(breed, index) {
                const card = createBreedCard(breed, index);
                $grid.append(card);
            });

            // Update count
            updateResultsCount(data.total || data.breeds.length);

            // Handle load more button
            if (data.has_more) {
                showLoadMore();
            } else {
                hideLoadMore();
            }

        } else {
            // No results found
            if (currentPage === 1) {
                showNoResults();
            }
            hideLoadMore();
            updateResultsCount(0);
        }
    }

    /**
     * Handle AJAX error
     */
    function handleError(response) {
        console.error('Filter error:', response);
        showNoResults();
        updateResultsCount(0);
    }

    /**
     * Create breed card HTML
     */
    function createBreedCard(breed, index) {
        const card = $('<a>', {
            href: breed.link,
            class: 'razza-card',
            style: 'animation-delay: ' + (index * 0.05) + 's'
        });

        // Image container
        const imageContainer = $('<div>', { class: 'razza-card-image' });

        if (breed.image) {
            const img = $('<img>', {
                src: breed.image,
                alt: breed.title,
                loading: 'lazy'
            });
            imageContainer.append(img);
        }

        card.append(imageContainer);

        // Content
        const content = $('<div>', { class: 'razza-card-content' });
        const title = $('<h3>', {
            class: 'razza-card-title',
            text: breed.title
        });
        content.append(title);

        // Optional meta info (energia, appartamento)
        if (breed.energy || breed.apartment) {
            const meta = $('<div>', { class: 'razza-card-meta' });

            if (breed.energy) {
                meta.append($('<span>').html('⚡ ' + parseFloat(breed.energy).toFixed(1)));
            }

            if (breed.apartment) {
                meta.append($('<span>').html('🏠 ' + parseFloat(breed.apartment).toFixed(1)));
            }

            content.append(meta);
        }

        card.append(content);

        return card;
    }

    /**
     * Load more results
     */
    function loadMore() {
        currentPage++;
        applyFilters();
    }

    /**
     * Reset all filters
     */
    function resetFilters() {
        // Clear search
        $('#search-breed').val('');

        // Uncheck all sizes
        $('.filter-input[name="size"]').prop('checked', false);

        // Reset range sliders
        $('#filter-energy').val(0);
        $('#filter-apartment').val(0);
        $('#filter-affection').val(0);
        $('#filter-strangers').val(0);
        $('#filter-vocality').val(0);
        $('#filter-kids').val(0);
        $('#filter-experience').val(5);

        // Reset sort
        $('#filter-sort').val('name-asc');

        // Update displays
        updateRangeDisplays();

        // Reset page and apply
        currentPage = 1;
        applyFilters();
    }

    /**
     * Toggle view (grid/list)
     */
    function toggleView(view) {
        currentView = view;

        // Update button states
        $('.view-btn').removeClass('active');
        $('.view-btn[data-view="' + view + '"]').addClass('active');

        // Update grid class
        const $grid = $('#razze-results');
        if (view === 'list') {
            $grid.addClass('list-view');
        } else {
            $grid.removeClass('list-view');
        }
    }

    /**
     * Show/hide loading state
     */
    function showLoading(show) {
        if (show) {
            $('#razze-loading').show();
        } else {
            $('#razze-loading').hide();
        }
    }

    /**
     * Show/hide no results message
     */
    function showNoResults() {
        $('#no-results').show();
    }

    function hideNoResults() {
        $('#no-results').hide();
    }

    /**
     * Show/hide load more button
     */
    function showLoadMore() {
        $('#load-more-wrapper').show();
    }

    function hideLoadMore() {
        $('#load-more-wrapper').hide();
    }

    /**
     * Update results count
     */
    function updateResultsCount(count) {
        if (count === 0) {
            $('#razze-count').text('Nessuna razza trovata');
        } else if (count === 1) {
            $('#razze-count').text('1 razza trovata');
        } else {
            $('#razze-count').text(count + ' razze trovate');
        }
    }

})(jQuery);
