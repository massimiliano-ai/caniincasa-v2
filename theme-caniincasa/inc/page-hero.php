<?php
/**
 * Page Hero / Title Bar Component
 *
 * Funzione riutilizzabile per generare la barra del titolo con immagine/gradiente
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display Page Hero Section
 *
 * @param array $args {
 *     Optional. Array of arguments.
 *
 *     @type string $title       H1 title. Default: current page title
 *     @type string $subtitle    H2 subtitle. Default: auto from post type or customizer
 *     @type string $image       Background image URL. Default: from post meta or customizer
 *     @type bool   $use_excerpt Use page excerpt as subtitle. Default: false
 * }
 */
function caniincasa_page_hero( $args = array() ) {

    // Default arguments
    $defaults = array(
        'title'       => '',
        'subtitle'    => '',
        'image'       => '',
        'use_excerpt' => false,
    );

    $args = wp_parse_args( $args, $defaults );

    // Get title
    $title = ! empty( $args['title'] ) ? $args['title'] : get_the_title();

    // Get subtitle
    $subtitle = caniincasa_get_page_subtitle( $args );

    // Get background image
    $bg_image = caniincasa_get_hero_background_image( $args );

    // Build style attribute
    $style_attr = '';
    if ( ! empty( $bg_image ) ) {
        $style_attr = sprintf(
            'style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(%s);"',
            esc_url( $bg_image )
        );
    }

    // Output hero section
    ?>
    <section class="page-hero" <?php echo $style_attr; ?>>
        <div class="container">
            <div class="page-hero__content">
                <h1 class="page-hero__title"><?php echo esc_html( $title ); ?></h1>
                <?php if ( ! empty( $subtitle ) ) : ?>
                    <h2 class="page-hero__subtitle"><?php echo esc_html( $subtitle ); ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Get Page Subtitle
 *
 * Priority order:
 * 1. Passed subtitle argument
 * 2. Page/Post custom field 'page_subtitle'
 * 3. Customizer setting for post type
 * 4. Post type label
 * 5. Page excerpt (if use_excerpt is true)
 *
 * @param array $args Arguments from caniincasa_page_hero()
 * @return string Subtitle text
 */
function caniincasa_get_page_subtitle( $args ) {

    // 1. Check passed argument
    if ( ! empty( $args['subtitle'] ) ) {
        return $args['subtitle'];
    }

    // 2. Check post meta
    $meta_subtitle = get_post_meta( get_the_ID(), 'page_subtitle', true );
    if ( ! empty( $meta_subtitle ) ) {
        return $meta_subtitle;
    }

    // 3. Check customizer setting for current post type
    $post_type = get_post_type();
    $customizer_subtitle = get_theme_mod( 'hero_subtitle_' . $post_type, '' );
    if ( ! empty( $customizer_subtitle ) ) {
        return $customizer_subtitle;
    }

    // 4. Get post type label
    if ( ! empty( $post_type ) ) {
        $post_type_obj = get_post_type_object( $post_type );
        if ( $post_type_obj ) {
            // Use post type label as fallback
            return $post_type_obj->labels->name;
        }
    }

    // 5. Use excerpt if enabled
    if ( $args['use_excerpt'] && has_excerpt() ) {
        return get_the_excerpt();
    }

    return '';
}

/**
 * Get Hero Background Image
 *
 * Priority order:
 * 1. Passed image URL
 * 2. Post featured image
 * 3. Post custom field 'hero_background_image'
 * 4. Customizer setting for post type 'hero_image_{post_type}'
 * 5. Empty (will use gradient)
 *
 * @param array $args Arguments from caniincasa_page_hero()
 * @return string Image URL or empty string
 */
function caniincasa_get_hero_background_image( $args ) {

    // 1. Check passed argument
    if ( ! empty( $args['image'] ) ) {
        return $args['image'];
    }

    // 2. Check post meta for hero image
    $meta_image_id = get_post_meta( get_the_ID(), 'hero_background_image', true );
    if ( ! empty( $meta_image_id ) ) {
        $image_url = wp_get_attachment_image_url( $meta_image_id, 'full' );
        if ( $image_url ) {
            return $image_url;
        }
    }

    // 3. Check customizer setting for post type
    $post_type = get_post_type();
    $customizer_image_id = get_theme_mod( 'hero_image_' . $post_type, '' );
    if ( ! empty( $customizer_image_id ) ) {
        $image_url = wp_get_attachment_image_url( $customizer_image_id, 'full' );
        if ( $image_url ) {
            return $image_url;
        }
    }

    // 4. Return empty (will use gradient fallback)
    return '';
}
