<?php
/**
 * Custom Taxonomies Registration
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register all Custom Taxonomies
 */
function caniincasa_register_taxonomies() {

    /**
     * 1. Razze Allevamenti
     * Taxonomy to connect Allevamenti and Razze
     * Used on: allevamenti, razze_di_cani
     */
    register_taxonomy( 'razze_allevamenti', array( 'allevamenti', 'razze_di_cani' ), array(
        'labels' => array(
            'name'                       => _x( 'Razze Allevamenti', 'Taxonomy general name', 'caniincasa' ),
            'singular_name'              => _x( 'Razza Allevamento', 'Taxonomy singular name', 'caniincasa' ),
            'menu_name'                  => __( 'Razze Allevamenti', 'caniincasa' ),
            'all_items'                  => __( 'Tutte le Razze', 'caniincasa' ),
            'parent_item'                => __( 'Razza Genitore', 'caniincasa' ),
            'parent_item_colon'          => __( 'Razza Genitore:', 'caniincasa' ),
            'new_item_name'              => __( 'Nuova Razza', 'caniincasa' ),
            'add_new_item'               => __( 'Aggiungi Nuova Razza', 'caniincasa' ),
            'edit_item'                  => __( 'Modifica Razza', 'caniincasa' ),
            'update_item'                => __( 'Aggiorna Razza', 'caniincasa' ),
            'view_item'                  => __( 'Visualizza Razza', 'caniincasa' ),
            'separate_items_with_commas' => __( 'Separa razze con virgole', 'caniincasa' ),
            'add_or_remove_items'        => __( 'Aggiungi o rimuovi razze', 'caniincasa' ),
            'choose_from_most_used'      => __( 'Scegli tra le più usate', 'caniincasa' ),
            'popular_items'              => __( 'Razze Popolari', 'caniincasa' ),
            'search_items'               => __( 'Cerca Razze', 'caniincasa' ),
            'not_found'                  => __( 'Nessuna razza trovata', 'caniincasa' ),
            'no_terms'                   => __( 'Nessuna razza', 'caniincasa' ),
            'items_list'                 => __( 'Elenco razze', 'caniincasa' ),
            'items_list_navigation'      => __( 'Navigazione elenco razze', 'caniincasa' ),
        ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => false,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array(
            'slug'         => 'razze_allevamenti',
            'with_front'   => true,
            'hierarchical' => true,
        ),
    ) );

    /**
     * 2. Tipologia di Cani
     * Taxonomy to categorize dog breeds
     * Used on: razze_di_cani
     */
    register_taxonomy( 'tipologia_di_cani', array( 'razze_di_cani' ), array(
        'labels' => array(
            'name'                       => _x( 'Tipologie di Cani', 'Taxonomy general name', 'caniincasa' ),
            'singular_name'              => _x( 'Tipologia', 'Taxonomy singular name', 'caniincasa' ),
            'menu_name'                  => __( 'Tipologie', 'caniincasa' ),
            'all_items'                  => __( 'Tutte le Tipologie', 'caniincasa' ),
            'parent_item'                => __( 'Tipologia Genitore', 'caniincasa' ),
            'parent_item_colon'          => __( 'Tipologia Genitore:', 'caniincasa' ),
            'new_item_name'              => __( 'Nuova Tipologia', 'caniincasa' ),
            'add_new_item'               => __( 'Aggiungi Nuova Tipologia', 'caniincasa' ),
            'edit_item'                  => __( 'Modifica Tipologia', 'caniincasa' ),
            'update_item'                => __( 'Aggiorna Tipologia', 'caniincasa' ),
            'view_item'                  => __( 'Visualizza Tipologia', 'caniincasa' ),
            'separate_items_with_commas' => __( 'Separa tipologie con virgole', 'caniincasa' ),
            'add_or_remove_items'        => __( 'Aggiungi o rimuovi tipologie', 'caniincasa' ),
            'choose_from_most_used'      => __( 'Scegli tra le più usate', 'caniincasa' ),
            'popular_items'              => __( 'Tipologie Popolari', 'caniincasa' ),
            'search_items'               => __( 'Cerca Tipologie', 'caniincasa' ),
            'not_found'                  => __( 'Nessuna tipologia trovata', 'caniincasa' ),
            'no_terms'                   => __( 'Nessuna tipologia', 'caniincasa' ),
            'items_list'                 => __( 'Elenco tipologie', 'caniincasa' ),
            'items_list_navigation'      => __( 'Navigazione elenco tipologie', 'caniincasa' ),
        ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array(
            'slug'         => 'tipologia',
            'with_front'   => true,
            'hierarchical' => true,
        ),
    ) );

    /**
     * 3. Categoria FAQ (optional)
     * Taxonomy to categorize FAQ
     * Used on: faq
     */
    register_taxonomy( 'categoria_faq', array( 'faq' ), array(
        'labels' => array(
            'name'                       => _x( 'Categorie FAQ', 'Taxonomy general name', 'caniincasa' ),
            'singular_name'              => _x( 'Categoria FAQ', 'Taxonomy singular name', 'caniincasa' ),
            'menu_name'                  => __( 'Categorie', 'caniincasa' ),
            'all_items'                  => __( 'Tutte le Categorie', 'caniincasa' ),
            'new_item_name'              => __( 'Nuova Categoria', 'caniincasa' ),
            'add_new_item'               => __( 'Aggiungi Nuova Categoria', 'caniincasa' ),
            'edit_item'                  => __( 'Modifica Categoria', 'caniincasa' ),
            'update_item'                => __( 'Aggiorna Categoria', 'caniincasa' ),
            'view_item'                  => __( 'Visualizza Categoria', 'caniincasa' ),
            'search_items'               => __( 'Cerca Categorie', 'caniincasa' ),
            'not_found'                  => __( 'Nessuna categoria trovata', 'caniincasa' ),
        ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => false,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array(
            'slug'         => 'categoria-faq',
            'with_front'   => true,
            'hierarchical' => true,
        ),
    ) );

    /**
     * 4. Servizi Veterinari (optional)
     * Taxonomy to categorize veterinary services
     * Used on: struttureveterinarie
     */
    register_taxonomy( 'servizi_veterinari', array( 'struttureveterinarie' ), array(
        'labels' => array(
            'name'                       => _x( 'Servizi Veterinari', 'Taxonomy general name', 'caniincasa' ),
            'singular_name'              => _x( 'Servizio', 'Taxonomy singular name', 'caniincasa' ),
            'menu_name'                  => __( 'Servizi', 'caniincasa' ),
            'all_items'                  => __( 'Tutti i Servizi', 'caniincasa' ),
            'new_item_name'              => __( 'Nuovo Servizio', 'caniincasa' ),
            'add_new_item'               => __( 'Aggiungi Nuovo Servizio', 'caniincasa' ),
            'edit_item'                  => __( 'Modifica Servizio', 'caniincasa' ),
            'update_item'                => __( 'Aggiorna Servizio', 'caniincasa' ),
            'view_item'                  => __( 'Visualizza Servizio', 'caniincasa' ),
            'search_items'               => __( 'Cerca Servizi', 'caniincasa' ),
            'not_found'                  => __( 'Nessun servizio trovato', 'caniincasa' ),
        ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array(
            'slug'         => 'servizio-veterinario',
            'with_front'   => true,
            'hierarchical' => false,
        ),
    ) );

    /**
     * 5. Tipo Cucciolata
     * Taxonomy for litter types (NEW)
     * Used on: cucciolate, annunci_cucciolate
     * Types: Cucciolata Allevamento, Cucciolata Privato, Adozione Cuccioli, Adozione Adulti
     */
    register_taxonomy( 'tipo_cucciolata', array( 'cucciolate', 'annunci_cucciolate' ), array(
        'labels' => array(
            'name'                       => _x( 'Tipologie Cucciolata', 'Taxonomy general name', 'caniincasa' ),
            'singular_name'              => _x( 'Tipologia Cucciolata', 'Taxonomy singular name', 'caniincasa' ),
            'menu_name'                  => __( 'Tipologie', 'caniincasa' ),
            'all_items'                  => __( 'Tutte le Tipologie', 'caniincasa' ),
            'new_item_name'              => __( 'Nuova Tipologia', 'caniincasa' ),
            'add_new_item'               => __( 'Aggiungi Nuova Tipologia', 'caniincasa' ),
            'edit_item'                  => __( 'Modifica Tipologia', 'caniincasa' ),
            'update_item'                => __( 'Aggiorna Tipologia', 'caniincasa' ),
            'view_item'                  => __( 'Visualizza Tipologia', 'caniincasa' ),
            'search_items'               => __( 'Cerca Tipologie', 'caniincasa' ),
            'not_found'                  => __( 'Nessuna tipologia trovata', 'caniincasa' ),
        ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => false,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array(
            'slug'         => 'tipo-cucciolata',
            'with_front'   => true,
            'hierarchical' => false,
        ),
    ) );

    /**
     * 6. Province (optional but useful)
     * Taxonomy for Italian provinces
     * Used on: allevamenti, struttureveterinarie, canili, centri_cinofili, pensioni_per_cani
     */
    register_taxonomy( 'provincia', array( 'allevamenti', 'struttureveterinarie', 'canili', 'centri_cinofili', 'pensioni_per_cani' ), array(
        'labels' => array(
            'name'                       => _x( 'Province', 'Taxonomy general name', 'caniincasa' ),
            'singular_name'              => _x( 'Provincia', 'Taxonomy singular name', 'caniincasa' ),
            'menu_name'                  => __( 'Province', 'caniincasa' ),
            'all_items'                  => __( 'Tutte le Province', 'caniincasa' ),
            'new_item_name'              => __( 'Nuova Provincia', 'caniincasa' ),
            'add_new_item'               => __( 'Aggiungi Nuova Provincia', 'caniincasa' ),
            'edit_item'                  => __( 'Modifica Provincia', 'caniincasa' ),
            'update_item'                => __( 'Aggiorna Provincia', 'caniincasa' ),
            'view_item'                  => __( 'Visualizza Provincia', 'caniincasa' ),
            'search_items'               => __( 'Cerca Province', 'caniincasa' ),
            'not_found'                  => __( 'Nessuna provincia trovata', 'caniincasa' ),
        ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array(
            'slug'         => 'provincia',
            'with_front'   => true,
            'hierarchical' => false,
        ),
    ) );
}
add_action( 'init', 'caniincasa_register_taxonomies' );

/**
 * Customize taxonomy term columns
 */

// Add custom columns for razze_allevamenti taxonomy
function caniincasa_razze_allevamenti_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['name'] = __( 'Nome', 'caniincasa' );
    $new_columns['description'] = __( 'Descrizione', 'caniincasa' );
    $new_columns['posts'] = $columns['posts'];
    return $new_columns;
}
add_filter( 'manage_edit-razze_allevamenti_columns', 'caniincasa_razze_allevamenti_columns' );

/**
 * Populate default terms for tipo_cucciolata taxonomy
 * Creates the 4 main types if they don't exist
 */
function caniincasa_populate_tipo_cucciolata_terms() {
    // Only run once
    if ( get_option( 'caniincasa_tipo_cucciolata_populated' ) ) {
        return;
    }

    $terms = array(
        array(
            'name' => 'Cucciolata Allevamento',
            'slug' => 'cucciolata-allevamento',
            'description' => 'Cuccioli provenienti da allevamento riconosciuto con pedigree',
        ),
        array(
            'name' => 'Cucciolata Privato',
            'slug' => 'cucciolata-privato',
            'description' => 'Cuccioli provenienti da privati, senza pedigree',
        ),
        array(
            'name' => 'Adozione Cuccioli',
            'slug' => 'adozione-cuccioli',
            'description' => 'Cuccioli in adozione da canili o associazioni',
        ),
        array(
            'name' => 'Adozione Adulti',
            'slug' => 'adozione-adulti',
            'description' => 'Cani adulti in adozione da canili o associazioni',
        ),
    );

    foreach ( $terms as $term_data ) {
        // Check if term already exists
        if ( ! term_exists( $term_data['slug'], 'tipo_cucciolata' ) ) {
            wp_insert_term(
                $term_data['name'],
                'tipo_cucciolata',
                array(
                    'slug' => $term_data['slug'],
                    'description' => $term_data['description'],
                )
            );
        }
    }

    // Mark as populated
    update_option( 'caniincasa_tipo_cucciolata_populated', true );
}
add_action( 'init', 'caniincasa_populate_tipo_cucciolata_terms', 20 );
