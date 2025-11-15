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
    check_ajax_referer( 'caniincasa-nonce', 'nonce' );

    // Get filter parameters
    $taglia = isset( $_POST['taglia'] ) ? sanitize_text_field( $_POST['taglia'] ) : '';
    $energia = isset( $_POST['energia'] ) ? absint( $_POST['energia'] ) : 0;
    $paese = isset( $_POST['paese'] ) ? sanitize_text_field( $_POST['paese'] ) : '';

    // Build query args
    $args = array(
        'post_type'      => 'razze_di_cani',
        'posts_per_page' => 12,
        'paged'          => isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1,
    );

    // Add meta query for custom fields
    $meta_query = array( 'relation' => 'AND' );

    if ( $energia > 0 ) {
        $meta_query[] = array(
            'key'     => 'livello_di_energia',
            'value'   => $energia,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    if ( ! empty( $meta_query ) && count( $meta_query ) > 1 ) {
        $args['meta_query'] = $meta_query;
    }

    // Execute query
    $query = new WP_Query( $args );

    // Prepare response
    $response = array(
        'success' => true,
        'html'    => '',
        'found'   => $query->found_posts,
    );

    if ( $query->have_posts() ) {
        ob_start();
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/content', 'razza-card' );
        }
        $response['html'] = ob_get_clean();
    } else {
        $response['html'] = '<p>' . esc_html__( 'Nessuna razza trovata con i filtri selezionati.', 'caniincasa' ) . '</p>';
    }

    wp_reset_postdata();

    wp_send_json( $response );
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
