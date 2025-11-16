<?php
/**
 * Theme Customizer
 * Personalizzazione completa del tema
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Customizer Settings
 */
function caniincasa_customize_register( $wp_customize ) {

    // ========================================================================
    // COLORI
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_colors', array(
        'title'    => __( 'Colori Tema', 'caniincasa' ),
        'priority' => 30,
    ) );

    // Colore Primario
    $wp_customize->add_setting( 'caniincasa_primary_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_primary_color', array(
        'label'    => __( 'Colore Primario', 'caniincasa' ),
        'section'  => 'caniincasa_colors',
        'settings' => 'caniincasa_primary_color',
    ) ) );

    // Colore Secondario
    $wp_customize->add_setting( 'caniincasa_secondary_color', array(
        'default'           => '#004E89',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_secondary_color', array(
        'label'    => __( 'Colore Secondario', 'caniincasa' ),
        'section'  => 'caniincasa_colors',
        'settings' => 'caniincasa_secondary_color',
    ) ) );

    // Colore Accent
    $wp_customize->add_setting( 'caniincasa_accent_color', array(
        'default'           => '#F7B801',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_accent_color', array(
        'label'    => __( 'Colore Accent', 'caniincasa' ),
        'section'  => 'caniincasa_colors',
        'settings' => 'caniincasa_accent_color',
    ) ) );

    // Colore Testo
    $wp_customize->add_setting( 'caniincasa_text_color', array(
        'default'           => '#1a202c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_text_color', array(
        'label'    => __( 'Colore Testo', 'caniincasa' ),
        'section'  => 'caniincasa_colors',
        'settings' => 'caniincasa_text_color',
    ) ) );

    // Colore Sfondo
    $wp_customize->add_setting( 'caniincasa_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_background_color', array(
        'label'    => __( 'Colore Sfondo', 'caniincasa' ),
        'section'  => 'caniincasa_colors',
        'settings' => 'caniincasa_background_color',
    ) ) );

    // Colore Link
    $wp_customize->add_setting( 'caniincasa_link_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_link_color', array(
        'label'    => __( 'Colore Link', 'caniincasa' ),
        'section'  => 'caniincasa_colors',
        'settings' => 'caniincasa_link_color',
    ) ) );

    // ========================================================================
    // TIPOGRAFIA
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_typography', array(
        'title'    => __( 'Tipografia', 'caniincasa' ),
        'priority' => 35,
    ) );

    // Font Heading
    $wp_customize->add_setting( 'caniincasa_heading_font', array(
        'default'           => 'system-ui',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_heading_font', array(
        'label'    => __( 'Font Titoli', 'caniincasa' ),
        'section'  => 'caniincasa_typography',
        'type'     => 'select',
        'choices'  => array(
            'system-ui'     => 'System UI',
            'Arial'         => 'Arial',
            'Helvetica'     => 'Helvetica',
            'Georgia'       => 'Georgia',
            'Times New Roman' => 'Times New Roman',
            'Courier New'   => 'Courier New',
            'Verdana'       => 'Verdana',
            'Roboto'        => 'Roboto (Google Font)',
            'Open Sans'     => 'Open Sans (Google Font)',
            'Lato'          => 'Lato (Google Font)',
            'Montserrat'    => 'Montserrat (Google Font)',
            'Poppins'       => 'Poppins (Google Font)',
            'Raleway'       => 'Raleway (Google Font)',
            'Playfair Display' => 'Playfair Display (Google Font)',
        ),
    ) );

    // Font Body
    $wp_customize->add_setting( 'caniincasa_body_font', array(
        'default'           => 'system-ui',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_body_font', array(
        'label'    => __( 'Font Testo', 'caniincasa' ),
        'section'  => 'caniincasa_typography',
        'type'     => 'select',
        'choices'  => array(
            'system-ui'     => 'System UI',
            'Arial'         => 'Arial',
            'Helvetica'     => 'Helvetica',
            'Georgia'       => 'Georgia',
            'Times New Roman' => 'Times New Roman',
            'Courier New'   => 'Courier New',
            'Verdana'       => 'Verdana',
            'Roboto'        => 'Roboto (Google Font)',
            'Open Sans'     => 'Open Sans (Google Font)',
            'Lato'          => 'Lato (Google Font)',
            'Montserrat'    => 'Montserrat (Google Font)',
            'Poppins'       => 'Poppins (Google Font)',
            'Inter'         => 'Inter (Google Font)',
        ),
    ) );

    // Dimensione Font Base
    $wp_customize->add_setting( 'caniincasa_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_font_size', array(
        'label'       => __( 'Dimensione Font Base (px)', 'caniincasa' ),
        'section'     => 'caniincasa_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ) );

    // ========================================================================
    // HEADER
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_header', array(
        'title'    => __( 'Header', 'caniincasa' ),
        'priority' => 40,
    ) );

    // Header Sticky
    $wp_customize->add_setting( 'caniincasa_header_sticky', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ) );
    $wp_customize->add_control( 'caniincasa_header_sticky', array(
        'label'   => __( 'Header Sticky (fisso in scroll)', 'caniincasa' ),
        'section' => 'caniincasa_header',
        'type'    => 'checkbox',
    ) );

    // Header Background Color
    $wp_customize->add_setting( 'caniincasa_header_bg_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_header_bg_color', array(
        'label'    => __( 'Colore Sfondo Header', 'caniincasa' ),
        'section'  => 'caniincasa_header',
        'settings' => 'caniincasa_header_bg_color',
    ) ) );

    // Header Text Color
    $wp_customize->add_setting( 'caniincasa_header_text_color', array(
        'default'           => '#1a202c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_header_text_color', array(
        'label'    => __( 'Colore Testo Header', 'caniincasa' ),
        'section'  => 'caniincasa_header',
        'settings' => 'caniincasa_header_text_color',
    ) ) );

    // Logo Height
    $wp_customize->add_setting( 'caniincasa_logo_height', array(
        'default'           => '60',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_logo_height', array(
        'label'       => __( 'Altezza Logo (px)', 'caniincasa' ),
        'section'     => 'caniincasa_header',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 30,
            'max'  => 150,
            'step' => 5,
        ),
    ) );

    // Header Padding
    $wp_customize->add_setting( 'caniincasa_header_padding', array(
        'default'           => '20',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_header_padding', array(
        'label'       => __( 'Padding Header (px)', 'caniincasa' ),
        'section'     => 'caniincasa_header',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 50,
            'step' => 5,
        ),
    ) );

    // ========================================================================
    // HERO HOMEPAGE
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_hero_home', array(
        'title'    => __( 'Hero Homepage', 'caniincasa' ),
        'priority' => 45,
    ) );

    // Hero Background Image
    $wp_customize->add_setting( 'caniincasa_hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'caniincasa_hero_bg_image', array(
        'label'    => __( 'Immagine Sfondo Hero', 'caniincasa' ),
        'section'  => 'caniincasa_hero_home',
        'settings' => 'caniincasa_hero_bg_image',
    ) ) );

    // Hero Overlay Color
    $wp_customize->add_setting( 'caniincasa_hero_overlay_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_hero_overlay_color', array(
        'label'    => __( 'Colore Overlay Hero', 'caniincasa' ),
        'section'  => 'caniincasa_hero_home',
        'settings' => 'caniincasa_hero_overlay_color',
    ) ) );

    // Hero Overlay Opacity
    $wp_customize->add_setting( 'caniincasa_hero_overlay_opacity', array(
        'default'           => '0.9',
        'sanitize_callback' => 'caniincasa_sanitize_float',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_hero_overlay_opacity', array(
        'label'       => __( 'Opacità Overlay (0-1)', 'caniincasa' ),
        'section'     => 'caniincasa_hero_home',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 1,
            'step' => 0.1,
        ),
    ) );

    // Hero Title
    $wp_customize->add_setting( 'caniincasa_hero_title', array(
        'default'           => 'Benvenuto su CaninCasa.it',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_hero_title', array(
        'label'   => __( 'Titolo Hero', 'caniincasa' ),
        'section' => 'caniincasa_hero_home',
        'type'    => 'text',
    ) );

    // Hero Subtitle
    $wp_customize->add_setting( 'caniincasa_hero_subtitle', array(
        'default'           => 'Tutto quello che devi sapere sui cani',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_hero_subtitle', array(
        'label'   => __( 'Sottotitolo Hero', 'caniincasa' ),
        'section' => 'caniincasa_hero_home',
        'type'    => 'textarea',
    ) );

    // Hero Button Text
    $wp_customize->add_setting( 'caniincasa_hero_button_text', array(
        'default'           => 'Scopri di più',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_hero_button_text', array(
        'label'   => __( 'Testo Pulsante', 'caniincasa' ),
        'section' => 'caniincasa_hero_home',
        'type'    => 'text',
    ) );

    // Hero Button URL
    $wp_customize->add_setting( 'caniincasa_hero_button_url', array(
        'default'           => '#razze',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'caniincasa_hero_button_url', array(
        'label'   => __( 'URL Pulsante', 'caniincasa' ),
        'section' => 'caniincasa_hero_home',
        'type'    => 'url',
    ) );

    // ========================================================================
    // SEZIONI HOMEPAGE
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_home_sections', array(
        'title'    => __( 'Sezioni Homepage', 'caniincasa' ),
        'priority' => 50,
    ) );

    // Feature Section Title
    $wp_customize->add_setting( 'caniincasa_features_title', array(
        'default'           => 'Esplora il mondo dei cani',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_features_title', array(
        'label'   => __( 'Titolo Sezione Features', 'caniincasa' ),
        'section' => 'caniincasa_home_sections',
        'type'    => 'text',
    ) );

    // Blog Section Title
    $wp_customize->add_setting( 'caniincasa_blog_title', array(
        'default'           => 'Ultimi Articoli',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_blog_title', array(
        'label'   => __( 'Titolo Sezione Blog', 'caniincasa' ),
        'section' => 'caniincasa_home_sections',
        'type'    => 'text',
    ) );

    // CTA Section Background
    $wp_customize->add_setting( 'caniincasa_cta_bg_color', array(
        'default'           => '#F7B801',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_cta_bg_color', array(
        'label'    => __( 'Colore Sfondo CTA', 'caniincasa' ),
        'section'  => 'caniincasa_home_sections',
        'settings' => 'caniincasa_cta_bg_color',
    ) ) );

    // ========================================================================
    // FOOTER
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_footer', array(
        'title'    => __( 'Footer', 'caniincasa' ),
        'priority' => 55,
    ) );

    // Footer Background Color
    $wp_customize->add_setting( 'caniincasa_footer_bg_color', array(
        'default'           => '#1a202c',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_footer_bg_color', array(
        'label'    => __( 'Colore Sfondo Footer', 'caniincasa' ),
        'section'  => 'caniincasa_footer',
        'settings' => 'caniincasa_footer_bg_color',
    ) ) );

    // Footer Text Color
    $wp_customize->add_setting( 'caniincasa_footer_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_footer_text_color', array(
        'label'    => __( 'Colore Testo Footer', 'caniincasa' ),
        'section'  => 'caniincasa_footer',
        'settings' => 'caniincasa_footer_text_color',
    ) ) );

    // Footer Copyright
    $wp_customize->add_setting( 'caniincasa_footer_copyright', array(
        'default'           => '© 2024 CaninCasa.it - Tutti i diritti riservati',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_footer_copyright', array(
        'label'   => __( 'Testo Copyright', 'caniincasa' ),
        'section' => 'caniincasa_footer',
        'type'    => 'textarea',
    ) );

    // ========================================================================
    // LAYOUT
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_layout', array(
        'title'    => __( 'Layout', 'caniincasa' ),
        'priority' => 60,
    ) );

    // Container Width
    $wp_customize->add_setting( 'caniincasa_container_width', array(
        'default'           => '1200',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_container_width', array(
        'label'       => __( 'Larghezza Container (px)', 'caniincasa' ),
        'section'     => 'caniincasa_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 960,
            'max'  => 1920,
            'step' => 40,
        ),
    ) );

    // Border Radius
    $wp_customize->add_setting( 'caniincasa_border_radius', array(
        'default'           => '8',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'caniincasa_border_radius', array(
        'label'       => __( 'Border Radius (px)', 'caniincasa' ),
        'section'     => 'caniincasa_layout',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 30,
            'step' => 2,
        ),
    ) );

    // ========================================================================
    // ARCHIVE PAGES
    // ========================================================================

    $wp_customize->add_section( 'caniincasa_archives', array(
        'title'    => __( 'Pagine Archivio', 'caniincasa' ),
        'priority' => 65,
    ) );

    // Archive Header Background
    $wp_customize->add_setting( 'caniincasa_archive_header_bg', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'caniincasa_archive_header_bg', array(
        'label'       => __( 'Immagine Header Archivi', 'caniincasa' ),
        'section'     => 'caniincasa_archives',
        'settings'    => 'caniincasa_archive_header_bg',
        'description' => __( 'Immagine di sfondo per header pagine archivio', 'caniincasa' ),
    ) ) );

    // Archive Header Overlay
    $wp_customize->add_setting( 'caniincasa_archive_overlay_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'caniincasa_archive_overlay_color', array(
        'label'    => __( 'Colore Overlay Archivi', 'caniincasa' ),
        'section'  => 'caniincasa_archives',
        'settings' => 'caniincasa_archive_overlay_color',
    ) ) );

}
add_action( 'customize_register', 'caniincasa_customize_register' );

/**
 * Sanitize Float
 */
function caniincasa_sanitize_float( $value ) {
    return floatval( $value );
}

/**
 * Customizer CSS Output
 */
function caniincasa_customizer_css() {
    ?>
    <style type="text/css">
        :root {
            <?php if ( get_theme_mod( 'caniincasa_primary_color' ) ) : ?>
                --primary: <?php echo esc_attr( get_theme_mod( 'caniincasa_primary_color', '#FF6B35' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_secondary_color' ) ) : ?>
                --secondary: <?php echo esc_attr( get_theme_mod( 'caniincasa_secondary_color', '#004E89' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_accent_color' ) ) : ?>
                --accent: <?php echo esc_attr( get_theme_mod( 'caniincasa_accent_color', '#F7B801' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_text_color' ) ) : ?>
                --text-primary: <?php echo esc_attr( get_theme_mod( 'caniincasa_text_color', '#1a202c' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_link_color' ) ) : ?>
                --link-color: <?php echo esc_attr( get_theme_mod( 'caniincasa_link_color', '#FF6B35' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_container_width' ) ) : ?>
                --container-width: <?php echo esc_attr( get_theme_mod( 'caniincasa_container_width', '1200' ) ); ?>px;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_border_radius' ) ) : ?>
                --radius-md: <?php echo esc_attr( get_theme_mod( 'caniincasa_border_radius', '8' ) ); ?>px;
            <?php endif; ?>
        }

        body {
            <?php if ( get_theme_mod( 'caniincasa_background_color' ) ) : ?>
                background-color: <?php echo esc_attr( get_theme_mod( 'caniincasa_background_color', '#ffffff' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_body_font' ) ) : ?>
                font-family: <?php echo esc_attr( get_theme_mod( 'caniincasa_body_font', 'system-ui' ) ); ?>, sans-serif;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_font_size' ) ) : ?>
                font-size: <?php echo esc_attr( get_theme_mod( 'caniincasa_font_size', '16' ) ); ?>px;
            <?php endif; ?>
        }

        h1, h2, h3, h4, h5, h6,
        .site-title {
            <?php if ( get_theme_mod( 'caniincasa_heading_font' ) ) : ?>
                font-family: <?php echo esc_attr( get_theme_mod( 'caniincasa_heading_font', 'system-ui' ) ); ?>, sans-serif;
            <?php endif; ?>
        }

        .site-header {
            <?php if ( get_theme_mod( 'caniincasa_header_bg_color' ) ) : ?>
                background-color: <?php echo esc_attr( get_theme_mod( 'caniincasa_header_bg_color', '#ffffff' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_header_padding' ) ) : ?>
                padding-top: <?php echo esc_attr( get_theme_mod( 'caniincasa_header_padding', '20' ) ); ?>px;
                padding-bottom: <?php echo esc_attr( get_theme_mod( 'caniincasa_header_padding', '20' ) ); ?>px;
            <?php endif; ?>
        }

        <?php if ( get_theme_mod( 'caniincasa_header_sticky', true ) ) : ?>
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        <?php endif; ?>

        .site-header a,
        .main-navigation a {
            <?php if ( get_theme_mod( 'caniincasa_header_text_color' ) ) : ?>
                color: <?php echo esc_attr( get_theme_mod( 'caniincasa_header_text_color', '#1a202c' ) ); ?>;
            <?php endif; ?>
        }

        .custom-logo {
            <?php if ( get_theme_mod( 'caniincasa_logo_height' ) ) : ?>
                height: <?php echo esc_attr( get_theme_mod( 'caniincasa_logo_height', '60' ) ); ?>px;
                width: auto;
            <?php endif; ?>
        }

        .hero {
            <?php if ( get_theme_mod( 'caniincasa_hero_bg_image' ) ) : ?>
                background-image: url(<?php echo esc_url( get_theme_mod( 'caniincasa_hero_bg_image' ) ); ?>);
                background-size: cover;
                background-position: center;
            <?php endif; ?>
        }

        .hero::before {
            <?php if ( get_theme_mod( 'caniincasa_hero_overlay_color' ) ) : ?>
                background: <?php echo esc_attr( get_theme_mod( 'caniincasa_hero_overlay_color', '#FF6B35' ) ); ?>;
            <?php endif; ?>

            <?php if ( get_theme_mod( 'caniincasa_hero_overlay_opacity' ) ) : ?>
                opacity: <?php echo esc_attr( get_theme_mod( 'caniincasa_hero_overlay_opacity', '0.9' ) ); ?>;
            <?php endif; ?>
        }

        .site-footer {
            <?php if ( get_theme_mod( 'caniincasa_footer_bg_color' ) ) : ?>
                background-color: <?php echo esc_attr( get_theme_mod( 'caniincasa_footer_bg_color', '#1a202c' ) ); ?>;
            <?php endif; ?>
        }

        .site-footer,
        .site-footer a {
            <?php if ( get_theme_mod( 'caniincasa_footer_text_color' ) ) : ?>
                color: <?php echo esc_attr( get_theme_mod( 'caniincasa_footer_text_color', '#ffffff' ) ); ?>;
            <?php endif; ?>
        }

        .container {
            <?php if ( get_theme_mod( 'caniincasa_container_width' ) ) : ?>
                max-width: <?php echo esc_attr( get_theme_mod( 'caniincasa_container_width', '1200' ) ); ?>px;
            <?php endif; ?>
        }

        a {
            <?php if ( get_theme_mod( 'caniincasa_link_color' ) ) : ?>
                color: <?php echo esc_attr( get_theme_mod( 'caniincasa_link_color', '#FF6B35' ) ); ?>;
            <?php endif; ?>
        }

        .archive-header {
            <?php if ( get_theme_mod( 'caniincasa_archive_header_bg' ) ) : ?>
                background-image: url(<?php echo esc_url( get_theme_mod( 'caniincasa_archive_header_bg' ) ); ?>);
                background-size: cover;
                background-position: center;
                position: relative;
                color: white;
            <?php endif; ?>
        }

        <?php if ( get_theme_mod( 'caniincasa_archive_header_bg' ) ) : ?>
        .archive-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: <?php echo esc_attr( get_theme_mod( 'caniincasa_archive_overlay_color', '#FF6B35' ) ); ?>;
            opacity: 0.85;
            z-index: 1;
        }

        .archive-header > * {
            position: relative;
            z-index: 2;
        }
        <?php endif; ?>

        .cta-card {
            <?php if ( get_theme_mod( 'caniincasa_cta_bg_color' ) ) : ?>
                background: <?php echo esc_attr( get_theme_mod( 'caniincasa_cta_bg_color', '#F7B801' ) ); ?>;
            <?php endif; ?>
        }
    </style>
    <?php
}
add_action( 'wp_head', 'caniincasa_customizer_css' );

/**
 * Enqueue Google Fonts
 */
function caniincasa_enqueue_google_fonts() {
    $fonts = array();

    $heading_font = get_theme_mod( 'caniincasa_heading_font', 'system-ui' );
    $body_font = get_theme_mod( 'caniincasa_body_font', 'system-ui' );

    $google_fonts = array( 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins', 'Raleway', 'Playfair Display', 'Inter' );

    if ( in_array( $heading_font, $google_fonts ) ) {
        $fonts[] = str_replace( ' ', '+', $heading_font ) . ':400,500,600,700';
    }

    if ( in_array( $body_font, $google_fonts ) && $body_font !== $heading_font ) {
        $fonts[] = str_replace( ' ', '+', $body_font ) . ':400,500,600,700';
    }

    if ( ! empty( $fonts ) ) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $fonts ) . '&display=swap';
        wp_enqueue_style( 'caniincasa-google-fonts', $fonts_url, array(), null );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_enqueue_google_fonts' );

/**
 * Hero Settings for Post Types
 */
function caniincasa_customizer_hero_settings( $wp_customize ) {
    // Add Hero Settings Section
    $wp_customize->add_section( 'caniincasa_hero_settings', array(
        'title'    => __( 'Impostazioni Barra Titolo', 'caniincasa' ),
        'priority' => 35,
    ) );

    // Post Types to configure
    $post_types = array(
        'razze_di_cani' => 'Razze di Cani',
        'allevamenti' => 'Allevamenti',
        'struttureveterinarie' => 'Veterinari',
        'canili' => 'Canili',
        'centri_cinofili' => 'Centri Cinofili',
        'pensioni_per_cani' => 'Pensioni',
    );

    foreach ( $post_types as $post_type => $label ) {
        // Subtitle setting
        $wp_customize->add_setting( 'hero_subtitle_' . $post_type, array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'hero_subtitle_' . $post_type, array(
            'label'       => sprintf( __( 'Sottotitolo %s', 'caniincasa' ), $label ),
            'section'     => 'caniincasa_hero_settings',
            'type'        => 'text',
            'description' => sprintf( __( 'Sottotitolo predefinito per %s', 'caniincasa' ), $label ),
        ) );

        // Background Image setting
        $wp_customize->add_setting( 'hero_image_' . $post_type, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ) );

        $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'hero_image_' . $post_type, array(
            'label'       => sprintf( __( 'Immagine Sfondo %s', 'caniincasa' ), $label ),
            'section'     => 'caniincasa_hero_settings',
            'mime_type'   => 'image',
            'description' => sprintf( __( 'Immagine di sfondo predefinita per %s', 'caniincasa' ), $label ),
        ) ) );
    }
}
add_action( 'customize_register', 'caniincasa_customizer_hero_settings' );

/**
 * Buttons Style Settings
 */
function caniincasa_customizer_buttons_settings( $wp_customize ) {

    // Section: Pulsanti
    $wp_customize->add_section( 'caniincasa_buttons', array(
        'title'    => __( 'Stile Pulsanti', 'caniincasa' ),
        'priority' => 40,
    ) );

    // Button Primary - Background Color
    $wp_customize->add_setting( 'button_primary_bg_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_bg_color', array(
        'label'    => __( 'Pulsante Primario - Colore Sfondo', 'caniincasa' ),
        'section'  => 'caniincasa_buttons',
        'settings' => 'button_primary_bg_color',
    ) ) );

    // Button Primary - Text Color
    $wp_customize->add_setting( 'button_primary_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_text_color', array(
        'label'    => __( 'Pulsante Primario - Colore Testo', 'caniincasa' ),
        'section'  => 'caniincasa_buttons',
        'settings' => 'button_primary_text_color',
    ) ) );

    // Button Primary - Border Color
    $wp_customize->add_setting( 'button_primary_border_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_border_color', array(
        'label'    => __( 'Pulsante Primario - Colore Bordo', 'caniincasa' ),
        'section'  => 'caniincasa_buttons',
        'settings' => 'button_primary_border_color',
    ) ) );

    // Button Primary - Border Width
    $wp_customize->add_setting( 'button_primary_border_width', array(
        'default'           => '2',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_primary_border_width', array(
        'label'       => __( 'Pulsante Primario - Spessore Bordo (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 10,
            'step' => 1,
        ),
    ) );

    // Button Primary - Border Radius
    $wp_customize->add_setting( 'button_primary_border_radius', array(
        'default'           => '6',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_primary_border_radius', array(
        'label'       => __( 'Pulsante Primario - Arrotondamento (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
    ) );

    // Button Primary - Padding Vertical
    $wp_customize->add_setting( 'button_primary_padding_vertical', array(
        'default'           => '12',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_primary_padding_vertical', array(
        'label'       => __( 'Pulsante Primario - Padding Verticale (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
    ) );

    // Button Primary - Padding Horizontal
    $wp_customize->add_setting( 'button_primary_padding_horizontal', array(
        'default'           => '24',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_primary_padding_horizontal', array(
        'label'       => __( 'Pulsante Primario - Padding Orizzontale (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ) );

    // ---- BUTTON SECONDARY ----

    // Button Secondary - Background Color
    $wp_customize->add_setting( 'button_secondary_bg_color', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_secondary_bg_color', array(
        'label'       => __( 'Pulsante Secondario - Colore Sfondo', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'text',
        'description' => __( 'Usa "transparent" per sfondo trasparente o un colore HEX', 'caniincasa' ),
    ) );

    // Button Secondary - Text Color
    $wp_customize->add_setting( 'button_secondary_text_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_secondary_text_color', array(
        'label'    => __( 'Pulsante Secondario - Colore Testo', 'caniincasa' ),
        'section'  => 'caniincasa_buttons',
        'settings' => 'button_secondary_text_color',
    ) ) );

    // Button Secondary - Border Color
    $wp_customize->add_setting( 'button_secondary_border_color', array(
        'default'           => '#FF6B35',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_secondary_border_color', array(
        'label'    => __( 'Pulsante Secondario - Colore Bordo', 'caniincasa' ),
        'section'  => 'caniincasa_buttons',
        'settings' => 'button_secondary_border_color',
    ) ) );

    // Button Secondary - Border Width
    $wp_customize->add_setting( 'button_secondary_border_width', array(
        'default'           => '2',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_secondary_border_width', array(
        'label'       => __( 'Pulsante Secondario - Spessore Bordo (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 10,
            'step' => 1,
        ),
    ) );

    // Button Secondary - Border Radius
    $wp_customize->add_setting( 'button_secondary_border_radius', array(
        'default'           => '6',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_secondary_border_radius', array(
        'label'       => __( 'Pulsante Secondario - Arrotondamento (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
    ) );

    // Button Secondary - Padding Vertical
    $wp_customize->add_setting( 'button_secondary_padding_vertical', array(
        'default'           => '12',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_secondary_padding_vertical', array(
        'label'       => __( 'Pulsante Secondario - Padding Verticale (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 50,
            'step' => 1,
        ),
    ) );

    // Button Secondary - Padding Horizontal
    $wp_customize->add_setting( 'button_secondary_padding_horizontal', array(
        'default'           => '24',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'button_secondary_padding_horizontal', array(
        'label'       => __( 'Pulsante Secondario - Padding Orizzontale (px)', 'caniincasa' ),
        'section'     => 'caniincasa_buttons',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ) );
}
add_action( 'customize_register', 'caniincasa_customizer_buttons_settings' );

/**
 * Output Button Styles from Customizer
 */
function caniincasa_customizer_buttons_css() {
    // Get customizer values
    $primary_bg = get_theme_mod( 'button_primary_bg_color', '#FF6B35' );
    $primary_text = get_theme_mod( 'button_primary_text_color', '#ffffff' );
    $primary_border = get_theme_mod( 'button_primary_border_color', '#FF6B35' );
    $primary_border_width = get_theme_mod( 'button_primary_border_width', '2' );
    $primary_radius = get_theme_mod( 'button_primary_border_radius', '6' );
    $primary_pad_v = get_theme_mod( 'button_primary_padding_vertical', '12' );
    $primary_pad_h = get_theme_mod( 'button_primary_padding_horizontal', '24' );

    $secondary_bg = get_theme_mod( 'button_secondary_bg_color', 'transparent' );
    $secondary_text = get_theme_mod( 'button_secondary_text_color', '#FF6B35' );
    $secondary_border = get_theme_mod( 'button_secondary_border_color', '#FF6B35' );
    $secondary_border_width = get_theme_mod( 'button_secondary_border_width', '2' );
    $secondary_radius = get_theme_mod( 'button_secondary_border_radius', '6' );
    $secondary_pad_v = get_theme_mod( 'button_secondary_padding_vertical', '12' );
    $secondary_pad_h = get_theme_mod( 'button_secondary_padding_horizontal', '24' );

    // Output CSS
    ?>
    <style type="text/css">
        /* Primary Buttons */
        .btn-primary,
        .btn.btn-primary,
        button.btn-primary,
        input[type="submit"],
        .user-register.btn-primary {
            background-color: <?php echo esc_attr( $primary_bg ); ?>;
            color: <?php echo esc_attr( $primary_text ); ?>;
            border: <?php echo esc_attr( $primary_border_width ); ?>px solid <?php echo esc_attr( $primary_border ); ?>;
            border-radius: <?php echo esc_attr( $primary_radius ); ?>px;
            padding: <?php echo esc_attr( $primary_pad_v ); ?>px <?php echo esc_attr( $primary_pad_h ); ?>px;
        }

        .btn-primary:hover,
        .btn.btn-primary:hover,
        button.btn-primary:hover {
            opacity: 0.9;
        }

        /* Secondary/Outline Buttons */
        .btn-secondary,
        .btn-outline,
        .btn.btn-outline,
        button.btn-outline {
            background-color: <?php echo esc_attr( $secondary_bg ); ?>;
            color: <?php echo esc_attr( $secondary_text ); ?>;
            border: <?php echo esc_attr( $secondary_border_width ); ?>px solid <?php echo esc_attr( $secondary_border ); ?>;
            border-radius: <?php echo esc_attr( $secondary_radius ); ?>px;
            padding: <?php echo esc_attr( $secondary_pad_v ); ?>px <?php echo esc_attr( $secondary_pad_h ); ?>px;
        }

        .btn-secondary:hover,
        .btn-outline:hover,
        .btn.btn-outline:hover {
            background-color: <?php echo esc_attr( $secondary_border ); ?>;
            color: #ffffff;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'caniincasa_customizer_buttons_css' );

/**
 * Customizer Live Preview
 */
function caniincasa_customizer_live_preview() {
    wp_enqueue_script(
        'caniincasa-customizer',
        CANIINCASA_THEME_URI . '/js/customizer.js',
        array( 'jquery', 'customize-preview' ),
        CANIINCASA_VERSION,
        true
    );
}
add_action( 'customize_preview_init', 'caniincasa_customizer_live_preview' );
