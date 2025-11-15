/**
 * Razze Archive - AJAX Filters
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

    // DOM Elements
    const $grid = $('#razze-grid');
    const $loading = $('#loading-indicator');
    const $noResults = $('#no-results');
    const $resultsTotal = $('#results-total');
    const $loadMoreBtn = $('#load-more-btn');
    const $loadMoreContainer = $('#load-more-container');

    /**
     * Initialize filters
     */
    function init() {
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

        // Checkboxes
        $('.filter-input[type="checkbox"]').on('change', function() {
            currentPage = 1;
            applyFilters();
        });

        // Range sliders
        $('.filter-slider').on('input change', function() {
            updateRangeDisplays();
        });

        $('.filter-slider').on('change', function() {
            currentPage = 1;
            applyFilters();
        });

        // Sort select
        $('#sort-by').on('change', function() {
            currentPage = 1;
            applyFilters();
        });

        // Reset button
        $('#reset-filters').on('click', resetFilters);

        // Load more button
        $loadMoreBtn.on('click', loadMore);

        // Toggle filters su mobile
        $('#toggle-filters').on('click', toggleFilters);
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

        // Kids
        const kids = parseFloat($('#filter-kids').val());
        $('#kids-value').text(kids === 0 ? 'Tutti' : kids.toFixed(1));

        // Experience
        const experience = parseFloat($('#filter-experience').val());
        $('#experience-value').text(experience === 0 ? 'Tutti' : experience.toFixed(1));
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
            kids: parseFloat($('#filter-kids').val()),
            experience: parseFloat($('#filter-experience').val()),
            sort_by: $('#sort-by').val(),
            paged: currentPage
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

        // Show loading
        if (currentPage === 1) {
            $grid.empty();
            showLoading(true);
        }

        // AJAX request
        $.ajax({
            url: razzeArchive.ajaxUrl,
            type: 'POST',
            data: {
                action: 'filter_razze',
                nonce: razzeArchive.nonce,
                ...filters
            },
            success: function(response) {
                if (response.success) {
                    displayResults(response.data);
                } else {
                    console.error('Filter error:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                showError();
            },
            complete: function() {
                isLoading = false;
                showLoading(false);
            }
        });
    }

    /**
     * Display filtered results
     */
    function displayResults(data) {
        const { breeds, total, max_pages, current_page } = data;

        // Update counter
        $resultsTotal.text(total);

        // Clear grid if first page
        if (current_page === 1) {
            $grid.empty();
        }

        // Show/hide no results
        if (total === 0) {
            $noResults.show();
            $grid.hide();
            $loadMoreContainer.hide();
            return;
        }

        $noResults.hide();
        $grid.show();

        // Append breed cards
        breeds.forEach(breed => {
            $grid.append(createBreedCard(breed));
        });

        // Animate new cards
        animateCards();

        // Show/hide load more button
        if (current_page < max_pages) {
            $loadMoreContainer.show();
        } else {
            $loadMoreContainer.hide();
        }
    }

    /**
     * Create breed card HTML
     */
    function createBreedCard(breed) {
        const energyPaws = generatePaws(breed.energy);
        const apartmentPaws = generatePaws(breed.apartment);

        return `
            <div class="breed-card" data-breed-id="${breed.id}">
                <a href="${breed.link}" class="breed-card__link">
                    ${breed.image ? `
                        <div class="breed-card__image">
                            <img src="${breed.image}" alt="${breed.title}" loading="lazy">
                            <div class="breed-card__overlay">
                                <span class="view-details">Scopri di più →</span>
                            </div>
                        </div>
                    ` : `
                        <div class="breed-card__image breed-card__image--placeholder">
                            <span class="placeholder-icon">🐕</span>
                        </div>
                    `}

                    <div class="breed-card__content">
                        <h3 class="breed-card__title">${breed.title}</h3>

                        ${breed.temperament ? `
                            <p class="breed-card__temperament">${breed.temperament}</p>
                        ` : ''}

                        ${breed.origin ? `
                            <p class="breed-card__origin">
                                <span class="icon">🌍</span> ${breed.origin}
                            </p>
                        ` : ''}

                        <div class="breed-card__stats">
                            <div class="stat">
                                <span class="stat-label">Energia:</span>
                                <span class="stat-paws">${energyPaws}</span>
                            </div>
                            <div class="stat">
                                <span class="stat-label">Appartamento:</span>
                                <span class="stat-paws">${apartmentPaws}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        `;
    }

    /**
     * Generate paw rating HTML
     */
    function generatePaws(rating) {
        const filled = Math.round(rating);
        const total = 5;
        let html = '';

        for (let i = 1; i <= total; i++) {
            if (i <= filled) {
                html += '<span class="paw filled">🐾</span>';
            } else {
                html += '<span class="paw empty">🐾</span>';
            }
        }

        return html;
    }

    /**
     * Animate new cards
     */
    function animateCards() {
        $('.breed-card').each(function(index) {
            const $card = $(this);
            if (!$card.hasClass('animated')) {
                setTimeout(() => {
                    $card.addClass('animated');
                }, index * 50);
            }
        });
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

        // Uncheck all checkboxes
        $('.filter-input[type="checkbox"]').prop('checked', false);

        // Reset all range sliders
        $('.filter-slider').val(0);
        updateRangeDisplays();

        // Reset sort
        $('#sort-by').val('name-asc');

        // Reset page and apply
        currentPage = 1;
        applyFilters();
    }

    /**
     * Toggle filters sidebar on mobile
     */
    function toggleFilters() {
        $('#razze-filters').toggleClass('filters-open');
        $('body').toggleClass('filters-modal-open');
    }

    /**
     * Show/hide loading indicator
     */
    function showLoading(show) {
        if (show) {
            $loading.show();
        } else {
            $loading.hide();
        }
    }

    /**
     * Show error message
     */
    function showError() {
        $grid.html(`
            <div class="error-message">
                <p>Si è verificato un errore durante il caricamento delle razze.</p>
                <button onclick="location.reload()">Ricarica la pagina</button>
            </div>
        `);
    }

    // Initialize when DOM is ready
    $(document).ready(init);

})(jQuery);
