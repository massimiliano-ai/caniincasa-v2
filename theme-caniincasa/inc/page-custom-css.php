<?php
/**
 * Page Custom CSS Metabox
 * Allows custom CSS to be added to individual pages/posts
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Custom CSS Metabox
 */
function caniincasa_register_custom_css_metabox() {
    $post_types = array( 'page', 'post', 'allevamenti', 'canili', 'struttureveterinarie', 'pensioni_per_cani', 'centri_cinofili', 'razze_di_cani', 'annunci_cucciolate', 'annunci_dogsitter' );

    add_meta_box(
        'caniincasa_custom_css',
        __( 'CSS Personalizzato', 'caniincasa' ),
        'caniincasa_custom_css_metabox_callback',
        $post_types,
        'normal',
        'low'
    );
}
add_action( 'add_meta_boxes', 'caniincasa_register_custom_css_metabox' );

/**
 * Metabox Callback Function
 */
function caniincasa_custom_css_metabox_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'caniincasa_save_custom_css', 'caniincasa_custom_css_nonce' );

    // Get existing value
    $custom_css = get_post_meta( $post->ID, '_caniincasa_custom_css', true );

    ?>
    <div class="caniincasa-custom-css-metabox">
        <p class="description">
            <?php _e( 'Inserisci CSS personalizzato che verrà applicato solo a questa pagina. Non includere i tag &lt;style&gt;.', 'caniincasa' ); ?>
        </p>

        <textarea
            id="caniincasa_custom_css"
            name="caniincasa_custom_css"
            rows="15"
            style="width: 100%; font-family: monospace; font-size: 13px;"
            placeholder="/* Il tuo CSS personalizzato qui */
.esempio {
    color: #FF6B35;
    padding: 20px;
}"
        ><?php echo esc_textarea( $custom_css ); ?></textarea>

        <p class="description" style="margin-top: 10px;">
            <strong><?php _e( 'Esempio:', 'caniincasa' ); ?></strong><br>
            <code>.my-custom-class { background-color: #f0f0f0; padding: 20px; }</code>
        </p>

        <p class="description">
            <strong><?php _e( 'Nota:', 'caniincasa' ); ?></strong>
            <?php _e( 'Il CSS verrà caricato nell\'header della pagina. Assicurati che la sintassi sia corretta per evitare errori di visualizzazione.', 'caniincasa' ); ?>
        </p>
    </div>

    <style>
        .caniincasa-custom-css-metabox {
            padding: 10px 0;
        }
        .caniincasa-custom-css-metabox textarea {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
        }
        .caniincasa-custom-css-metabox textarea:focus {
            background: #fff;
            border-color: #5b9dd9;
            outline: none;
        }
    </style>
    <?php
}

/**
 * Save Custom CSS Meta
 */
function caniincasa_save_custom_css_meta( $post_id ) {
    // Check if nonce is set
    if ( ! isset( $_POST['caniincasa_custom_css_nonce'] ) ) {
        return;
    }

    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['caniincasa_custom_css_nonce'], 'caniincasa_save_custom_css' ) ) {
        return;
    }

    // If autosave, don't save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check user permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Sanitize and save
    if ( isset( $_POST['caniincasa_custom_css'] ) ) {
        $custom_css = wp_strip_all_tags( $_POST['caniincasa_custom_css'] );

        // Additional sanitization - allow only CSS
        $custom_css = sanitize_textarea_field( $custom_css );

        update_post_meta( $post_id, '_caniincasa_custom_css', $custom_css );
    } else {
        delete_post_meta( $post_id, '_caniincasa_custom_css' );
    }
}
add_action( 'save_post', 'caniincasa_save_custom_css_meta' );

/**
 * Output Custom CSS in the head
 */
function caniincasa_output_custom_css() {
    if ( is_singular() ) {
        global $post;

        if ( ! $post ) {
            return;
        }

        $custom_css = get_post_meta( $post->ID, '_caniincasa_custom_css', true );

        if ( ! empty( $custom_css ) ) {
            echo "\n<!-- Custom CSS for " . esc_attr( $post->post_title ) . " -->\n";
            echo '<style type="text/css" id="caniincasa-custom-css-' . esc_attr( $post->ID ) . '">' . "\n";
            echo wp_strip_all_tags( $custom_css ) . "\n";
            echo '</style>' . "\n";
        }
    }
}
add_action( 'wp_head', 'caniincasa_output_custom_css', 100 );

/**
 * Add capability check for Custom CSS feature
 */
function caniincasa_custom_css_capability_check() {
    // Only administrators and editors can add custom CSS
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        return false;
    }
    return true;
}

/**
 * Add CSS editor syntax highlighting (optional)
 * Uses CodeMirror from WordPress core
 */
function caniincasa_enqueue_css_editor_assets( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    // Enqueue CodeMirror for better CSS editing
    wp_enqueue_code_editor( array( 'type' => 'text/css' ) );

    // Initialize CodeMirror on our textarea
    wp_add_inline_script( 'code-editor', '
        jQuery(document).ready(function($) {
            if ($("#caniincasa_custom_css").length) {
                var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {};
                editorSettings.codemirror = _.extend(
                    {},
                    editorSettings.codemirror,
                    {
                        indentUnit: 2,
                        tabSize: 2,
                        mode: "css",
                        lineNumbers: true,
                        lineWrapping: true,
                        styleActiveLine: true,
                        matchBrackets: true,
                        autoCloseBrackets: true,
                    }
                );
                var editor = wp.codeEditor.initialize($("#caniincasa_custom_css"), editorSettings);
            }
        });
    ' );
}
add_action( 'admin_enqueue_scripts', 'caniincasa_enqueue_css_editor_assets' );
