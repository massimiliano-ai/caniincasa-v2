/**
 * Main JavaScript
 *
 * @package CaninCasa
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = $('.menu-toggle');
        const primaryMenu = $('#primary-menu');

        menuToggle.on('click', function(e) {
            e.preventDefault();
            $(this).toggleClass('active');
            primaryMenu.toggleClass('active');

            // Update ARIA
            const expanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', !expanded);
        });

        // Close menu on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && primaryMenu.hasClass('active')) {
                menuToggle.removeClass('active');
                primaryMenu.removeClass('active');
                menuToggle.attr('aria-expanded', 'false');
                menuToggle.focus();
            }
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.main-navigation').length && primaryMenu.hasClass('active')) {
                menuToggle.removeClass('active');
                primaryMenu.removeClass('active');
                menuToggle.attr('aria-expanded', 'false');
            }
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            const target = $(this.hash);

            if (target.length) {
                e.preventDefault();

                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500, function() {
                    // Update focus for accessibility
                    target.attr('tabindex', '-1');
                    target.focus();
                });
            }
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        // Create button if it doesn't exist
        if (!$('#back-to-top').length) {
            $('body').append('<button id="back-to-top" class="back-to-top" aria-label="Torna su"><span>↑</span></button>');
        }

        const backToTop = $('#back-to-top');

        // Show/hide on scroll
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                backToTop.addClass('visible');
            } else {
                backToTop.removeClass('visible');
            }
        });

        // Scroll to top on click
        backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 500);
        });
    }

    /**
     * Form Validation
     */
    function initFormValidation() {
        $('form.needs-validation').on('submit', function(e) {
            const form = $(this);

            if (!form[0].checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }

            form.addClass('was-validated');
        });
    }

    /**
     * Image Lazy Loading Fallback
     * (For browsers that don't support native lazy loading)
     */
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy loading supported
            return;
        }

        // Fallback for older browsers
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');

        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.removeAttribute('loading');
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(function(img) {
                imageObserver.observe(img);
            });
        }
    }

    /**
     * Accessible Dropdown Menus
     */
    function initAccessibleMenus() {
        const menuItems = $('.menu-item-has-children');

        menuItems.each(function() {
            const item = $(this);
            const link = item.find('> a');
            const submenu = item.find('> .sub-menu');

            // Add ARIA attributes
            link.attr('aria-haspopup', 'true');
            link.attr('aria-expanded', 'false');

            // Toggle on click
            link.on('click', function(e) {
                if ($(window).width() < 768) {
                    e.preventDefault();

                    const isExpanded = link.attr('aria-expanded') === 'true';

                    // Close other submenus
                    menuItems.find('> a').attr('aria-expanded', 'false');
                    menuItems.find('> .sub-menu').slideUp();

                    // Toggle current
                    if (!isExpanded) {
                        link.attr('aria-expanded', 'true');
                        submenu.slideDown();
                    }
                }
            });
        });
    }

    /**
     * Archive Filter Forms
     * Reset pagination when filters are applied
     */
    function initFilterForms() {
        $('.filter-form, #allevamenti-filter-form, #cucciolate-filter-form, #filtri-allevamenti-form, #filtri-annunci-form').on('submit', function(e) {
            const form = $(this);
            const currentUrl = window.location.href;

            // Check if we're on a paginated URL (e.g., /page/2/, /page/3/)
            if (currentUrl.match(/\/page\/\d+\//)) {
                e.preventDefault();

                // Remove /page/X/ from URL to reset to page 1
                const baseUrl = currentUrl.replace(/\/page\/\d+\/.*$/, '/');

                // Get form data
                const formData = form.serialize();

                // Redirect to page 1 with filters
                if (formData) {
                    window.location.href = baseUrl + '?' + formData;
                } else {
                    window.location.href = baseUrl;
                }

                return false;
            }
        });

        // Reset filters button
        $('#reset-filters').on('click', function(e) {
            const form = $(this).closest('form');

            // If not in a form, check for nearby forms
            if (!form.length) {
                const nearbyForm = $('.filter-form, #allevamenti-filter-form, #cucciolate-filter-form, #filtri-allevamenti-form, #filtri-annunci-form').first();

                if (nearbyForm.length) {
                    e.preventDefault();

                    // Get base URL without /page/X/ and query params
                    let baseUrl = window.location.pathname;
                    baseUrl = baseUrl.replace(/\/page\/\d+\/.*$/, '/');

                    window.location.href = baseUrl;
                    return false;
                }
            }
        });
    }

    /**
     * Initialize all functions
     */
    $(document).ready(function() {
        initMobileMenu();
        initSmoothScroll();
        initBackToTop();
        initFormValidation();
        initLazyLoading();
        initAccessibleMenus();
        initFilterForms();
    });

})(jQuery);
