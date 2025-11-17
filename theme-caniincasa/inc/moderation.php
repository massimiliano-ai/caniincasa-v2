<?php
/**
 * Sistema di Moderazione Annunci
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add Moderation Meta Box to Annunci
 */
function caniincasa_add_moderation_meta_box() {
    add_meta_box(
        'caniincasa_moderation',
        '🔍 Moderazione Annuncio',
        'caniincasa_moderation_meta_box_callback',
        array( 'annunci_cucciolate', 'annunci_dogsitter' ),
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'caniincasa_add_moderation_meta_box' );

/**
 * Moderation Meta Box Callback
 */
function caniincasa_moderation_meta_box_callback( $post ) {
    wp_nonce_field( 'caniincasa_moderation_nonce', 'moderation_nonce' );

    $status = $post->post_status;
    $author = get_userdata( $post->post_author );
    $data_pubblicazione = get_the_date( 'd/m/Y H:i', $post );
    $post_type_label = $post->post_type === 'annunci_cucciolate' ? 'Cucciolate' : 'Dogsitter';

    ?>
    <div class="moderation-box">
        <p><strong>Stato Attuale:</strong>
            <span class="status-badge status-<?php echo esc_attr( $status ); ?>">
                <?php
                if ( $status === 'publish' ) echo '✓ Pubblicato';
                elseif ( $status === 'pending' ) echo '⏳ In Attesa';
                elseif ( $status === 'draft' ) echo '✎ Bozza';
                elseif ( $status === 'trash' ) echo '🗑 Cestino';
                else echo ucfirst( $status );
                ?>
            </span>
        </p>

        <p><strong>Tipo:</strong> <?php echo esc_html( $post_type_label ); ?></p>
        <p><strong>Autore:</strong> <?php echo esc_html( $author->display_name ); ?><br>
           <small><?php echo esc_html( $author->user_email ); ?></small></p>
        <p><strong>Data Creazione:</strong><br><?php echo esc_html( $data_pubblicazione ); ?></p>

        <?php if ( $status === 'pending' ) : ?>
            <div class="moderation-actions">
                <h4>Azioni Moderazione:</h4>
                <div class="action-buttons">
                    <button type="button" class="button button-primary button-large" onclick="caniincasaModerateAnnuncio('approve', <?php echo $post->ID; ?>)">
                        ✓ Approva e Pubblica
                    </button>
                    <button type="button" class="button button-secondary" onclick="caniincasaModerateAnnuncio('reject', <?php echo $post->ID; ?>)">
                        ✗ Rifiuta
                    </button>
                </div>
                <div id="moderation-message" style="margin-top: 10px;"></div>
            </div>

            <style>
                .moderation-actions {
                    margin-top: 15px;
                    padding-top: 15px;
                    border-top: 1px solid #ddd;
                }
                .action-buttons {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                }
                .action-buttons button {
                    width: 100%;
                }
                .status-badge {
                    display: inline-block;
                    padding: 3px 8px;
                    border-radius: 3px;
                    font-size: 12px;
                    font-weight: bold;
                }
                .status-publish {
                    background: #46b450;
                    color: white;
                }
                .status-pending {
                    background: #f0ad4e;
                    color: white;
                }
                .status-draft {
                    background: #999;
                    color: white;
                }
            </style>

            <script>
            function caniincasaModerateAnnuncio(action, postId) {
                if (!confirm('Sei sicuro di voler ' + (action === 'approve' ? 'approvare' : 'rifiutare') + ' questo annuncio?')) {
                    return;
                }

                var messageDiv = document.getElementById('moderation-message');
                messageDiv.innerHTML = '<p>Elaborazione...</p>';

                jQuery.post(ajaxurl, {
                    action: 'caniincasa_moderate_annuncio',
                    nonce: '<?php echo wp_create_nonce( 'caniincasa_moderate_' . $post->ID ); ?>',
                    post_id: postId,
                    moderation_action: action
                }, function(response) {
                    if (response.success) {
                        messageDiv.innerHTML = '<p style="color: green;">✓ ' + response.data.message + '</p>';
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        messageDiv.innerHTML = '<p style="color: red;">✗ ' + response.data.message + '</p>';
                    }
                });
            }
            </script>
        <?php elseif ( $status === 'publish' ) : ?>
            <p class="description">✓ Questo annuncio è stato approvato e pubblicato.</p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * AJAX Handler for Annuncio Moderation
 */
add_action( 'wp_ajax_caniincasa_moderate_annuncio', 'caniincasa_ajax_moderate_annuncio' );

function caniincasa_ajax_moderate_annuncio() {
    $post_id = intval( $_POST['post_id'] );
    $action = sanitize_text_field( $_POST['moderation_action'] );

    check_ajax_referer( 'caniincasa_moderate_' . $post_id, 'nonce' );

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_send_json_error( array( 'message' => 'Non autorizzato' ) );
    }

    $post = get_post( $post_id );
    if ( ! $post ) {
        wp_send_json_error( array( 'message' => 'Annuncio non trovato' ) );
    }

    if ( $action === 'approve' ) {
        // Approva e pubblica
        wp_update_post( array(
            'ID' => $post_id,
            'post_status' => 'publish'
        ) );

        // Invia notifica email all'autore
        $author = get_userdata( $post->post_author );
        if ( $author ) {
            $subject = '[CaninCasa] Il tuo annuncio è stato approvato!';
            $message = sprintf(
                "Ciao %s,\n\nIl tuo annuncio '%s' è stato approvato e pubblicato!\n\nPuoi visualizzarlo qui: %s\n\nGrazie per aver scelto CaninCasa!",
                $author->display_name,
                $post->post_title,
                get_permalink( $post_id )
            );
            wp_mail( $author->user_email, $subject, $message );
        }

        wp_send_json_success( array( 'message' => 'Annuncio approvato e pubblicato con successo!' ) );

    } elseif ( $action === 'reject' ) {
        // Rifiuta (metti in bozza)
        wp_update_post( array(
            'ID' => $post_id,
            'post_status' => 'draft'
        ) );

        // Invia notifica email all'autore
        $author = get_userdata( $post->post_author );
        if ( $author ) {
            $subject = '[CaninCasa] Il tuo annuncio richiede modifiche';
            $message = sprintf(
                "Ciao %s,\n\nIl tuo annuncio '%s' non è stato approvato.\n\nTi preghiamo di verificare che rispetti le nostre linee guida e di modificarlo se necessario.\n\nPuoi modificarlo dalla tua dashboard: %s\n\nGrazie per la comprensione.",
                $author->display_name,
                $post->post_title,
                home_url( '/dashboard/' )
            );
            wp_mail( $author->user_email, $subject, $message );
        }

        wp_send_json_success( array( 'message' => 'Annuncio rifiutato. L\'autore è stato notificato.' ) );
    }

    wp_send_json_error( array( 'message' => 'Azione non valida' ) );
}

/**
 * Add Status Column to Annunci List
 */
function caniincasa_annunci_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['stato_moderazione'] = '🔍 Stato';
    $new_columns['author'] = 'Autore';
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter( 'manage_annunci_cucciolate_posts_columns', 'caniincasa_annunci_columns' );
add_filter( 'manage_annunci_dogsitter_posts_columns', 'caniincasa_annunci_columns' );

/**
 * Populate Status Column
 */
function caniincasa_annunci_column_content( $column, $post_id ) {
    if ( $column === 'stato_moderazione' ) {
        $status = get_post_status( $post_id );

        if ( $status === 'publish' ) {
            echo '<span class="status-badge status-publish">✓ Pubblicato</span>';
        } elseif ( $status === 'pending' ) {
            echo '<span class="status-badge status-pending">⏳ In Attesa</span>';
        } elseif ( $status === 'draft' ) {
            echo '<span class="status-badge status-draft">✎ Bozza</span>';
        } else {
            echo '<span>' . esc_html( ucfirst( $status ) ) . '</span>';
        }
    }
}
add_action( 'manage_annunci_cucciolate_posts_custom_column', 'caniincasa_annunci_column_content', 10, 2 );
add_action( 'manage_annunci_dogsitter_posts_custom_column', 'caniincasa_annunci_column_content', 10, 2 );

/**
 * Add Quick Actions to Annunci List
 */
function caniincasa_annunci_row_actions( $actions, $post ) {
    if ( $post->post_status === 'pending' && in_array( $post->post_type, array( 'annunci_cucciolate', 'annunci_dogsitter' ) ) ) {
        $approve_url = wp_nonce_url(
            admin_url( 'admin-post.php?action=approve_annuncio&post_id=' . $post->ID ),
            'approve_annuncio_' . $post->ID
        );
        $reject_url = wp_nonce_url(
            admin_url( 'admin-post.php?action=reject_annuncio&post_id=' . $post->ID ),
            'reject_annuncio_' . $post->ID
        );

        $actions['approve'] = '<a href="' . esc_url( $approve_url ) . '" style="color: green;">✓ Approva</a>';
        $actions['reject'] = '<a href="' . esc_url( $reject_url ) . '" style="color: red;">✗ Rifiuta</a>';
    }
    return $actions;
}
add_filter( 'post_row_actions', 'caniincasa_annunci_row_actions', 10, 2 );

/**
 * Handle Quick Approve Action
 */
add_action( 'admin_post_approve_annuncio', 'caniincasa_handle_quick_approve' );

function caniincasa_handle_quick_approve() {
    $post_id = intval( $_GET['post_id'] );
    check_admin_referer( 'approve_annuncio_' . $post_id );

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_die( 'Non autorizzato' );
    }

    $post = get_post( $post_id );
    wp_update_post( array(
        'ID' => $post_id,
        'post_status' => 'publish'
    ) );

    // Send email to author
    $author = get_userdata( $post->post_author );
    if ( $author ) {
        $subject = '[CaninCasa] Il tuo annuncio è stato approvato!';
        $message = sprintf(
            "Ciao %s,\n\nIl tuo annuncio '%s' è stato approvato e pubblicato!\n\nPuoi visualizzarlo qui: %s",
            $author->display_name,
            $post->post_title,
            get_permalink( $post_id )
        );
        wp_mail( $author->user_email, $subject, $message );
    }

    wp_redirect( admin_url( 'edit.php?post_type=' . $post->post_type . '&approved=1' ) );
    exit;
}

/**
 * Handle Quick Reject Action
 */
add_action( 'admin_post_reject_annuncio', 'caniincasa_handle_quick_reject' );

function caniincasa_handle_quick_reject() {
    $post_id = intval( $_GET['post_id'] );
    check_admin_referer( 'reject_annuncio_' . $post_id );

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_die( 'Non autorizzato' );
    }

    $post = get_post( $post_id );
    wp_update_post( array(
        'ID' => $post_id,
        'post_status' => 'draft'
    ) );

    // Send email to author
    $author = get_userdata( $post->post_author );
    if ( $author ) {
        $subject = '[CaninCasa] Il tuo annuncio richiede modifiche';
        $message = sprintf(
            "Ciao %s,\n\nIl tuo annuncio '%s' non è stato approvato.\n\nModificalo dalla dashboard: %s",
            $author->display_name,
            $post->post_title,
            home_url( '/dashboard/' )
        );
        wp_mail( $author->user_email, $subject, $message );
    }

    wp_redirect( admin_url( 'edit.php?post_type=' . $post->post_type . '&rejected=1' ) );
    exit;
}

/**
 * Add Admin Notices for Quick Actions
 */
add_action( 'admin_notices', 'caniincasa_moderation_admin_notices' );

function caniincasa_moderation_admin_notices() {
    if ( isset( $_GET['approved'] ) && $_GET['approved'] == '1' ) {
        echo '<div class="notice notice-success is-dismissible"><p>✓ Annuncio approvato e pubblicato con successo!</p></div>';
    }
    if ( isset( $_GET['rejected'] ) && $_GET['rejected'] == '1' ) {
        echo '<div class="notice notice-warning is-dismissible"><p>Annuncio rifiutato. L\'autore è stato notificato.</p></div>';
    }
}

/**
 * Add Style for Status Badges
 */
add_action( 'admin_head', 'caniincasa_moderation_admin_styles' );

function caniincasa_moderation_admin_styles() {
    ?>
    <style>
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }
        .status-publish {
            background: #46b450;
            color: white;
        }
        .status-pending {
            background: #f0ad4e;
            color: white;
        }
        .status-draft {
            background: #999;
            color: white;
        }
    </style>
    <?php
}
