<?php
/**
 * AJAX Handlers
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * AJAX Handler: Filter Razze
 */
function caniincasa_ajax_filter_razze() {
    // Verify nonce
    check_ajax_referer( 'razze_filters_nonce', 'nonce' );

    // Get filter parameters
    $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
    $sizes = isset( $_POST['sizes'] ) && is_array( $_POST['sizes'] ) ? array_map( 'sanitize_text_field', $_POST['sizes'] ) : array();
    $energy = isset( $_POST['energy'] ) ? floatval( $_POST['energy'] ) : 0;
    $apartment = isset( $_POST['apartment'] ) ? floatval( $_POST['apartment'] ) : 0;
    $affection = isset( $_POST['affection'] ) ? floatval( $_POST['affection'] ) : 0;
    $strangers = isset( $_POST['strangers'] ) ? floatval( $_POST['strangers'] ) : 0;
    $vocality = isset( $_POST['vocality'] ) ? floatval( $_POST['vocality'] ) : 0;
    $kids = isset( $_POST['kids'] ) ? floatval( $_POST['kids'] ) : 0;
    $experience = isset( $_POST['experience'] ) ? floatval( $_POST['experience'] ) : 5;
    $sort_by = isset( $_POST['sort_by'] ) ? sanitize_text_field( $_POST['sort_by'] ) : 'name-asc';
    $paged = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;

    // Build query args
    $args = array(
        'post_type'      => 'razze_di_cani',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'post_status'    => 'publish',
    );

    // Search by name
    if ( ! empty( $search ) ) {
        $args['s'] = $search;
    }

    // Add meta query for custom fields
    $meta_query = array( 'relation' => 'AND' );

    // Livello energia
    if ( $energy > 0 ) {
        $meta_query[] = array(
            'key'     => 'livello_di_energia',
            'value'   => $energy,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    // Adattabilità appartamento
    if ( $apartment > 0 ) {
        $meta_query[] = array(
            'key'     => 'adattabilita_appartamento',
            'value'   => $apartment,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    // Affettuosità
    if ( $affection > 0 ) {
        $meta_query[] = array(
            'key'     => 'affettuosita',
            'value'   => $affection,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    // Tolleranza verso estranei
    if ( $strangers > 0 ) {
        $meta_query[] = array(
            'key'     => 'tolleranza_estranei',
            'value'   => $strangers,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    // Vocalità
    if ( $vocality > 0 ) {
        $meta_query[] = array(
            'key'     => 'vocalita',
            'value'   => $vocality,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    // Compatibilità con bambini
    if ( $kids > 0 ) {
        $meta_query[] = array(
            'key'     => 'compatibilita_bambini',
            'value'   => $kids,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    // Esperienza richiesta (inverted logic - lower is better for beginners)
    if ( $experience < 5 ) {
        $meta_query[] = array(
            'key'     => 'esperienza_richiesta',
            'value'   => $experience,
            'compare' => '<=',
            'type'    => 'NUMERIC',
        );
    }

    if ( count( $meta_query ) > 1 ) {
        $args['meta_query'] = $meta_query;
    }

    // Filter by size (taxonomy or meta field)
    if ( ! empty( $sizes ) ) {
        // Try taxonomy first
        $tax_query = array(
            'taxonomy' => 'dimensione',
            'field'    => 'slug',
            'terms'    => $sizes,
        );
        $args['tax_query'] = array( $tax_query );
    }

    // Sorting
    switch ( $sort_by ) {
        case 'name-asc':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        case 'name-desc':
            $args['orderby'] = 'title';
            $args['order'] = 'DESC';
            break;
        case 'popular':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'view_count';
            $args['order'] = 'DESC';
            break;
        default:
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
    }

    // Execute query
    $query = new WP_Query( $args );

    // Prepare breeds data
    $breeds = array();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $breeds[] = array(
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'link'      => get_permalink(),
                'image'     => get_the_post_thumbnail_url( get_the_ID(), 'medium' ),
                'energy'    => get_post_meta( get_the_ID(), 'livello_di_energia', true ),
                'apartment' => get_post_meta( get_the_ID(), 'adattabilita_appartamento', true ),
            );
        }
    }
    wp_reset_postdata();

    // Prepare response
    $response = array(
        'breeds'    => $breeds,
        'total'     => $query->found_posts,
        'has_more'  => $query->max_num_pages > $paged,
        'max_pages' => $query->max_num_pages,
    );

    wp_send_json_success( $response );
}
add_action( 'wp_ajax_filter_razze', 'caniincasa_ajax_filter_razze' );
add_action( 'wp_ajax_nopriv_filter_razze', 'caniincasa_ajax_filter_razze' );

/**
 * AJAX Handler: Submit Review
 */
function caniincasa_ajax_submit_review() {
    // Verify nonce
    check_ajax_referer( 'caniincasa-nonce', 'nonce' );

    // Check if user is logged in
    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array(
            'message' => __( 'Devi essere autenticato per lasciare una recensione.', 'caniincasa' ),
        ) );
    }

    // Get data
    $post_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;
    $rating = isset( $_POST['rating'] ) ? absint( $_POST['rating'] ) : 0;
    $comment = isset( $_POST['comment'] ) ? sanitize_textarea_field( $_POST['comment'] ) : '';

    // Validate
    if ( ! $post_id || $rating < 1 || $rating > 5 ) {
        wp_send_json_error( array(
            'message' => __( 'Dati non validi.', 'caniincasa' ),
        ) );
    }

    // Create comment (review)
    $comment_data = array(
        'comment_post_ID'      => $post_id,
        'comment_author'       => wp_get_current_user()->display_name,
        'comment_author_email' => wp_get_current_user()->user_email,
        'comment_content'      => $comment,
        'comment_type'         => 'review',
        'comment_approved'     => 0, // Requires moderation
        'user_id'              => get_current_user_id(),
    );

    $comment_id = wp_insert_comment( $comment_data );

    if ( $comment_id ) {
        // Save rating as comment meta
        add_comment_meta( $comment_id, 'rating', $rating );

        wp_send_json_success( array(
            'message' => __( 'Grazie! La tua recensione è stata inviata e sarà pubblicata dopo la moderazione.', 'caniincasa' ),
        ) );
    } else {
        wp_send_json_error( array(
            'message' => __( 'Errore durante l\'invio della recensione.', 'caniincasa' ),
        ) );
    }
}
add_action( 'wp_ajax_submit_review', 'caniincasa_ajax_submit_review' );

/**
 * AJAX Handler: Load More Posts
 */
function caniincasa_ajax_load_more() {
    // Verify nonce
    check_ajax_referer( 'caniincasa-nonce', 'nonce' );

    // Get parameters
    $post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : 'post';
    $paged = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

    // Build query
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 12,
        'paged'          => $paged,
    );

    $query = new WP_Query( $args );

    $response = array(
        'success' => true,
        'html'    => '',
        'has_more' => $query->max_num_pages > $paged,
    );

    if ( $query->have_posts() ) {
        ob_start();
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', $post_type );
        }
        $response['html'] = ob_get_clean();
    }

    wp_reset_postdata();

    wp_send_json( $response );
}
add_action( 'wp_ajax_load_more', 'caniincasa_ajax_load_more' );
add_action( 'wp_ajax_nopriv_load_more', 'caniincasa_ajax_load_more' );

/**
 * AJAX Handler: Submit Struttura
 */
function caniincasa_ajax_submit_struttura() {
    // Verify nonce
    check_ajax_referer( 'caniincasa_submit_struttura', 'nonce' );

    // Check if user is logged in
    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array(
            'message' => __( 'Devi essere autenticato per aggiungere una struttura.', 'caniincasa' ),
        ) );
    }

    // Get data
    $tipo_struttura = isset( $_POST['tipo_struttura'] ) ? sanitize_text_field( $_POST['tipo_struttura'] ) : '';
    $titolo = isset( $_POST['titolo_struttura'] ) ? sanitize_text_field( $_POST['titolo_struttura'] ) : '';
    $descrizione = isset( $_POST['descrizione_struttura'] ) ? sanitize_textarea_field( $_POST['descrizione_struttura'] ) : '';
    $indirizzo = isset( $_POST['indirizzo'] ) ? sanitize_text_field( $_POST['indirizzo'] ) : '';
    $comune = isset( $_POST['comune'] ) ? sanitize_text_field( $_POST['comune'] ) : '';
    $provincia = isset( $_POST['provincia_struttura'] ) ? absint( $_POST['provincia_struttura'] ) : 0;
    $cap = isset( $_POST['cap'] ) ? sanitize_text_field( $_POST['cap'] ) : '';
    $telefono = isset( $_POST['telefono_struttura'] ) ? sanitize_text_field( $_POST['telefono_struttura'] ) : '';
    $email = isset( $_POST['email_struttura'] ) ? sanitize_email( $_POST['email_struttura'] ) : '';
    $sito_web = isset( $_POST['sito_web'] ) ? esc_url_raw( $_POST['sito_web'] ) : '';

    // Validate required fields
    if ( empty( $tipo_struttura ) || empty( $titolo ) || empty( $indirizzo ) || empty( $comune ) || empty( $provincia ) ) {
        wp_send_json_error( array(
            'message' => __( 'Compila tutti i campi obbligatori.', 'caniincasa' ),
        ) );
    }

    // Validate post type
    $allowed_types = array( 'allevamenti', 'struttureveterinarie', 'centri_cinofili', 'pensioni_per_cani', 'canili' );
    if ( ! in_array( $tipo_struttura, $allowed_types ) ) {
        wp_send_json_error( array(
            'message' => __( 'Tipo di struttura non valido.', 'caniincasa' ),
        ) );
    }

    // Create post
    $post_data = array(
        'post_title'   => $titolo,
        'post_content' => $descrizione,
        'post_type'    => $tipo_struttura,
        'post_status'  => 'pending', // Pending moderation
        'post_author'  => get_current_user_id(),
    );

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( array(
            'message' => __( 'Errore durante la creazione della struttura.', 'caniincasa' ),
        ) );
    }

    // Save meta fields - Common fields
    update_post_meta( $post_id, 'indirizzo', $indirizzo );
    update_post_meta( $post_id, 'comune', $comune );
    update_post_meta( $post_id, 'cap', $cap );
    update_post_meta( $post_id, 'telefono', $telefono );
    update_post_meta( $post_id, 'email', $email );
    update_post_meta( $post_id, 'sito_web', $sito_web );

    // Assign provincia taxonomy
    if ( $provincia ) {
        wp_set_post_terms( $post_id, array( $provincia ), 'provincia' );
    }

    // Save specific fields based on structure type
    if ( $tipo_struttura === 'allevamenti' ) {
        $affisso = isset( $_POST['affisso'] ) ? sanitize_text_field( $_POST['affisso'] ) : '';
        $proprietario = isset( $_POST['proprietario'] ) ? sanitize_text_field( $_POST['proprietario'] ) : '';

        update_post_meta( $post_id, 'desaffisso', $affisso );
        update_post_meta( $post_id, 'proprietario', $proprietario );
        update_post_meta( $post_id, 'localita', $comune );
        update_post_meta( $post_id, 'provincia_', $provincia );

    } elseif ( $tipo_struttura === 'struttureveterinarie' ) {
        $tipologia = isset( $_POST['tipologia'] ) ? sanitize_text_field( $_POST['tipologia'] ) : '';
        $direttore_sanitario = isset( $_POST['direttore_sanitario'] ) ? sanitize_text_field( $_POST['direttore_sanitario'] ) : '';
        $pronto_soccorso = isset( $_POST['pronto_soccorso_h24'] ) ? sanitize_text_field( $_POST['pronto_soccorso_h24'] ) : '0';
        $reperibilita = isset( $_POST['reperibilita_h24'] ) ? sanitize_text_field( $_POST['reperibilita_h24'] ) : '0';
        $orari = isset( $_POST['orari_apertura'] ) ? sanitize_textarea_field( $_POST['orari_apertura'] ) : '';

        update_post_meta( $post_id, 'tipologia', $tipologia );
        update_post_meta( $post_id, 'direttore_sanitario', $direttore_sanitario );
        update_post_meta( $post_id, 'pronto_soccorso_h24', $pronto_soccorso );
        update_post_meta( $post_id, 'reperibilita_h24', $reperibilita );
        update_post_meta( $post_id, 'orari_di_apertura', $orari );
        update_post_meta( $post_id, 'localita', $comune );
        update_post_meta( $post_id, 'provincia', $provincia );

    } elseif ( $tipo_struttura === 'centri_cinofili' ) {
        $servizi = isset( $_POST['servizi_offerti'] ) ? sanitize_textarea_field( $_POST['servizi_offerti'] ) : '';

        update_post_meta( $post_id, 'servizi_offerti', $servizi );
        update_post_meta( $post_id, 'comune', $comune );
        update_post_meta( $post_id, 'provincia', $provincia );

    } elseif ( $tipo_struttura === 'pensioni_per_cani' ) {
        $servizi = isset( $_POST['servizi_pensione'] ) ? sanitize_textarea_field( $_POST['servizi_pensione'] ) : '';

        update_post_meta( $post_id, 'servizi_pensione', $servizi );
        update_post_meta( $post_id, 'comune', $comune );
        update_post_meta( $post_id, 'provincia', $provincia );

    } elseif ( $tipo_struttura === 'canili' ) {
        $riferimento = isset( $_POST['riferimento'] ) ? sanitize_text_field( $_POST['riferimento'] ) : '';

        update_post_meta( $post_id, 'riferimento', $riferimento );
        update_post_meta( $post_id, 'comune', $comune );
        update_post_meta( $post_id, 'provincia', $provincia );
    }

    // Send notification email to admin (optional)
    $admin_email = get_option( 'admin_email' );
    $subject = sprintf( __( 'Nuova struttura in attesa di approvazione: %s', 'caniincasa' ), $titolo );
    $message = sprintf(
        __( "Una nuova struttura è stata inviata e richiede approvazione.\n\nTipo: %s\nNome: %s\nAutore: %s\n\nVisualizza: %s", 'caniincasa' ),
        $tipo_struttura,
        $titolo,
        wp_get_current_user()->display_name,
        admin_url( 'post.php?post=' . $post_id . '&action=edit' )
    );

    wp_mail( $admin_email, $subject, $message );

    wp_send_json_success( array(
        'message' => __( 'Struttura inviata con successo! Sarà pubblicata dopo la moderazione.', 'caniincasa' ),
        'post_id' => $post_id,
    ) );
}
add_action( 'wp_ajax_caniincasa_submit_struttura', 'caniincasa_ajax_submit_struttura' );
