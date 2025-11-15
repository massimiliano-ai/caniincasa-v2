/**
 * Theme Customizer Live Preview
 *
 * @package CaninCasa
 * @since 1.0.0
 */

(function($) {
    'use strict';

    // Primary Color
    wp.customize('caniincasa_primary_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--primary', newval);
        });
    });

    // Secondary Color
    wp.customize('caniincasa_secondary_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--secondary', newval);
        });
    });

    // Accent Color
    wp.customize('caniincasa_accent_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--accent', newval);
        });
    });

    // Text Color
    wp.customize('caniincasa_text_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--text-primary', newval);
        });
    });

    // Background Color
    wp.customize('caniincasa_background_color', function(value) {
        value.bind(function(newval) {
            $('body').css('background-color', newval);
        });
    });

    // Link Color
    wp.customize('caniincasa_link_color', function(value) {
        value.bind(function(newval) {
            $('a').css('color', newval);
        });
    });

    // Heading Font
    wp.customize('caniincasa_heading_font', function(value) {
        value.bind(function(newval) {
            $('h1, h2, h3, h4, h5, h6, .site-title').css('font-family', newval + ', sans-serif');
        });
    });

    // Body Font
    wp.customize('caniincasa_body_font', function(value) {
        value.bind(function(newval) {
            $('body').css('font-family', newval + ', sans-serif');
        });
    });

    // Font Size
    wp.customize('caniincasa_font_size', function(value) {
        value.bind(function(newval) {
            $('body').css('font-size', newval + 'px');
        });
    });

    // Header Background Color
    wp.customize('caniincasa_header_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-header').css('background-color', newval);
        });
    });

    // Header Text Color
    wp.customize('caniincasa_header_text_color', function(value) {
        value.bind(function(newval) {
            $('.site-header a, .main-navigation a').css('color', newval);
        });
    });

    // Logo Height
    wp.customize('caniincasa_logo_height', function(value) {
        value.bind(function(newval) {
            $('.custom-logo').css('height', newval + 'px');
        });
    });

    // Header Padding
    wp.customize('caniincasa_header_padding', function(value) {
        value.bind(function(newval) {
            $('.site-header').css({
                'padding-top': newval + 'px',
                'padding-bottom': newval + 'px'
            });
        });
    });

    // Hero Overlay Color
    wp.customize('caniincasa_hero_overlay_color', function(value) {
        value.bind(function(newval) {
            $('.hero::before').css('background', newval);
        });
    });

    // Hero Overlay Opacity
    wp.customize('caniincasa_hero_overlay_opacity', function(value) {
        value.bind(function(newval) {
            $('.hero::before').css('opacity', newval);
        });
    });

    // Hero Title
    wp.customize('caniincasa_hero_title', function(value) {
        value.bind(function(newval) {
            $('.hero__title').text(newval);
        });
    });

    // Hero Subtitle
    wp.customize('caniincasa_hero_subtitle', function(value) {
        value.bind(function(newval) {
            $('.hero__subtitle').text(newval);
        });
    });

    // Hero Button Text
    wp.customize('caniincasa_hero_button_text', function(value) {
        value.bind(function(newval) {
            $('.hero__cta .btn').text(newval);
        });
    });

    // Features Title
    wp.customize('caniincasa_features_title', function(value) {
        value.bind(function(newval) {
            $('.features-section h2').text(newval);
        });
    });

    // Blog Title
    wp.customize('caniincasa_blog_title', function(value) {
        value.bind(function(newval) {
            $('.blog-section h2').text(newval);
        });
    });

    // CTA Background Color
    wp.customize('caniincasa_cta_bg_color', function(value) {
        value.bind(function(newval) {
            $('.cta-card').css('background', newval);
        });
    });

    // Footer Background Color
    wp.customize('caniincasa_footer_bg_color', function(value) {
        value.bind(function(newval) {
            $('.site-footer').css('background-color', newval);
        });
    });

    // Footer Text Color
    wp.customize('caniincasa_footer_text_color', function(value) {
        value.bind(function(newval) {
            $('.site-footer, .site-footer a').css('color', newval);
        });
    });

    // Footer Copyright
    wp.customize('caniincasa_footer_copyright', function(value) {
        value.bind(function(newval) {
            $('.footer-copyright').html(newval);
        });
    });

    // Container Width
    wp.customize('caniincasa_container_width', function(value) {
        value.bind(function(newval) {
            $('.container').css('max-width', newval + 'px');
        });
    });

    // Border Radius
    wp.customize('caniincasa_border_radius', function(value) {
        value.bind(function(newval) {
            $(':root').css('--radius-md', newval + 'px');
        });
    });

    // Archive Overlay Color
    wp.customize('caniincasa_archive_overlay_color', function(value) {
        value.bind(function(newval) {
            $('.archive-header::before').css('background', newval);
        });
    });

})(jQuery);
