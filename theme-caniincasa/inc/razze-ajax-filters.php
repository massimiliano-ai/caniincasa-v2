<?php
/**
 * AJAX Handlers for Razze Filters
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Register AJAX handlers
add_action( 'wp_ajax_filter_razze', 'caniincasa_filter_razze' );
add_action( 'wp_ajax_nopriv_filter_razze', 'caniincasa_filter_razze' );

/**
 * AJAX Handler per filtrare le razze
 */
function caniincasa_filter_razze() {
    // HOTFIX UNIVERSALE: Disabilita nonce check su domini specifici
    // Aggiungi qui i domini dove vuoi disabilitare il check (sviluppo/staging)
    $allowed_hosts = array(
        'cani-in-casa.local',     // Local by Flywheel
        'localhost',              // Localhost generico
        'caneincasa.it',          // Sito live (TEMPORANEO - RIMUOVERE!)
        'www.caneincasa.it',      // Sito live con www (TEMPORANEO - RIMUOVERE!)
    );

    $current_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

    if ( !defined('RAZZE_SKIP_NONCE_CHECK') && in_array($current_host, $allowed_hosts) ) {
        define('RAZZE_SKIP_NONCE_CHECK', true);
        error_log('⚠️ RAZZE: Definisco RAZZE_SKIP_NONCE_CHECK per host: ' . $current_host);
    }

    // Debug: log della richiesta
    error_log('RAZZE FILTER: Richiesta ricevuta da: ' . $current_host);
    error_log('POST data: ' . print_r($_POST, true));
    error_log('RAZZE_SKIP_NONCE_CHECK defined? ' . (defined('RAZZE_SKIP_NONCE_CHECK') ? 'YES' : 'NO'));
    error_log('RAZZE_SKIP_NONCE_CHECK value: ' . (defined('RAZZE_SKIP_NONCE_CHECK') ? (RAZZE_SKIP_NONCE_CHECK ? 'TRUE' : 'FALSE') : 'N/A'));

    // Verifica nonce in modo più sicuro
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    error_log('Nonce ricevuto: ' . $nonce);

    // TEMPORANEO: Disabilita completamente il nonce check per test
    // RIMUOVERE QUESTA RIGA in produzione!!!
    $skip_nonce_for_test = true;

    if (!$skip_nonce_for_test && (!defined('RAZZE_SKIP_NONCE_CHECK') || !RAZZE_SKIP_NONCE_CHECK)) {
        $nonce_valid = wp_verify_nonce($nonce, 'razze_filters_nonce');
        error_log('RAZZE FILTER: Nonce valid? ' . ($nonce_valid ? 'YES' : 'NO'));

        if (!$nonce_valid) {
            error_log('RAZZE FILTER: Nonce verification FAILED');
            error_log('Expected nonce action: razze_filters_nonce');
            error_log('Current user: ' . get_current_user_id());
            error_log('Is user logged in: ' . (is_user_logged_in() ? 'yes' : 'no'));

            wp_send_json_error(array(
                'message' => 'Verifica di sicurezza fallita. Ricarica la pagina.',
                'debug' => array(
                    'nonce_received' => !empty($nonce),
                    'nonce_value' => substr($nonce, 0, 10) . '...',
                    'logged_in' => is_user_logged_in(),
                )
            ), 403);
            return;
        }
    } else {
        error_log('RAZZE FILTER: ⚠️ NONCE CHECK SKIPPED (TEST MODE - RIMUOVERE IN PRODUZIONE!)');
    }

    error_log('RAZZE FILTER: Nonce OK, procedo con il filtro');

    // Parametri filtri
    $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
    $sizes = isset( $_POST['sizes'] ) ? array_map( 'sanitize_text_field', $_POST['sizes'] ) : array();
    $energy = isset( $_POST['energy'] ) ? floatval( $_POST['energy'] ) : 0;
    $apartment = isset( $_POST['apartment'] ) ? floatval( $_POST['apartment'] ) : 0;
    $affection = isset( $_POST['affection'] ) ? floatval( $_POST['affection'] ) : 0;
    $strangers = isset( $_POST['strangers'] ) ? floatval( $_POST['strangers'] ) : 0;
    $vocality = isset( $_POST['vocality'] ) ? floatval( $_POST['vocality'] ) : 0;
    $kids = isset( $_POST['kids'] ) ? floatval( $_POST['kids'] ) : 0;
    $experience = isset( $_POST['experience'] ) ? floatval( $_POST['experience'] ) : 0;
    $sort_by = isset( $_POST['sort_by'] ) ? sanitize_text_field( $_POST['sort_by'] ) : 'name-asc';
    $paged = isset( $_POST['paged'] ) ? intval( $_POST['paged'] ) : 1;
    $per_page = 24;

    // Query args base
    $args = array(
        'post_type' => 'razze_di_cani',
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $paged,
    );

    // Filtro ricerca testuale
    if ( !empty( $search ) ) {
        $args['s'] = $search;
    }

    // Meta query per caratteristiche
    $meta_query = array( 'relation' => 'AND' );

    // Filtro energia
    if ( $energy > 0 ) {
        $meta_query[] = array(
            'key' => 'energia_e_livelli_di_attivita',
            'value' => $energy,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro appartamento
    if ( $apartment > 0 ) {
        $meta_query[] = array(
            'key' => 'adattabilita_appartamento',
            'value' => $apartment,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro affettuosità
    if ( $affection > 0 ) {
        $meta_query[] = array(
            'key' => 'affettuosita',
            'value' => $affection,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro tolleranza verso estranei
    if ( $strangers > 0 ) {
        $meta_query[] = array(
            'key' => 'tolleranza_estranei',
            'value' => $strangers,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro vocalità
    if ( $vocality > 0 ) {
        $meta_query[] = array(
            'key' => 'vocalita_e_predisposizione_ad_abbaiare',
            'value' => $vocality,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro bambini
    if ( $kids > 0 ) {
        $meta_query[] = array(
            'key' => 'compatibilita_con_i_bambini',
            'value' => $kids,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro esperienza
    if ( $experience > 0 ) {
        $meta_query[] = array(
            'key' => 'livello_esperienza_richiesto',
            'value' => $experience,
            'compare' => '<=',
            'type' => 'DECIMAL',
        );
    }

    if ( count( $meta_query ) > 1 ) {
        $args['meta_query'] = $meta_query;
    }

    // Ordinamento
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
            $args['meta_key'] = 'views_count'; // Assumendo che tracci le visualizzazioni
            $args['order'] = 'DESC';
            break;
    }

    // Esegui query
    error_log('RAZZE FILTER: Eseguo query con args: ' . print_r($args, true));
    $query = new WP_Query( $args );
    error_log('RAZZE FILTER: Query found_posts: ' . $query->found_posts);

    // Post-filtraggio per dimensione (se non possiamo farlo via ACF direttamente)
    $results = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            // Filtro dimensione (se specificato)
            if ( !empty( $sizes ) ) {
                $breed_size = caniincasa_get_breed_size( $post_id );
                if ( !in_array( $breed_size, $sizes ) ) {
                    continue; // Salta questa razza
                }
            }

            // Costruisci dati razza
            $results[] = caniincasa_get_breed_card_data( $post_id );
        }
    }

    wp_reset_postdata();

    // Risposta JSON
    $response = array(
        'breeds' => $results,
        'total' => $query->found_posts,
        'found_posts' => $query->found_posts,
        'max_pages' => $query->max_num_pages,
        'current_page' => $paged,
        'has_more' => ( $paged < $query->max_num_pages ),
    );

    error_log('RAZZE FILTER: Invio risposta con ' . count($results) . ' razze');
    wp_send_json_success( $response );
}

/**
 * Determina la dimensione della razza in base al peso/taglia
 */
function caniincasa_get_breed_size( $post_id ) {
    // Qui puoi usare logica basata su campi ACF
    // Per ora uso un esempio semplificato
    $aspetto = get_field( 'aspetto_fisico', $post_id );

    if ( empty( $aspetto ) ) {
        return 'media'; // Default
    }

    // Cerca indicazioni di peso nel testo
    $aspetto_lower = strtolower( $aspetto );

    if ( strpos( $aspetto_lower, '< 10' ) !== false || strpos( $aspetto_lower, 'fino a 10' ) !== false ) {
        return 'piccola';
    } elseif ( strpos( $aspetto_lower, '10-25' ) !== false || strpos( $aspetto_lower, '25 kg' ) !== false ) {
        return 'media';
    } elseif ( strpos( $aspetto_lower, '25-45' ) !== false || strpos( $aspetto_lower, '45 kg' ) !== false ) {
        return 'grande';
    } elseif ( strpos( $aspetto_lower, '> 45' ) !== false || strpos( $aspetto_lower, 'oltre 45' ) !== false ) {
        return 'gigante';
    }

    return 'media';
}

/**
 * Ottieni dati formattati per la card della razza
 */
function caniincasa_get_breed_card_data( $post_id ) {
    $thumbnail_id = get_post_thumbnail_id( $post_id );
    $image_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : '';

    return array(
        'id' => $post_id,
        'title' => get_the_title( $post_id ),
        'link' => get_permalink( $post_id ),
        'excerpt' => get_the_excerpt( $post_id ),
        'image' => $image_url,
        'energy' => get_field( 'energia_e_livelli_di_attivita', $post_id ) ?: 0,
        'apartment' => get_field( 'adattabilita_appartamento', $post_id ) ?: 0,
        'kids' => get_field( 'compatibilita_con_i_bambini', $post_id ) ?: 0,
        'temperament' => get_field( 'temperamento_breve', $post_id ) ?: '',
        'origin' => get_field( 'nazione_origine', $post_id ) ?: '',
    );
}
