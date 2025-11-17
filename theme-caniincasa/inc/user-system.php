<?php
/**
 * User Registration & Management System
 * Sistema di registrazione e gestione utenti
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Create Custom User Roles
 */
function caniincasa_create_user_roles() {
    // Ruolo Utente Registrato (può inserire annunci pending)
    add_role(
        'utente_registrato',
        __( 'Utente Registrato', 'caniincasa' ),
        array(
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'publish_posts' => false,
            'upload_files' => true,
            // Capabilities custom
            'submit_cucciolata' => true,
            'submit_annuncio' => true,
            'view_contacts' => true,
            'suggest_edits' => true,
        )
    );

    // Ruolo Moderatore Annunci
    add_role(
        'moderatore_annunci',
        __( 'Moderatore Annunci', 'caniincasa' ),
        array(
            'read' => true,
            'edit_posts' => true,
            'edit_others_posts' => true,
            'publish_posts' => true,
            'delete_posts' => true,
            'upload_files' => true,
            // Capabilities custom
            'approve_cucciolate' => true,
            'approve_annunci' => true,
            'moderate_content' => true,
        )
    );
}
add_action( 'init', 'caniincasa_create_user_roles' );

/**
 * Registrazione AJAX
 */
add_action( 'wp_ajax_nopriv_caniincasa_register', 'caniincasa_ajax_register' );

function caniincasa_ajax_register() {
    // Verifica nonce
    check_ajax_referer( 'caniincasa_register_nonce', 'nonce' );

    // Sanitize input
    $username = sanitize_user( $_POST['username'] );
    $email = sanitize_email( $_POST['email'] );
    $password = $_POST['password'];
    $nome = sanitize_text_field( $_POST['nome'] );
    $cognome = sanitize_text_field( $_POST['cognome'] );
    $telefono = sanitize_text_field( $_POST['telefono'] );
    $privacy = isset( $_POST['privacy'] ) ? true : false;

    // Validazione
    $errors = array();

    if ( empty( $username ) || strlen( $username ) < 4 ) {
        $errors[] = 'Username deve essere almeno 4 caratteri';
    }

    if ( username_exists( $username ) ) {
        $errors[] = 'Username già esistente';
    }

    if ( ! is_email( $email ) ) {
        $errors[] = 'Email non valida';
    }

    if ( email_exists( $email ) ) {
        $errors[] = 'Email già registrata';
    }

    if ( strlen( $password ) < 8 ) {
        $errors[] = 'Password deve essere almeno 8 caratteri';
    }

    if ( ! $privacy ) {
        $errors[] = 'Devi accettare la privacy policy';
    }

    if ( ! empty( $errors ) ) {
        wp_send_json_error( array(
            'message' => implode( '<br>', $errors )
        ) );
    }

    // Crea utente
    $user_id = wp_create_user( $username, $password, $email );

    if ( is_wp_error( $user_id ) ) {
        wp_send_json_error( array(
            'message' => $user_id->get_error_message()
        ) );
    }

    // Imposta ruolo
    $user = new WP_User( $user_id );
    $user->set_role( 'utente_registrato' );

    // Meta fields
    update_user_meta( $user_id, 'first_name', $nome );
    update_user_meta( $user_id, 'last_name', $cognome );
    update_user_meta( $user_id, 'telefono', $telefono );
    update_user_meta( $user_id, 'data_registrazione', current_time( 'mysql' ) );
    update_user_meta( $user_id, 'privacy_accettata', 1 );

    // Email di benvenuto
    wp_new_user_notification( $user_id, null, 'user' );

    // Auto-login
    wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id );

    // Gestisci redirect personalizzato
    $redirect_to = isset( $_POST['redirect_to'] ) ? esc_url_raw( $_POST['redirect_to'] ) : home_url( '/dashboard/' );

    wp_send_json_success( array(
        'message' => 'Registrazione completata! Benvenuto su CaninCasa.',
        'redirect' => $redirect_to
    ) );
}

/**
 * Login AJAX
 */
add_action( 'wp_ajax_nopriv_caniincasa_login', 'caniincasa_ajax_login' );

function caniincasa_ajax_login() {
    check_ajax_referer( 'caniincasa_login_nonce', 'nonce' );

    $username = sanitize_user( $_POST['username'] );
    $password = $_POST['password'];
    $remember = isset( $_POST['remember'] ) ? true : false;

    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember,
    );

    $user = wp_signon( $creds, false );

    if ( is_wp_error( $user ) ) {
        wp_send_json_error( array(
            'message' => 'Username o password errati'
        ) );
    }

    wp_send_json_success( array(
        'message' => 'Login effettuato!',
        'redirect' => home_url( '/dashboard/' )
    ) );
}

/**
 * Check Username Availability AJAX
 */
add_action( 'wp_ajax_nopriv_caniincasa_check_username', 'caniincasa_ajax_check_username' );

function caniincasa_ajax_check_username() {
    $username = sanitize_user( $_POST['username'] );

    if ( username_exists( $username ) ) {
        wp_send_json_error( array(
            'message' => 'Username già in uso'
        ) );
    }

    wp_send_json_success();
}

/**
 * Check Email Availability AJAX
 */
add_action( 'wp_ajax_nopriv_caniincasa_check_email', 'caniincasa_ajax_check_email' );

function caniincasa_ajax_check_email() {
    $email = sanitize_email( $_POST['email'] );

    if ( email_exists( $email ) ) {
        wp_send_json_error( array(
            'message' => 'Email già registrata'
        ) );
    }

    wp_send_json_success();
}

/**
 * Check if user can view contacts
 */
function caniincasa_can_view_contacts() {
    if ( ! is_user_logged_in() ) {
        return false;
    }

    $user = wp_get_current_user();
    return in_array( 'utente_registrato', $user->roles ) ||
           in_array( 'moderatore_annunci', $user->roles ) ||
           in_array( 'administrator', $user->roles );
}

/**
 * Protect contact fields (show only to registered users)
 */
function caniincasa_get_protected_contact( $field_value, $field_name = 'contatto' ) {
    if ( caniincasa_can_view_contacts() ) {
        return $field_value;
    }

    return '<span class="protected-contact">' .
           '<span class="icon">🔒</span> ' .
           '<a href="' . esc_url( home_url( '/registrati/' ) ) . '">Registrati per vedere il ' . esc_html( $field_name ) . '</a>' .
           '</span>';
}

/**
 * Shortcode per proteggere i contatti
 * Usage: [protected_contact field="telefono"]
 */
function caniincasa_protected_contact_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'field' => 'telefono',
        'label' => 'contatto',
    ), $atts );

    $field_value = get_field( $atts['field'] );

    if ( ! $field_value ) {
        return '';
    }

    return caniincasa_get_protected_contact( $field_value, $atts['label'] );
}
add_shortcode( 'protected_contact', 'caniincasa_protected_contact_shortcode' );

/**
 * Get user dashboard URL
 */
function caniincasa_get_dashboard_url() {
    return home_url( '/dashboard/' );
}

/**
 * Redirect non-logged users from dashboard
 */
function caniincasa_protect_dashboard() {
    if ( is_page( 'dashboard' ) && ! is_user_logged_in() ) {
        wp_redirect( home_url( '/login/' ) );
        exit;
    }
}
add_action( 'template_redirect', 'caniincasa_protect_dashboard' );

/**
 * Add user info to admin bar
 */
function caniincasa_custom_admin_bar() {
    global $wp_admin_bar;

    if ( ! is_user_logged_in() ) {
        return;
    }

    $user = wp_get_current_user();

    // Dashboard link
    $wp_admin_bar->add_menu( array(
        'id'    => 'caniincasa-dashboard',
        'title' => '🏠 Dashboard',
        'href'  => home_url( '/dashboard/' ),
    ) );

    // Annunci link
    $wp_admin_bar->add_menu( array(
        'id'     => 'caniincasa-annunci',
        'parent' => 'caniincasa-dashboard',
        'title'  => 'I miei annunci',
        'href'   => home_url( '/dashboard/?tab=annunci' ),
    ) );

    // Aggiungi cucciolata
    if ( current_user_can( 'submit_cucciolata' ) ) {
        $wp_admin_bar->add_menu( array(
            'id'     => 'caniincasa-add-cucciolata',
            'parent' => 'caniincasa-dashboard',
            'title'  => '➕ Nuova cucciolata',
            'href'   => home_url( '/dashboard/?tab=aggiungi-cucciolata' ),
        ) );
    }
}
add_action( 'wp_before_admin_bar_render', 'caniincasa_custom_admin_bar' );

/**
 * Update Profile AJAX
 */
add_action( 'wp_ajax_caniincasa_update_profile', 'caniincasa_ajax_update_profile' );

function caniincasa_ajax_update_profile() {
    check_ajax_referer( 'caniincasa_update_profile', 'nonce' );

    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $user_id = get_current_user_id();

    // Update basic info
    $first_name = sanitize_text_field( $_POST['first_name'] );
    $last_name = sanitize_text_field( $_POST['last_name'] );
    $email = sanitize_email( $_POST['email'] );
    $telefono = sanitize_text_field( $_POST['telefono'] );
    $bio = sanitize_textarea_field( $_POST['bio'] );

    // Validate email
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Email non valida' ) );
    }

    // Check if email already exists for another user
    $email_exists = email_exists( $email );
    if ( $email_exists && $email_exists != $user_id ) {
        wp_send_json_error( array( 'message' => 'Email già utilizzata' ) );
    }

    // Update user
    $result = wp_update_user( array(
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'user_email' => $email,
        'description' => $bio,
    ) );

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( array( 'message' => $result->get_error_message() ) );
    }

    update_user_meta( $user_id, 'telefono', $telefono );

    // Change password if requested
    if ( ! empty( $_POST['current_password'] ) && ! empty( $_POST['new_password'] ) ) {
        $user = get_userdata( $user_id );

        if ( ! wp_check_password( $_POST['current_password'], $user->user_pass, $user_id ) ) {
            wp_send_json_error( array( 'message' => 'Password attuale errata' ) );
        }

        wp_set_password( $_POST['new_password'], $user_id );
    }

    wp_send_json_success( array( 'message' => 'Profilo aggiornato con successo!' ) );
}

/**
 * Submit Cucciolata AJAX
 */
add_action( 'wp_ajax_caniincasa_submit_cucciolata', 'caniincasa_ajax_submit_cucciolata' );

function caniincasa_ajax_submit_cucciolata() {
    check_ajax_referer( 'caniincasa_submit_cucciolata', 'nonce' );

    if ( ! is_user_logged_in() || ! current_user_can( 'submit_cucciolata' ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $user_id = get_current_user_id();

    // Sanitize input
    $ricerca_offerta = sanitize_text_field( $_POST['ricerca_offerta'] );
    $titolo = sanitize_text_field( $_POST['titolo'] );
    $razza_id = intval( $_POST['razza'] );
    $data_nascita = sanitize_text_field( $_POST['data_nascita'] );
    $numero_maschi = intval( $_POST['numero_maschi'] );
    $numero_femmine = intval( $_POST['numero_femmine'] );
    $prezzo = ! empty( $_POST['prezzo'] ) ? floatval( $_POST['prezzo'] ) : '';
    $pedigree = sanitize_text_field( $_POST['pedigree'] );
    $provincia_id = intval( $_POST['provincia'] );
    $descrizione = wp_kses_post( $_POST['descrizione'] );

    // Validate base fields
    if ( empty( $titolo ) || empty( $razza_id ) || empty( $ricerca_offerta ) || empty( $descrizione ) ) {
        wp_send_json_error( array( 'message' => 'Compila tutti i campi obbligatori' ) );
    }

    // Validate offerta-specific fields
    if ( $ricerca_offerta === 'offerta' && empty( $data_nascita ) ) {
        wp_send_json_error( array( 'message' => 'La data di nascita è obbligatoria per gli annunci di offerta' ) );
    }

    // Create post
    $post_id = wp_insert_post( array(
        'post_title' => $titolo,
        'post_content' => $descrizione,
        'post_status' => 'pending', // Pending review
        'post_type' => 'annunci_cucciolate',
        'post_author' => $user_id,
    ) );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( array( 'message' => $post_id->get_error_message() ) );
    }

    // Add meta fields
    update_field( 'ricerca_offerta', $ricerca_offerta, $post_id );
    update_field( 'razza', $razza_id, $post_id );

    // Only save offerta-specific fields if type is offerta
    if ( $ricerca_offerta === 'offerta' ) {
        update_field( 'data_nascita', $data_nascita, $post_id );
        update_field( 'numero_maschi', $numero_maschi, $post_id );
        update_field( 'numero_femmine', $numero_femmine, $post_id );
        if ( $prezzo ) {
            update_field( 'prezzo', $prezzo, $post_id );
        }
        if ( $pedigree ) {
            update_field( 'pedigree', $pedigree, $post_id );
        }
    }

    // Set taxonomy
    wp_set_post_terms( $post_id, array( $provincia_id ), 'provincia' );

    // Handle image uploads
    if ( ! empty( $_FILES['immagini'] ) ) {
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        $files = $_FILES['immagini'];
        $image_ids = array();

        for ( $i = 0; $i < count( $files['name'] ) && $i < 5; $i++ ) {
            if ( $files['error'][$i] === 0 ) {
                $file = array(
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                );

                $_FILES = array( 'upload' => $file );

                $attachment_id = media_handle_upload( 'upload', $post_id );

                if ( ! is_wp_error( $attachment_id ) ) {
                    $image_ids[] = $attachment_id;

                    // Set first image as featured
                    if ( $i === 0 ) {
                        set_post_thumbnail( $post_id, $attachment_id );
                    }
                }
            }
        }

        // Store all image IDs
        if ( ! empty( $image_ids ) ) {
            update_field( 'galleria_immagini', $image_ids, $post_id );
        }
    }

    // Send notification email to moderators
    $moderators = get_users( array( 'role' => 'moderatore_annunci' ) );
    foreach ( $moderators as $moderator ) {
        wp_mail(
            $moderator->user_email,
            'Nuovo annuncio da moderare',
            "È stato pubblicato un nuovo annuncio di cucciolata che richiede la tua approvazione.\n\n" .
            "Titolo: $titolo\n" .
            "Link modifica: " . admin_url( "post.php?post=$post_id&action=edit" )
        );
    }

    wp_send_json_success( array(
        'message' => 'Annuncio inviato con successo! Sarà pubblicato dopo la moderazione.',
        'post_id' => $post_id
    ) );
}

/**
 * Submit Dogsitter AJAX
 */
add_action( 'wp_ajax_caniincasa_submit_dogsitter', 'caniincasa_ajax_submit_dogsitter' );

function caniincasa_ajax_submit_dogsitter() {
    check_ajax_referer( 'caniincasa_submit_dogsitter', 'nonce' );

    if ( ! is_user_logged_in() || ! current_user_can( 'submit_cucciolata' ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $user_id = get_current_user_id();

    // Sanitize input
    $titolo = sanitize_text_field( $_POST['titolo'] );
    $provincia_id = intval( $_POST['provincia'] );
    $comune = sanitize_text_field( $_POST['comune'] );
    $esperienza = sanitize_text_field( $_POST['esperienza'] );
    $tariffe = floatval( $_POST['tariffe'] );
    $descrizione = wp_kses_post( $_POST['descrizione'] );

    // Validate required fields
    if ( empty( $titolo ) || empty( $provincia_id ) || empty( $comune ) ||
         empty( $esperienza ) || empty( $tariffe ) || empty( $descrizione ) ) {
        wp_send_json_error( array( 'message' => 'Compila tutti i campi obbligatori' ) );
    }

    // Validate arrays
    $disponibilita = isset( $_POST['disponibilita'] ) && is_array( $_POST['disponibilita'] )
        ? array_map( 'sanitize_text_field', $_POST['disponibilita'] )
        : array();

    $servizi = isset( $_POST['servizi'] ) && is_array( $_POST['servizi'] )
        ? array_map( 'sanitize_text_field', $_POST['servizi'] )
        : array();

    $taglie = isset( $_POST['taglie'] ) && is_array( $_POST['taglie'] )
        ? array_map( 'sanitize_text_field', $_POST['taglie'] )
        : array();

    if ( empty( $disponibilita ) || empty( $servizi ) || empty( $taglie ) ) {
        wp_send_json_error( array( 'message' => 'Seleziona almeno un\'opzione per disponibilità, servizi e taglie' ) );
    }

    // Create post
    $post_id = wp_insert_post( array(
        'post_title' => $titolo,
        'post_content' => $descrizione,
        'post_status' => 'pending',
        'post_type' => 'annunci_dogsitter',
        'post_author' => $user_id,
    ) );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( array( 'message' => $post_id->get_error_message() ) );
    }

    // Save ACF fields
    update_field( 'comune', $comune, $post_id );
    update_field( 'esperienza', $esperienza, $post_id );
    update_field( 'tariffe', $tariffe, $post_id );
    update_field( 'disponibilita', $disponibilita, $post_id );
    update_field( 'servizi', $servizi, $post_id );
    update_field( 'taglie', $taglie, $post_id );

    // Optional fields
    if ( ! empty( $_POST['zona_disponibilita'] ) ) {
        update_field( 'zona_disponibilita', sanitize_text_field( $_POST['zona_disponibilita'] ), $post_id );
    }

    if ( ! empty( $_POST['contatto_telefono'] ) ) {
        update_field( 'contatto_telefono', sanitize_text_field( $_POST['contatto_telefono'] ), $post_id );
    }

    if ( ! empty( $_POST['contatto_email'] ) ) {
        update_field( 'contatto_email', sanitize_email( $_POST['contatto_email'] ), $post_id );
    }

    // Set provincia taxonomy
    wp_set_post_terms( $post_id, array( $provincia_id ), 'provincia' );

    // Handle image uploads (up to 3 images)
    if ( ! empty( $_FILES['immagini'] ) ) {
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );

        $files = $_FILES['immagini'];
        $image_ids = array();

        for ( $i = 0; $i < count( $files['name'] ) && $i < 3; $i++ ) {
            if ( $files['error'][$i] === 0 ) {
                $file = array(
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                );

                $_FILES = array( 'upload' => $file );

                $attachment_id = media_handle_upload( 'upload', $post_id );

                if ( ! is_wp_error( $attachment_id ) ) {
                    $image_ids[] = $attachment_id;

                    // Set first image as featured
                    if ( $i === 0 ) {
                        set_post_thumbnail( $post_id, $attachment_id );
                    }
                }
            }
        }

        // Store all image IDs
        if ( ! empty( $image_ids ) ) {
            update_field( 'galleria_immagini', $image_ids, $post_id );
        }
    }

    // Send notification email to moderators
    $moderators = get_users( array( 'role' => 'moderatore_annunci' ) );
    foreach ( $moderators as $moderator ) {
        wp_mail(
            $moderator->user_email,
            'Nuovo annuncio dogsitter da moderare',
            "È stato pubblicato un nuovo annuncio dogsitter che richiede la tua approvazione.\n\n" .
            "Titolo: $titolo\n" .
            "Link modifica: " . admin_url( "post.php?post=$post_id&action=edit" )
        );
    }

    wp_send_json_success( array(
        'message' => 'Annuncio inviato con successo! Sarà pubblicato dopo la moderazione.',
        'post_id' => $post_id
    ) );
}

/**
 * Delete Annuncio AJAX
 */
add_action( 'wp_ajax_caniincasa_delete_annuncio', 'caniincasa_ajax_delete_annuncio' );

function caniincasa_ajax_delete_annuncio() {
    check_ajax_referer( 'caniincasa_dashboard_nonce', 'nonce' );

    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $post_id = intval( $_POST['post_id'] );
    $post = get_post( $post_id );

    if ( ! $post ) {
        wp_send_json_error( array( 'message' => 'Annuncio non trovato' ) );
    }

    // Check if user owns the post or is admin
    if ( $post->post_author != get_current_user_id() && ! current_user_can( 'delete_others_posts' ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $result = wp_delete_post( $post_id, true );

    if ( ! $result ) {
        wp_send_json_error( array( 'message' => 'Errore durante l\'eliminazione' ) );
    }

    wp_send_json_success( array( 'message' => 'Annuncio eliminato' ) );
}

/**
 * Approve Post AJAX (Moderators only)
 */
add_action( 'wp_ajax_caniincasa_approve_post', 'caniincasa_ajax_approve_post' );

function caniincasa_ajax_approve_post() {
    check_ajax_referer( 'caniincasa_dashboard_nonce', 'nonce' );

    if ( ! current_user_can( 'approve_cucciolate' ) && ! current_user_can( 'publish_posts' ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $post_id = intval( $_POST['post_id'] );

    $result = wp_update_post( array(
        'ID' => $post_id,
        'post_status' => 'publish',
    ) );

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( array( 'message' => 'Errore durante l\'approvazione' ) );
    }

    // Send notification to author
    $post = get_post( $post_id );
    $author = get_userdata( $post->post_author );

    wp_mail(
        $author->user_email,
        'Annuncio approvato',
        "Il tuo annuncio '{$post->post_title}' è stato approvato ed è ora visibile sul sito.\n\n" .
        "Visualizza: " . get_permalink( $post_id )
    );

    wp_send_json_success( array( 'message' => 'Annuncio approvato' ) );
}

/**
 * Reject Post AJAX (Moderators only)
 */
add_action( 'wp_ajax_caniincasa_reject_post', 'caniincasa_ajax_reject_post' );

function caniincasa_ajax_reject_post() {
    check_ajax_referer( 'caniincasa_dashboard_nonce', 'nonce' );

    if ( ! current_user_can( 'approve_cucciolate' ) && ! current_user_can( 'publish_posts' ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $post_id = intval( $_POST['post_id'] );
    $reason = sanitize_textarea_field( $_POST['reason'] );

    // Move to trash
    $result = wp_trash_post( $post_id );

    if ( ! $result ) {
        wp_send_json_error( array( 'message' => 'Errore durante il rifiuto' ) );
    }

    // Send notification to author
    $post = get_post( $post_id );
    $author = get_userdata( $post->post_author );

    $message = "Il tuo annuncio '{$post->post_title}' non è stato approvato.";
    if ( $reason ) {
        $message .= "\n\nMotivo: $reason";
    }

    wp_mail( $author->user_email, 'Annuncio non approvato', $message );

    wp_send_json_success( array( 'message' => 'Annuncio rifiutato' ) );
}

/**
 * Submit Richiesta Struttura AJAX
 */
add_action( 'wp_ajax_caniincasa_submit_richiesta', 'caniincasa_ajax_submit_richiesta' );

function caniincasa_ajax_submit_richiesta() {
    check_ajax_referer( 'caniincasa_submit_richiesta', 'nonce' );

    if ( ! is_user_logged_in() ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();

    // Sanitize input
    $tipo_struttura = sanitize_text_field( $_POST['tipo_struttura'] );
    $tipo_azione = sanitize_text_field( $_POST['tipo_azione'] );
    $nome_struttura_esistente = isset( $_POST['nome_struttura_esistente'] ) ? sanitize_text_field( $_POST['nome_struttura_esistente'] ) : '';
    $nome_struttura = isset( $_POST['nome_struttura'] ) ? sanitize_text_field( $_POST['nome_struttura'] ) : '';
    $indirizzo = isset( $_POST['indirizzo'] ) ? sanitize_text_field( $_POST['indirizzo'] ) : '';
    $provincia_id = isset( $_POST['provincia'] ) ? intval( $_POST['provincia'] ) : 0;
    $comune = isset( $_POST['comune'] ) ? sanitize_text_field( $_POST['comune'] ) : '';
    $cap = isset( $_POST['cap'] ) ? sanitize_text_field( $_POST['cap'] ) : '';
    $telefono = isset( $_POST['telefono'] ) ? sanitize_text_field( $_POST['telefono'] ) : '';
    $email = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
    $sito_web = isset( $_POST['sito_web'] ) ? esc_url_raw( $_POST['sito_web'] ) : '';
    $descrizione = isset( $_POST['descrizione'] ) ? sanitize_textarea_field( $_POST['descrizione'] ) : '';
    $motivazione = isset( $_POST['motivazione'] ) ? sanitize_textarea_field( $_POST['motivazione'] ) : '';
    $note = isset( $_POST['note'] ) ? sanitize_textarea_field( $_POST['note'] ) : '';
    $razze_allevate = isset( $_POST['razze_allevate'] ) ? sanitize_textarea_field( $_POST['razze_allevate'] ) : '';
    $enci_riconosciuto = isset( $_POST['enci_riconosciuto'] ) ? true : false;

    // Validate
    if ( empty( $tipo_struttura ) || empty( $tipo_azione ) ) {
        wp_send_json_error( array( 'message' => 'Dati mancanti' ) );
    }

    if ( ( $tipo_azione === 'modifica' || $tipo_azione === 'rimozione' ) && empty( $nome_struttura_esistente ) ) {
        wp_send_json_error( array( 'message' => 'Indica il nome della struttura esistente' ) );
    }

    if ( ( $tipo_azione === 'modifica' || $tipo_azione === 'rimozione' ) && strlen( $motivazione ) < 50 ) {
        wp_send_json_error( array( 'message' => 'La motivazione deve essere almeno 50 caratteri' ) );
    }

    if ( ( $tipo_azione === 'inserimento' || $tipo_azione === 'modifica' ) && ( empty( $nome_struttura ) || empty( $indirizzo ) || empty( $comune ) || empty( $telefono ) ) ) {
        wp_send_json_error( array( 'message' => 'Compila tutti i campi obbligatori' ) );
    }

    // Create richiesta as pending comment
    $tipo_labels = array(
        'allevamento' => 'Allevamento',
        'veterinario' => 'Veterinario',
        'centro' => 'Centro Cinofilo',
        'canile' => 'Canile',
        'pensione' => 'Pensione',
    );

    $azione_labels = array(
        'inserimento' => 'Inserimento',
        'modifica' => 'Modifica',
        'rimozione' => 'Rimozione',
    );

    $titolo = $azione_labels[$tipo_azione] . ' ' . $tipo_labels[$tipo_struttura] . ': ' . ( $nome_struttura ?: $nome_struttura_esistente );

    $contenuto = "Tipo Struttura: " . $tipo_labels[$tipo_struttura] . "\n";
    $contenuto .= "Tipo Richiesta: " . $azione_labels[$tipo_azione] . "\n\n";

    if ( $nome_struttura_esistente ) {
        $contenuto .= "Struttura Esistente: $nome_struttura_esistente\n\n";
    }

    if ( $tipo_azione === 'inserimento' || $tipo_azione === 'modifica' ) {
        $contenuto .= "Nome: $nome_struttura\n";
        $contenuto .= "Indirizzo: $indirizzo\n";
        $contenuto .= "Comune: $comune\n";
        if ( $provincia_id ) {
            $provincia = get_term( $provincia_id );
            $contenuto .= "Provincia: " . $provincia->name . "\n";
        }
        if ( $cap ) $contenuto .= "CAP: $cap\n";
        $contenuto .= "Telefono: $telefono\n";
        if ( $email ) $contenuto .= "Email: $email\n";
        if ( $sito_web ) $contenuto .= "Sito Web: $sito_web\n";
        if ( $razze_allevate ) $contenuto .= "Razze Allevate: $razze_allevate\n";
        if ( $enci_riconosciuto ) $contenuto .= "ENCI Riconosciuto: Sì\n";
        if ( $descrizione ) $contenuto .= "\nDescrizione:\n$descrizione\n";
    }

    if ( $motivazione ) {
        $contenuto .= "\nMotivazione:\n$motivazione\n";
    }

    if ( $note ) {
        $contenuto .= "\nNote:\n$note\n";
    }

    $contenuto .= "\n---\n";
    $contenuto .= "Richiesta inviata da: " . $current_user->display_name . " (" . $current_user->user_email . ")\n";
    $contenuto .= "Data: " . current_time( 'd/m/Y H:i' );

    // Insert as comment (richiesta type)
    $comment_id = wp_insert_comment( array(
        'comment_post_ID' => 1,
        'comment_author' => $current_user->display_name,
        'comment_author_email' => $current_user->user_email,
        'comment_content' => $contenuto,
        'user_id' => $user_id,
        'comment_type' => 'richiesta_struttura',
        'comment_approved' => 0,
    ) );

    if ( ! $comment_id ) {
        wp_send_json_error( array( 'message' => 'Errore durante l\'invio della richiesta' ) );
    }

    // Add meta
    add_comment_meta( $comment_id, 'tipo_struttura', $tipo_struttura );
    add_comment_meta( $comment_id, 'tipo_azione', $tipo_azione );
    add_comment_meta( $comment_id, 'titolo_richiesta', $titolo );

    // Send email to admins
    $admins = get_users( array( 'role' => 'administrator' ) );
    foreach ( $admins as $admin ) {
        wp_mail(
            $admin->user_email,
            'Nuova richiesta struttura - ' . $titolo,
            $contenuto . "\n\nGestisci richiesta: " . admin_url( 'edit-comments.php?comment_type=richiesta_struttura' )
        );
    }

    wp_send_json_success( array(
        'message' => 'Richiesta inviata con successo! Riceverai una notifica via email quando sarà elaborata.'
    ) );
}

/**
 * Submit Segnalazione AJAX
 */
add_action( 'wp_ajax_caniincasa_submit_segnalazione', 'caniincasa_ajax_submit_segnalazione' );

function caniincasa_ajax_submit_segnalazione() {
    check_ajax_referer( 'caniincasa_dashboard_nonce', 'nonce' );

    if ( ! is_user_logged_in() || ! current_user_can( 'suggest_edits' ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $tipo = sanitize_text_field( $_POST['tipo'] );
    $contenuto = sanitize_textarea_field( $_POST['contenuto'] );
    $post_id = ! empty( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;

    $user_id = get_current_user_id();

    // Create comment as segnalazione
    $comment_id = wp_insert_comment( array(
        'comment_post_ID' => $post_id ?: 1, // Use post ID 1 if no specific post
        'comment_author' => wp_get_current_user()->display_name,
        'comment_author_email' => wp_get_current_user()->user_email,
        'comment_content' => $contenuto,
        'user_id' => $user_id,
        'comment_type' => 'segnalazione',
        'comment_approved' => 0, // Pending
    ) );

    if ( ! $comment_id ) {
        wp_send_json_error( array( 'message' => 'Errore durante l\'invio' ) );
    }

    // Add meta
    add_comment_meta( $comment_id, 'tipo_segnalazione', $tipo );

    wp_send_json_success( array( 'message' => 'Segnalazione inviata con successo' ) );
}
