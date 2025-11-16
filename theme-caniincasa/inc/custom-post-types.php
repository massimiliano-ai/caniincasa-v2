<?php
/**
 * Custom Post Types Registration
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register all Custom Post Types
 */
function caniincasa_register_post_types() {

    /**
     * 1. Razze di Cani
     * URL: /razze_di_cani/{slug}/
     */
    register_post_type( 'razze_di_cani', array(
        'labels' => array(
            'name'                  => _x( 'Razze di Cani', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Razza di Cane', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Razze di Cani', 'Admin Menu text', 'caniincasa' ),
            'name_admin_bar'        => _x( 'Razza', 'Add New on Toolbar', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuova Razza', 'caniincasa' ),
            'new_item'              => __( 'Nuova Razza', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Razza', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Razza', 'caniincasa' ),
            'all_items'             => __( 'Tutte le Razze', 'caniincasa' ),
            'search_items'          => __( 'Cerca Razze', 'caniincasa' ),
            'parent_item_colon'     => __( 'Razza Genitore:', 'caniincasa' ),
            'not_found'             => __( 'Nessuna razza trovata.', 'caniincasa' ),
            'not_found_in_trash'    => __( 'Nessuna razza trovata nel cestino.', 'caniincasa' ),
            'featured_image'        => _x( 'Immagine Razza', 'Overrides the "Featured Image" phrase', 'caniincasa' ),
            'set_featured_image'    => _x( 'Imposta immagine razza', 'Overrides the "Set featured image" phrase', 'caniincasa' ),
            'remove_featured_image' => _x( 'Rimuovi immagine razza', 'Overrides the "Remove featured image" phrase', 'caniincasa' ),
            'use_featured_image'    => _x( 'Usa come immagine razza', 'Overrides the "Use as featured image" phrase', 'caniincasa' ),
            'archives'              => _x( 'Archivi Razze', 'The post type archive label used in nav menus', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-pets',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt', 'revisions' ),
        'rewrite'             => array( 'slug' => 'razze_di_cani', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 2. Allevamenti
     * URL: /allevamenti/{slug}/
     */
    register_post_type( 'allevamenti', array(
        'labels' => array(
            'name'                  => _x( 'Allevamenti', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Allevamento', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Allevamenti', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuovo Allevamento', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Allevamento', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Allevamento', 'caniincasa' ),
            'all_items'             => __( 'Tutti gli Allevamenti', 'caniincasa' ),
            'search_items'          => __( 'Cerca Allevamenti', 'caniincasa' ),
            'not_found'             => __( 'Nessun allevamento trovato.', 'caniincasa' ),
            'not_found_in_trash'    => __( 'Nessun allevamento trovato nel cestino.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-building',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'excerpt' ),
        'rewrite'             => array( 'slug' => 'allevamenti', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 3. Strutture Veterinarie
     * URL: /struttureveterinarie/{slug}/
     */
    register_post_type( 'struttureveterinarie', array(
        'labels' => array(
            'name'                  => _x( 'Strutture Veterinarie', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Struttura Veterinaria', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Veterinari', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuova Struttura', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Struttura', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Struttura', 'caniincasa' ),
            'all_items'             => __( 'Tutte le Strutture', 'caniincasa' ),
            'search_items'          => __( 'Cerca Strutture', 'caniincasa' ),
            'not_found'             => __( 'Nessuna struttura trovata.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 22,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'struttureveterinarie', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 4. Patologie Canine
     * URL: /patologie_canine/{slug}/
     */
    register_post_type( 'patologie_canine', array(
        'labels' => array(
            'name'                  => _x( 'Patologie Canine', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Patologia Canina', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Patologie', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuova Patologia', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Patologia', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Patologia', 'caniincasa' ),
            'all_items'             => __( 'Tutte le Patologie', 'caniincasa' ),
            'search_items'          => __( 'Cerca Patologie', 'caniincasa' ),
            'not_found'             => __( 'Nessuna patologia trovata.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => false,
        'menu_position'       => 23,
        'menu_icon'           => 'dashicons-heart',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'rewrite'             => array( 'slug' => 'patologie_canine', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 5. FAQ
     * URL: /faq/{slug}/
     */
    register_post_type( 'faq', array(
        'labels' => array(
            'name'                  => _x( 'FAQ', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'FAQ', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'FAQ', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuova FAQ', 'caniincasa' ),
            'edit_item'             => __( 'Modifica FAQ', 'caniincasa' ),
            'view_item'             => __( 'Visualizza FAQ', 'caniincasa' ),
            'all_items'             => __( 'Tutte le FAQ', 'caniincasa' ),
            'search_items'          => __( 'Cerca FAQ', 'caniincasa' ),
            'not_found'             => __( 'Nessuna FAQ trovata.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 24,
        'menu_icon'           => 'dashicons-editor-help',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'faq', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 6. Annunci Dogsitter
     * URL: /annunci_dogsitter/{slug}/
     */
    register_post_type( 'annunci_dogsitter', array(
        'labels' => array(
            'name'                  => _x( 'Annunci Dogsitter', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Annuncio Dogsitter', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Dogsitter', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuovo Annuncio', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Annuncio', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Annuncio', 'caniincasa' ),
            'all_items'             => __( 'Tutti gli Annunci', 'caniincasa' ),
            'search_items'          => __( 'Cerca Annunci', 'caniincasa' ),
            'not_found'             => __( 'Nessun annuncio trovato.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-groups',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'annunci_dogsitter', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 7. Annunci Cucciolate
     * URL: /annunci_cucciolate/{slug}/
     */
    register_post_type( 'annunci_cucciolate', array(
        'labels' => array(
            'name'                  => _x( 'Annunci Cucciolate', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Annuncio Cucciolata', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Cucciolate', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuovo Annuncio', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Annuncio', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Annuncio', 'caniincasa' ),
            'all_items'             => __( 'Tutti gli Annunci', 'caniincasa' ),
            'search_items'          => __( 'Cerca Annunci', 'caniincasa' ),
            'not_found'             => __( 'Nessun annuncio trovato.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-admin-post',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'annunci_cucciolate', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 8. Canili
     * URL: /canili/{slug}/
     */
    register_post_type( 'canili', array(
        'labels' => array(
            'name'                  => _x( 'Canili', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Canile', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Canili', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuovo Canile', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Canile', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Canile', 'caniincasa' ),
            'all_items'             => __( 'Tutti i Canili', 'caniincasa' ),
            'search_items'          => __( 'Cerca Canili', 'caniincasa' ),
            'not_found'             => __( 'Nessun canile trovato.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 27,
        'menu_icon'           => 'dashicons-admin-home',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'canili', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 9. Centri Cinofili
     * URL: /centri_cinofili/{slug}/
     */
    register_post_type( 'centri_cinofili', array(
        'labels' => array(
            'name'                  => _x( 'Centri Cinofili', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Centro Cinofilo', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Centri Cinofili', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuovo Centro', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Centro', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Centro', 'caniincasa' ),
            'all_items'             => __( 'Tutti i Centri', 'caniincasa' ),
            'search_items'          => __( 'Cerca Centri', 'caniincasa' ),
            'not_found'             => __( 'Nessun centro trovato.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 28,
        'menu_icon'           => 'dashicons-awards',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'centri_cinofili', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 10. Pensioni per Cani
     * URL: /pensioni_per_cani/{slug}/
     */
    register_post_type( 'pensioni_per_cani', array(
        'labels' => array(
            'name'                  => _x( 'Pensioni per Cani', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Pensione per Cani', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Pensioni', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuova Pensione', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Pensione', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Pensione', 'caniincasa' ),
            'all_items'             => __( 'Tutte le Pensioni', 'caniincasa' ),
            'search_items'          => __( 'Cerca Pensioni', 'caniincasa' ),
            'not_found'             => __( 'Nessuna pensione trovata.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 29,
        'menu_icon'           => 'dashicons-admin-multisite',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'pensioni_per_cani', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * 11. Colori Mantello
     * URL: /colore/{slug}/
     */
    register_post_type( 'colore', array(
        'labels' => array(
            'name'                  => _x( 'Colori', 'Post type general name', 'caniincasa' ),
            'singular_name'         => _x( 'Colore', 'Post type singular name', 'caniincasa' ),
            'menu_name'             => _x( 'Colori Mantello', 'Admin Menu text', 'caniincasa' ),
            'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
            'add_new_item'          => __( 'Aggiungi Nuovo Colore', 'caniincasa' ),
            'edit_item'             => __( 'Modifica Colore', 'caniincasa' ),
            'view_item'             => __( 'Visualizza Colore', 'caniincasa' ),
            'all_items'             => __( 'Tutti i Colori', 'caniincasa' ),
            'search_items'          => __( 'Cerca Colori', 'caniincasa' ),
            'not_found'             => __( 'Nessun colore trovato.', 'caniincasa' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'query_var'           => true,
        'has_archive'         => true, // Abilitato per supportare archivi e paginazione
        'hierarchical'        => true,
        'menu_position'       => 30,
        'menu_icon'           => 'dashicons-art',
        'capability_type'     => 'post',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
        'rewrite'             => array( 'slug' => 'colore', 'with_front' => true ),
        'can_export'          => true,
    ) );

    /**
     * Flush rewrite rules on theme activation and when CPT settings change
     * Force flush if has_archive was recently enabled
     */
    $flush_version = 'v2_has_archive_enabled'; // Incrementa quando cambiano le rewrite rules
    if ( get_option( 'caniincasa_flush_rewrite_rules' ) !== $flush_version ) {
        flush_rewrite_rules();
        update_option( 'caniincasa_flush_rewrite_rules', $flush_version );
    }
}
add_action( 'init', 'caniincasa_register_post_types' );

/**
 * Customize admin columns for Custom Post Types
 */

// Razze di Cani - Add custom columns
function caniincasa_razze_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __( 'Nome Razza', 'caniincasa' );
    $new_columns['thumbnail'] = __( 'Immagine', 'caniincasa' );
    $new_columns['taxonomies'] = __( 'Categorie', 'caniincasa' );
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter( 'manage_razze_di_cani_posts_columns', 'caniincasa_razze_columns' );

// Allevamenti - Add custom columns
function caniincasa_allevamenti_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __( 'Nome Allevamento', 'caniincasa' );
    $new_columns['thumbnail'] = __( 'Immagine', 'caniincasa' );
    $new_columns['provincia'] = __( 'Provincia', 'caniincasa' );
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter( 'manage_allevamenti_posts_columns', 'caniincasa_allevamenti_columns' );

// Populate custom columns
function caniincasa_custom_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'thumbnail':
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
            } else {
                echo '—';
            }
            break;
        case 'provincia':
            $provincia = get_post_meta( $post_id, 'provincia_', true );
            echo $provincia ? esc_html( $provincia ) : '—';
            break;
        case 'taxonomies':
            $taxonomies = get_object_taxonomies( get_post_type( $post_id ) );
            $terms_list = array();
            foreach ( $taxonomies as $taxonomy ) {
                $terms = get_the_terms( $post_id, $taxonomy );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $terms_list[] = $term->name;
                    }
                }
            }
            echo ! empty( $terms_list ) ? esc_html( implode( ', ', $terms_list ) ) : '—';
            break;
    }
}
add_action( 'manage_razze_di_cani_posts_custom_column', 'caniincasa_custom_column_content', 10, 2 );
add_action( 'manage_allevamenti_posts_custom_column', 'caniincasa_custom_column_content', 10, 2 );
add_action( 'manage_struttureveterinarie_posts_custom_column', 'caniincasa_custom_column_content', 10, 2 );
