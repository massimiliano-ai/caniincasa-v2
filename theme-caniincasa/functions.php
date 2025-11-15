<?php
/**
 * CaninCasa Theme Functions
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Theme Constants
 */
define( 'CANIINCASA_VERSION', '1.0.0' );
define( 'CANIINCASA_THEME_DIR', get_template_directory() );
define( 'CANIINCASA_THEME_URI', get_template_directory_uri() );
define( 'CANIINCASA_INC_DIR', CANIINCASA_THEME_DIR . '/inc' );

/**
 * Theme Setup
 */
function caniincasa_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'caniincasa', CANIINCASA_THEME_DIR . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'caniincasa-featured', 1200, 600, true );
    add_image_size( 'caniincasa-thumbnail', 400, 300, true );
    add_image_size( 'caniincasa-card', 600, 400, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'caniincasa' ),
        'footer'  => esc_html__( 'Footer Menu', 'caniincasa' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'caniincasa_setup' );

/**
 * Set the content width in pixels
 */
function caniincasa_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'caniincasa_content_width', 1200 );
}
add_action( 'after_setup_theme', 'caniincasa_content_width', 0 );

/**
 * Register Widget Areas
 */
function caniincasa_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'caniincasa' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'caniincasa' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer 1', 'caniincasa' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Footer widget area 1', 'caniincasa' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer 2', 'caniincasa' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Footer widget area 2', 'caniincasa' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer 3', 'caniincasa' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Footer widget area 3', 'caniincasa' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'caniincasa_widgets_init' );

/**
 * Enqueue Stylesheets and Scripts
 */
function caniincasa_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style(
        'caniincasa-style',
        get_stylesheet_uri(),
        array(),
        CANIINCASA_VERSION
    );

    // Enqueue main CSS
    wp_enqueue_style(
        'caniincasa-main',
        CANIINCASA_THEME_URI . '/css/main.css',
        array( 'caniincasa-style' ),
        CANIINCASA_VERSION
    );

    // Enqueue component CSS files
    wp_enqueue_style(
        'caniincasa-cards',
        CANIINCASA_THEME_URI . '/css/components/cards.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-forms',
        CANIINCASA_THEME_URI . '/css/components/forms.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-rating',
        CANIINCASA_THEME_URI . '/css/components/rating.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-homepage',
        CANIINCASA_THEME_URI . '/css/components/homepage.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-blog',
        CANIINCASA_THEME_URI . '/css/components/blog.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-pages',
        CANIINCASA_THEME_URI . '/css/components/pages.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-breed-characteristics',
        CANIINCASA_THEME_URI . '/css/components/breed-characteristics.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    // Enqueue Single Razza layout CSS (only on breed single pages)
    if ( is_singular( 'razze_di_cani' ) ) {
        wp_enqueue_style(
            'caniincasa-single-razza',
            CANIINCASA_THEME_URI . '/css/single-razza.css',
            array( 'caniincasa-main', 'caniincasa-breed-characteristics' ),
            CANIINCASA_VERSION
        );
    }

    // Enqueue main JavaScript
    wp_enqueue_script(
        'caniincasa-main-js',
        CANIINCASA_THEME_URI . '/js/main.js',
        array( 'jquery' ),
        CANIINCASA_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script( 'caniincasa-main-js', 'canincasaAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'caniincasa-nonce' ),
    ) );

    // Enqueue comment reply script if needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_scripts' );

/**
 * Include Required Files
 */

// Custom Post Types
require_once CANIINCASA_INC_DIR . '/custom-post-types.php';

// Custom Taxonomies
require_once CANIINCASA_INC_DIR . '/taxonomies.php';

// Custom Fields (ACF)
if ( file_exists( CANIINCASA_INC_DIR . '/custom-fields.php' ) ) {
    require_once CANIINCASA_INC_DIR . '/custom-fields.php';
}

// Template Functions
require_once CANIINCASA_INC_DIR . '/template-functions.php';

// Customizer
require_once CANIINCASA_INC_DIR . '/customizer.php';

// AJAX Handlers
if ( file_exists( CANIINCASA_INC_DIR . '/ajax-handlers.php' ) ) {
    require_once CANIINCASA_INC_DIR . '/ajax-handlers.php';
}

// Enqueue Scripts
require_once CANIINCASA_INC_DIR . '/enqueue-scripts.php';

// User System
require_once CANIINCASA_INC_DIR . '/user-system.php';

// Custom Post Type: Cucciolate
require_once CANIINCASA_INC_DIR . '/cpt-cucciolate.php';

/**
 * Add ACF Options Page (if ACF is active)
 */
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' => __( 'Theme General Settings', 'caniincasa' ),
        'menu_title' => __( 'Theme Settings', 'caniincasa' ),
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ) );
}

/**
 * Remove WordPress version number
 * Security best practice
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Disable XML-RPC for security
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove emoji scripts for performance
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Add Security Headers
 */
function caniincasa_security_headers() {
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'X-XSS-Protection: 1; mode=block' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
add_action( 'send_headers', 'caniincasa_security_headers' );

/**
 * Custom Excerpt Length
 */
function caniincasa_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'caniincasa_excerpt_length' );

/**
 * Custom Excerpt More
 */
function caniincasa_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'caniincasa_excerpt_more' );

/**
 * DEBUG MODE per Local by Flywheel - Bypass Nonce Verification
 *
 * IMPORTANTE: Questo bypassa la sicurezza nonce SOLO su localhost!
 * RIMUOVI prima del deploy in produzione!
 *
 * Questo DEVE essere definito PRIMA di includere razze-ajax-filters.php
 */
if (
    ( defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local' ) ||
    ( isset($_SERVER['HTTP_HOST']) && strpos( $_SERVER['HTTP_HOST'], '.local' ) !== false ) ||
    ( isset($_SERVER['HTTP_HOST']) && strpos( $_SERVER['HTTP_HOST'], 'localhost' ) !== false )
) {
    define( 'RAZZE_SKIP_NONCE_CHECK', true );
    if ( function_exists('error_log') ) {
        error_log( '⚠️ RAZZE DEBUG MODE ATTIVO: Nonce check disabilitato per ' . $_SERVER['HTTP_HOST'] );
    }
}

/**
 * Include AJAX Filters for Razze Archive
 */
require_once CANIINCASA_INC_DIR . '/razze-ajax-filters.php';

/**
 * Enqueue Archive Razze Scripts & Styles
 */
function caniincasa_razze_archive_scripts() {
    // Only on razze archive
    if ( !is_post_type_archive( 'razze_di_cani' ) ) {
        return;
    }

    // Archive CSS
    wp_enqueue_style(
        'caniincasa-archive-razze',
        CANIINCASA_THEME_URI . '/css/archive-razze.css',
        array(),
        CANIINCASA_VERSION
    );

    // Archive JS
    wp_enqueue_script(
        'caniincasa-razze-filters',
        CANIINCASA_THEME_URI . '/js/razze-filters.js',
        array( 'jquery' ),
        CANIINCASA_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'caniincasa_razze_archive_scripts' );

/**
 * Enqueue Page Template Razze Scripts & Styles
 */
function caniincasa_page_razze_template_scripts() {
    // Template con filtri AJAX
    if ( is_page_template( 'page-templates/template-razze-archive.php' ) ) {
        // Page Template CSS
        wp_enqueue_style(
            'caniincasa-page-razze-archive',
            CANIINCASA_THEME_URI . '/css/page-razze-archive.css',
            array(),
            CANIINCASA_VERSION
        );

        // Page Template JS
        wp_enqueue_script(
            'caniincasa-page-razze-filters',
            CANIINCASA_THEME_URI . '/js/page-razze-filters.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script( 'caniincasa-page-razze-filters', 'razzeFilterData', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'razze_filter_nonce' ),
        ) );
    }

    // Template semplice senza filtri
    if ( is_page_template( 'page-templates/template-razze-semplice.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-razze-semplice',
            CANIINCASA_THEME_URI . '/css/page-razze-semplice.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template allevamenti
    if ( is_page_template( 'page-templates/template-allevamenti.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template canili
    if ( is_page_template( 'page-templates/template-canili.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template veterinari
    if ( is_page_template( 'page-templates/template-veterinari.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template centri cinofili
    if ( is_page_template( 'page-templates/template-centri-cinofili.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_page_razze_template_scripts' );
