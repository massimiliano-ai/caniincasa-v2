<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Additional Scripts (beyond main scripts in functions.php)
 */
function caniincasa_enqueue_additional_scripts() {
    // Enqueue razze archive specific styles and scripts
    if ( is_post_type_archive( 'razze_di_cani' ) ) {
        // Archive CSS
        wp_enqueue_style(
            'caniincasa-archive-razze',
            CANIINCASA_THEME_URI . '/css/archive-razze.css',
            array(),
            CANIINCASA_VERSION
        );

        // Razze filters JavaScript
        wp_enqueue_script(
            'caniincasa-razze-archive-filters',
            CANIINCASA_THEME_URI . '/js/razze-filters.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );
    }

    // Enqueue search/filter script on other archive pages
    if ( is_post_type_archive( array( 'allevamenti', 'struttureveterinarie' ) ) || is_tax() ) {
        wp_enqueue_script(
            'caniincasa-search-filter',
            CANIINCASA_THEME_URI . '/js/search-filter.js',
            array( 'jquery', 'caniincasa-main-js' ),
            CANIINCASA_VERSION,
            true
        );
    }

    // Enqueue rating display script on single pages
    if ( is_singular( array( 'razze_di_cani', 'allevamenti' ) ) ) {
        wp_enqueue_script(
            'caniincasa-rating',
            CANIINCASA_THEME_URI . '/js/rating-display.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_additional_scripts', 20 );

/**
 * Enqueue Admin Scripts
 */
function caniincasa_admin_scripts( $hook ) {
    // Only load on post edit pages
    if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
        return;
    }

    // Admin styles
    wp_enqueue_style(
        'caniincasa-admin',
        CANIINCASA_THEME_URI . '/css/admin.css',
        array(),
        CANIINCASA_VERSION
    );
}
add_action( 'admin_enqueue_scripts', 'caniincasa_admin_scripts' );

/**
 * Preload critical resources
 */
function caniincasa_preload_resources() {
    // Preload main stylesheet
    echo '<link rel="preload" href="' . esc_url( get_stylesheet_uri() ) . '" as="style">';

    // Preload main script
    echo '<link rel="preload" href="' . esc_url( CANIINCASA_THEME_URI . '/js/main.js' ) . '" as="script">';
}
add_action( 'wp_head', 'caniincasa_preload_resources', 1 );

/**
 * Add async/defer attributes to scripts
 */
function caniincasa_script_loader_tag( $tag, $handle, $src ) {
    // Add async to non-critical scripts
    $async_scripts = array(
        'caniincasa-search-filter',
        'caniincasa-rating',
    );

    if ( in_array( $handle, $async_scripts ) ) {
        $tag = str_replace( ' src', ' async src', $tag );
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'caniincasa_script_loader_tag', 10, 3 );

/**
 * Enqueue Auth Pages Scripts and Styles
 */
function caniincasa_enqueue_auth_scripts() {
    if ( is_page_template( 'page-templates/template-registrazione.php' ) ||
         is_page_template( 'page-templates/template-login.php' ) ) {

        // Auth pages CSS
        wp_enqueue_style(
            'caniincasa-auth-pages',
            CANIINCASA_THEME_URI . '/css/auth-pages.css',
            array(),
            CANIINCASA_VERSION
        );

        // Auth forms JavaScript
        wp_enqueue_script(
            'caniincasa-auth-forms',
            CANIINCASA_THEME_URI . '/js/auth-forms.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script( 'caniincasa-auth-forms', 'caniincasaAuth', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_auth_scripts', 20 );

/**
 * Enqueue Dashboard Scripts and Styles
 */
function caniincasa_enqueue_dashboard_scripts() {
    if ( is_page_template( 'page-templates/template-dashboard.php' ) ) {

        // Dashboard CSS
        wp_enqueue_style(
            'caniincasa-dashboard',
            CANIINCASA_THEME_URI . '/css/dashboard.css',
            array(),
            CANIINCASA_VERSION
        );

        // Dashboard JavaScript
        wp_enqueue_script(
            'caniincasa-dashboard',
            CANIINCASA_THEME_URI . '/js/dashboard.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script( 'caniincasa-dashboard', 'caniincasaDashboard', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'caniincasa_dashboard_nonce' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_dashboard_scripts', 20 );

/**
 * Enqueue Page Templates Grid CSS
 */
function caniincasa_enqueue_page_templates_grid() {
    if ( is_page_template( 'page-templates/template-allevamenti.php' ) ||
         is_page_template( 'page-templates/template-canili.php' ) ||
         is_page_template( 'page-templates/template-veterinari.php' ) ||
         is_page_template( 'page-templates/template-centri-cinofili.php' ) ) {

        // Page templates grid CSS
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_page_templates_grid', 20 );

/**
 * Enqueue Razze Archive Scripts and Styles
 */
function caniincasa_enqueue_razze_archive_scripts() {
    if ( is_page_template( 'page-templates/template-razze-archive.php' ) ) {

        // Razze archive CSS
        wp_enqueue_style(
            'caniincasa-razze-archive',
            CANIINCASA_THEME_URI . '/css/page-razze-archive.css',
            array(),
            CANIINCASA_VERSION
        );

        // Razze filters JavaScript
        wp_enqueue_script(
            'caniincasa-razze-filters',
            CANIINCASA_THEME_URI . '/js/page-razze-filters.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script( 'caniincasa-razze-filters', 'razzeFilters', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'razze_filters_nonce' ),
        ) );
    }

    // Template Razze Semplice
    if ( is_page_template( 'page-templates/template-razze-semplice.php' ) ) {
        wp_enqueue_style(
            'caniincasa-razze-semplice',
            CANIINCASA_THEME_URI . '/css/page-razze-semplice.css',
            array(),
            CANIINCASA_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_razze_archive_scripts', 20 );
