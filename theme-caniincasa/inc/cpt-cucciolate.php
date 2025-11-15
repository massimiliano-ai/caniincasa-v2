<?php
/**
 * Custom Post Type: Cucciolate
 * Gestione annunci di cucciolate
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Cucciolate Custom Post Type
 */
function caniincasa_register_cpt_cucciolate() {
    $labels = array(
        'name'                  => _x( 'Cucciolate', 'Post Type General Name', 'caniincasa' ),
        'singular_name'         => _x( 'Cucciolata', 'Post Type Singular Name', 'caniincasa' ),
        'menu_name'             => __( 'Cucciolate', 'caniincasa' ),
        'name_admin_bar'        => __( 'Cucciolata', 'caniincasa' ),
        'archives'              => __( 'Archivio Cucciolate', 'caniincasa' ),
        'attributes'            => __( 'Attributi Cucciolata', 'caniincasa' ),
        'parent_item_colon'     => __( 'Cucciolata Genitore:', 'caniincasa' ),
        'all_items'             => __( 'Tutte le Cucciolate', 'caniincasa' ),
        'add_new_item'          => __( 'Aggiungi Nuova Cucciolata', 'caniincasa' ),
        'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
        'new_item'              => __( 'Nuova Cucciolata', 'caniincasa' ),
        'edit_item'             => __( 'Modifica Cucciolata', 'caniincasa' ),
        'update_item'           => __( 'Aggiorna Cucciolata', 'caniincasa' ),
        'view_item'             => __( 'Visualizza Cucciolata', 'caniincasa' ),
        'view_items'            => __( 'Visualizza Cucciolate', 'caniincasa' ),
        'search_items'          => __( 'Cerca Cucciolata', 'caniincasa' ),
        'not_found'             => __( 'Nessuna cucciolata trovata', 'caniincasa' ),
        'not_found_in_trash'    => __( 'Nessuna cucciolata nel cestino', 'caniincasa' ),
        'featured_image'        => __( 'Immagine in evidenza', 'caniincasa' ),
        'set_featured_image'    => __( 'Imposta immagine in evidenza', 'caniincasa' ),
        'remove_featured_image' => __( 'Rimuovi immagine in evidenza', 'caniincasa' ),
        'use_featured_image'    => __( 'Usa come immagine in evidenza', 'caniincasa' ),
        'insert_into_item'      => __( 'Inserisci nella cucciolata', 'caniincasa' ),
        'uploaded_to_this_item' => __( 'Caricato in questa cucciolata', 'caniincasa' ),
        'items_list'            => __( 'Lista cucciolate', 'caniincasa' ),
        'items_list_navigation' => __( 'Navigazione lista cucciolate', 'caniincasa' ),
        'filter_items_list'     => __( 'Filtra lista cucciolate', 'caniincasa' ),
    );

    $args = array(
        'label'                 => __( 'Cucciolata', 'caniincasa' ),
        'description'           => __( 'Annunci di cucciolate disponibili', 'caniincasa' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
        'taxonomies'            => array( 'provincia' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-pets',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'cucciolate',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'       => 'cucciolate',
            'with_front' => false,
        ),
    );

    register_post_type( 'cucciolate', $args );
}
add_action( 'init', 'caniincasa_register_cpt_cucciolate', 0 );

/**
 * Add custom capabilities for cucciolate to admin
 */
function caniincasa_add_cucciolate_capabilities() {
    $admin = get_role( 'administrator' );

    if ( $admin ) {
        $admin->add_cap( 'approve_cucciolate' );
        $admin->add_cap( 'approve_annunci' );
        $admin->add_cap( 'moderate_content' );
    }
}
add_action( 'admin_init', 'caniincasa_add_cucciolate_capabilities' );

/**
 * Add custom columns to cucciolate admin list
 */
function caniincasa_cucciolate_custom_columns( $columns ) {
    $new_columns = array();

    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;

        if ( $key === 'title' ) {
            $new_columns['razza'] = __( 'Razza', 'caniincasa' );
            $new_columns['data_nascita'] = __( 'Data Nascita', 'caniincasa' );
            $new_columns['provincia'] = __( 'Provincia', 'caniincasa' );
            $new_columns['status'] = __( 'Stato', 'caniincasa' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_cucciolate_posts_columns', 'caniincasa_cucciolate_custom_columns' );

/**
 * Populate custom columns
 */
function caniincasa_cucciolate_custom_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'razza':
            $razza_id = get_field( 'razza', $post_id );
            if ( $razza_id ) {
                $razza = get_post( $razza_id );
                if ( $razza ) {
                    echo esc_html( $razza->post_title );
                }
            }
            break;

        case 'data_nascita':
            $data = get_field( 'data_nascita', $post_id );
            if ( $data ) {
                echo esc_html( date( 'd/m/Y', strtotime( $data ) ) );
            }
            break;

        case 'provincia':
            $province = wp_get_post_terms( $post_id, 'provincia' );
            if ( ! empty( $province ) && ! is_wp_error( $province ) ) {
                echo esc_html( $province[0]->name );
            }
            break;

        case 'status':
            $status = get_post_status( $post_id );
            $status_labels = array(
                'publish' => '<span style="color: green;">✓ Pubblicato</span>',
                'pending' => '<span style="color: orange;">⏳ In Revisione</span>',
                'draft'   => '<span style="color: gray;">📝 Bozza</span>',
            );
            echo isset( $status_labels[$status] ) ? $status_labels[$status] : $status;
            break;
    }
}
add_action( 'manage_cucciolate_posts_custom_column', 'caniincasa_cucciolate_custom_column_content', 10, 2 );

/**
 * Make custom columns sortable
 */
function caniincasa_cucciolate_sortable_columns( $columns ) {
    $columns['data_nascita'] = 'data_nascita';
    $columns['provincia'] = 'provincia';
    return $columns;
}
add_filter( 'manage_edit-cucciolate_sortable_columns', 'caniincasa_cucciolate_sortable_columns' );

/**
 * Add meta box for pending review count (moderators)
 */
function caniincasa_add_pending_cucciolate_meta_box() {
    if ( current_user_can( 'approve_cucciolate' ) || current_user_can( 'moderate_content' ) ) {
        add_meta_box(
            'caniincasa_pending_cucciolate',
            __( 'Cucciolate in Attesa', 'caniincasa' ),
            'caniincasa_render_pending_cucciolate_meta_box',
            'dashboard',
            'side',
            'high'
        );
    }
}
add_action( 'wp_dashboard_setup', 'caniincasa_add_pending_cucciolate_meta_box' );

/**
 * Render pending cucciolate meta box
 */
function caniincasa_render_pending_cucciolate_meta_box() {
    $pending_count = wp_count_posts( 'cucciolate' )->pending;

    echo '<div style="padding: 10px;">';
    if ( $pending_count > 0 ) {
        echo '<p style="font-size: 16px; margin: 0 0 10px 0;">';
        echo '<strong style="color: #e65229; font-size: 24px;">' . $pending_count . '</strong> ';
        echo _n( 'cucciolata in attesa di approvazione', 'cucciolate in attesa di approvazione', $pending_count, 'caniincasa' );
        echo '</p>';
        echo '<a href="' . admin_url( 'edit.php?post_type=cucciolate&post_status=pending' ) . '" class="button button-primary">';
        echo __( 'Modera Ora', 'caniincasa' );
        echo '</a>';
    } else {
        echo '<p>' . __( 'Nessuna cucciolata in attesa di moderazione.', 'caniincasa' ) . '</p>';
        echo '<p style="color: green;">✓ Tutto approvato!</p>';
    }
    echo '</div>';
}

/**
 * Send notification when status changes
 */
function caniincasa_cucciolata_status_transition( $new_status, $old_status, $post ) {
    if ( $post->post_type !== 'cucciolate' ) {
        return;
    }

    // Only send email if transitioning from pending
    if ( $old_status !== 'pending' ) {
        return;
    }

    $author = get_userdata( $post->post_author );

    if ( $new_status === 'publish' ) {
        // Approved
        wp_mail(
            $author->user_email,
            'Cucciolata approvata - ' . get_bloginfo( 'name' ),
            "Ciao {$author->display_name},\n\n" .
            "La tua cucciolata '{$post->post_title}' è stata approvata ed è ora visibile sul sito.\n\n" .
            "Visualizza: " . get_permalink( $post->ID ) . "\n\n" .
            "Grazie per aver contribuito a " . get_bloginfo( 'name' ) . "!"
        );
    } elseif ( $new_status === 'trash' ) {
        // Rejected
        wp_mail(
            $author->user_email,
            'Cucciolata non approvata - ' . get_bloginfo( 'name' ),
            "Ciao {$author->display_name},\n\n" .
            "La tua cucciolata '{$post->post_title}' non è stata approvata.\n\n" .
            "Se hai domande, contattaci pure.\n\n" .
            get_bloginfo( 'name' )
        );
    }
}
add_action( 'transition_post_status', 'caniincasa_cucciolata_status_transition', 10, 3 );

/**
 * Flush rewrite rules on theme activation
 */
function caniincasa_flush_cucciolate_rewrite_rules() {
    caniincasa_register_cpt_cucciolate();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'caniincasa_flush_cucciolate_rewrite_rules' );
