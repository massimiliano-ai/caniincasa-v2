<?php
/**
 * CaninCasa Theme Functions
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Theme Constants
 */
define( 'CANIINCASA_VERSION', '1.0.0' );
define( 'CANIINCASA_THEME_DIR', get_template_directory() );
define( 'CANIINCASA_THEME_URI', get_template_directory_uri() );
define( 'CANIINCASA_INC_DIR', CANIINCASA_THEME_DIR . '/inc' );

/**
 * Theme Setup
 */
function caniincasa_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'caniincasa', CANIINCASA_THEME_DIR . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Custom image sizes
    add_image_size( 'caniincasa-featured', 1200, 600, true );
    add_image_size( 'caniincasa-thumbnail', 400, 300, true );
    add_image_size( 'caniincasa-card', 600, 400, true );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'caniincasa' ),
        'footer'  => esc_html__( 'Footer Menu', 'caniincasa' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );

    // Add support for responsive embeds
    add_theme_support( 'responsive-embeds' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'caniincasa_setup' );

/**
 * Set the content width in pixels
 */
function caniincasa_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'caniincasa_content_width', 1200 );
}
add_action( 'after_setup_theme', 'caniincasa_content_width', 0 );

/**
 * Register Widget Areas
 */
function caniincasa_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'caniincasa' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'caniincasa' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer 1', 'caniincasa' ),
        'id'            => 'footer-1',
        'description'   => esc_html__( 'Footer widget area 1', 'caniincasa' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer 2', 'caniincasa' ),
        'id'            => 'footer-2',
        'description'   => esc_html__( 'Footer widget area 2', 'caniincasa' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer 3', 'caniincasa' ),
        'id'            => 'footer-3',
        'description'   => esc_html__( 'Footer widget area 3', 'caniincasa' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'caniincasa_widgets_init' );

/**
 * Hide Admin Bar for Non-Administrators
 */
function caniincasa_hide_admin_bar_for_non_admins() {
    // Hide admin bar only in frontend for non-administrators
    if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'caniincasa_hide_admin_bar_for_non_admins' );

/**
 * Remove Admin Bar CSS for Non-Administrators
 * This removes the margin-top added by WordPress when admin bar is shown
 */
function caniincasa_remove_admin_bar_margin() {
    if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
        remove_action( 'wp_head', '_admin_bar_bump_cb' );
    }
}
add_action( 'get_header', 'caniincasa_remove_admin_bar_margin' );

/**
 * Enqueue Stylesheets and Scripts
 */
function caniincasa_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style(
        'caniincasa-style',
        get_stylesheet_uri(),
        array(),
        CANIINCASA_VERSION
    );

    // Enqueue main CSS
    wp_enqueue_style(
        'caniincasa-main',
        CANIINCASA_THEME_URI . '/css/main.css',
        array( 'caniincasa-style' ),
        CANIINCASA_VERSION
    );

    // Enqueue component CSS files
    wp_enqueue_style(
        'caniincasa-cards',
        CANIINCASA_THEME_URI . '/css/components/cards.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-forms',
        CANIINCASA_THEME_URI . '/css/components/forms.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-rating',
        CANIINCASA_THEME_URI . '/css/components/rating.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-homepage',
        CANIINCASA_THEME_URI . '/css/components/homepage.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-blog',
        CANIINCASA_THEME_URI . '/css/components/blog.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-pages',
        CANIINCASA_THEME_URI . '/css/components/pages.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    wp_enqueue_style(
        'caniincasa-breed-characteristics',
        CANIINCASA_THEME_URI . '/css/components/breed-characteristics.css',
        array( 'caniincasa-main' ),
        CANIINCASA_VERSION
    );

    // Enqueue Single Razza layout CSS (only on breed single pages)
    if ( is_singular( 'razze_di_cani' ) ) {
        wp_enqueue_style(
            'caniincasa-single-razza',
            CANIINCASA_THEME_URI . '/css/single-razza.css',
            array( 'caniincasa-main', 'caniincasa-breed-characteristics' ),
            CANIINCASA_VERSION
        );
    }

    // Enqueue main JavaScript
    wp_enqueue_script(
        'caniincasa-main-js',
        CANIINCASA_THEME_URI . '/js/main.js',
        array( 'jquery' ),
        CANIINCASA_VERSION,
        true
    );

    // Localize script for AJAX
    wp_localize_script( 'caniincasa-main-js', 'canincasaAjax', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'caniincasa-nonce' ),
        'homeurl' => home_url(),
    ) );

    // Enqueue richieste strutture JS (only on richieste page)
    if ( is_page_template( 'page-templates/template-richieste-strutture.php' ) ) {
        wp_enqueue_script(
            'caniincasa-richieste',
            CANIINCASA_THEME_URI . '/js/richieste-strutture.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );
    }

    // Enqueue quiz JS and CSS (only on quiz page)
    if ( is_page_template( 'page-templates/template-quiz-scelta-razza.php' ) ) {
        wp_enqueue_style(
            'caniincasa-quiz',
            CANIINCASA_THEME_URI . '/css/quiz.css',
            array( 'caniincasa-main' ),
            CANIINCASA_VERSION
        );

        wp_enqueue_script(
            'caniincasa-quiz-js',
            CANIINCASA_THEME_URI . '/js/quiz-scelta-razza.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );
    }

    // Enqueue auth pages CSS and JS (login and registration)
    if ( is_page_template( 'page-templates/template-login.php' ) ||
         is_page_template( 'page-templates/template-registrazione.php' ) ) {
        wp_enqueue_style(
            'caniincasa-auth-pages',
            CANIINCASA_THEME_URI . '/css/auth-pages.css',
            array( 'caniincasa-main' ),
            CANIINCASA_VERSION
        );

        wp_enqueue_script(
            'caniincasa-auth-forms',
            CANIINCASA_THEME_URI . '/js/auth-forms.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );

        wp_localize_script( 'caniincasa-auth-forms', 'caniincasaAuth', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'caniincasa-auth-nonce' ),
        ) );
    }

    // Enqueue dashboard CSS
    if ( is_page_template( 'page-templates/template-dashboard.php' ) ) {
        wp_enqueue_style(
            'caniincasa-dashboard',
            CANIINCASA_THEME_URI . '/css/dashboard.css',
            array( 'caniincasa-main' ),
            CANIINCASA_VERSION
        );
    }

    // Enqueue archive filters CSS and JS (for structure archive pages)
    $archive_templates = array(
        'page-templates/template-allevamenti.php',
        'page-templates/template-veterinari.php',
        'page-templates/template-centri-cinofili.php',
        'page-templates/template-canili.php',
        'page-templates/template-pensioni.php',
    );

    foreach ( $archive_templates as $template ) {
        if ( is_page_template( $template ) ) {
            wp_enqueue_style(
                'caniincasa-archivi-filtri',
                CANIINCASA_THEME_URI . '/css/archivi-filtri.css',
                array( 'caniincasa-main' ),
                CANIINCASA_VERSION
            );

            wp_enqueue_script(
                'caniincasa-archivi-filtri-js',
                CANIINCASA_THEME_URI . '/js/archivi-filtri.js',
                array( 'jquery' ),
                CANIINCASA_VERSION,
                true
            );
            break;
        }
    }

    // Enqueue comment reply script if needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_scripts' );

/**
 * Google Analytics GA4 Integration
 */
function caniincasa_google_analytics() {
    $ga_measurement_id = get_theme_mod( 'ga_measurement_id', '' );

    if ( empty( $ga_measurement_id ) ) {
        return; // Skip if not configured
    }

    ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga_measurement_id ); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo esc_js( $ga_measurement_id ); ?>', {
            'anonymize_ip': true,
            'cookie_flags': 'SameSite=None;Secure'
        });

        <?php if ( is_user_logged_in() ): ?>
        // Track logged-in user type
        gtag('set', 'user_properties', {
            'user_type': 'logged_in'
        });
        <?php endif; ?>
    </script>
    <?php
}
add_action( 'wp_head', 'caniincasa_google_analytics', 10 );

/**
 * AJAX Handler: Get Breeds for Quiz
 */
function caniincasa_ajax_get_breeds_for_quiz() {
    check_ajax_referer( 'caniincasa-nonce', 'nonce' );

    $args = array(
        'post_type'      => 'razze_di_cani',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    $query = new WP_Query( $args );
    $breeds = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            // Get ACF fields
            $taglia = get_field( 'taglia' );
            $tipo_pelo = get_field( 'tipo_pelo' );
            $livello_energia = get_field( 'livello_di_energia' );
            $addestramento = get_field( 'facilita_addestramento' );
            $bambini = get_field( 'adatto_ai_bambini' );
            $temperamento = get_field( 'temperamento' );
            $latrato = get_field( 'tendenza_al_latrato' );
            $spazio = get_field( 'spazio_necessario' );
            $cura = get_field( 'cura_necessaria' );
            $adatto_principianti = get_field( 'adatto_principianti' );
            $ipoallergenico = get_field( 'ipoallergenico' );

            // Normalize values to lowercase
            $taglia = is_string( $taglia ) ? strtolower( $taglia ) : $taglia;
            $tipo_pelo = is_string( $tipo_pelo ) ? strtolower( $tipo_pelo ) : $tipo_pelo;

            // Build characteristics array
            $caratteristiche = array();
            $caratteristiche_raw = get_field( 'caratteristiche_principali' );

            if ( ! empty( $caratteristiche_raw ) && is_array( $caratteristiche_raw ) ) {
                $caratteristiche = array_filter( $caratteristiche_raw, function( $val ) {
                    return ! empty( $val ) && $val !== null;
                } );
                $caratteristiche = array_values( $caratteristiche );
            }

            // Fallback: extract from excerpt if no characteristics
            if ( empty( $caratteristiche ) ) {
                $excerpt = get_the_excerpt();
                if ( ! empty( $excerpt ) ) {
                    $caratteristiche = array( wp_trim_words( $excerpt, 10, '...' ) );
                }
            }

            $breeds[] = array(
                'id'                      => $post_id,
                'title'                   => get_the_title(),
                'name'                    => get_the_title(), // Alias for JS
                'url'                     => get_permalink(),
                'link'                    => get_permalink(), // Alias for JS
                'image'                   => get_the_post_thumbnail_url( $post_id, 'medium' ),
                'taglia'                  => $taglia ?: 'media',
                'tipo_pelo'               => $tipo_pelo ?: 'medio',
                'livello_energia'         => $livello_energia ?: 'medio',
                'facilita_addestramento'  => $addestramento ?: 'media',
                'adatto_bambini'          => $bambini ?: 'si',
                'adatto_appartamento'     => $spazio ?: 'si',
                'adatto_principianti'     => $adatto_principianti ?: 'si',
                'temperamento'            => $temperamento ?: 'equilibrato',
                'tendenza_abbaio'         => $latrato ?: 'media',
                'ipoallergenico'          => $ipoallergenico ?: 'no',
                'cura'                    => $cura ?: 3,
                'caratteristiche'         => $caratteristiche,
            );
        }
    }

    wp_reset_postdata();

    wp_send_json_success( array( 'breeds' => $breeds ) );
}
add_action( 'wp_ajax_get_breeds_for_quiz', 'caniincasa_ajax_get_breeds_for_quiz' );
add_action( 'wp_ajax_nopriv_get_breeds_for_quiz', 'caniincasa_ajax_get_breeds_for_quiz' );

/**
 * AJAX Handler: Filter Archive by Provincia and Razza
 */
function caniincasa_ajax_filter_archive() {
    check_ajax_referer( 'caniincasa-nonce', 'nonce' );

    $post_type = isset( $_POST['post_type'] ) ? sanitize_text_field( $_POST['post_type'] ) : 'allevamenti';
    $provincia_slug = isset( $_POST['provincia'] ) ? sanitize_text_field( $_POST['provincia'] ) : '';
    $razza_slug = isset( $_POST['razza'] ) ? sanitize_text_field( $_POST['razza'] ) : '';
    $paged = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;

    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 12,
        'paged'          => $paged,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    // Build tax query
    $tax_query = array( 'relation' => 'AND' );

    if ( ! empty( $provincia_slug ) ) {
        $tax_query[] = array(
            'taxonomy' => 'provincia',
            'field'    => 'term_id',
            'terms'    => absint( $provincia_slug ),
        );
    }

    if ( ! empty( $razza_slug ) && $post_type === 'allevamenti' ) {
        $tax_query[] = array(
            'taxonomy' => 'razze_allevamenti',
            'field'    => 'term_id',
            'terms'    => absint( $razza_slug ),
        );
    }

    if ( count( $tax_query ) > 1 ) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query( $args );

    ob_start();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <div class="item-card">

                <!-- Image -->
                <?php if ( has_post_thumbnail() ): ?>
                    <div class="item-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'medium_large', array(
                                'loading' => 'lazy',
                                'alt' => get_the_title()
                            ) ); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Content -->
                <div class="item-content">

                    <h3 class="item-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <?php
                    // Provincia
                    $province = wp_get_post_terms( get_the_ID(), 'provincia' );
                    if ( ! empty( $province ) && ! is_wp_error( $province ) ):
                    ?>
                        <div class="item-location">
                            <span class="icon">📍</span>
                            <span class="text"><?php echo esc_html( $province[0]->name ); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Razze allevate (solo per allevamenti)
                    if ( $post_type === 'allevamenti' ):
                        $razze = wp_get_post_terms( get_the_ID(), 'razze_allevamenti' );
                        if ( ! empty( $razze ) && ! is_wp_error( $razze ) ):
                    ?>
                        <div class="item-breeds">
                            <span class="icon">🐕</span>
                            <span class="text">
                                <?php
                                $razze_names = array_slice( array_map( function($r) { return $r->name; }, $razze ), 0, 3 );
                                echo esc_html( implode( ', ', $razze_names ) );
                                if ( count( $razze ) > 3 ) {
                                    echo ' +' . ( count( $razze ) - 3 );
                                }
                                ?>
                            </span>
                        </div>
                    <?php endif; endif; ?>

                    <?php
                    // Servizi veterinari (solo per veterinari)
                    if ( $post_type === 'struttureveterinarie' ):
                        $servizi = wp_get_post_terms( get_the_ID(), 'servizi_veterinari' );
                        if ( ! empty( $servizi ) && ! is_wp_error( $servizi ) ):
                    ?>
                        <div class="item-services">
                            <span class="icon">🏥</span>
                            <span class="text">
                                <?php
                                $servizi_names = array_slice( array_map( function($s) { return $s->name; }, $servizi ), 0, 3 );
                                echo esc_html( implode( ', ', $servizi_names ) );
                                if ( count( $servizi ) > 3 ) {
                                    echo ' +' . ( count( $servizi ) - 3 );
                                }
                                ?>
                            </span>
                        </div>
                    <?php endif; endif; ?>

                    <?php
                    // Indirizzo e Località/Comune
                    $indirizzo = get_field( 'indirizzo' );
                    $localita = get_field( 'localita' ) ?: get_field( 'comune' );
                    if ( $indirizzo || $localita ):
                    ?>
                        <div class="item-address">
                            <span class="icon">🏠</span>
                            <span class="text">
                                <?php
                                if ( $indirizzo ) {
                                    echo esc_html( wp_trim_words( $indirizzo, 5, '' ) );
                                    if ( $localita ) echo ', ';
                                }
                                if ( $localita ) echo esc_html( $localita );
                                ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Contatti (protetti - solo per utenti registrati)
                    $telefono = get_field( 'telefono_principale' ) ?: get_field( 'telefono' );
                    $email = get_field( 'email' );
                    $sito_web = get_field( 'sito_web' );

                    if ( $telefono || $email || $sito_web ):
                    ?>
                        <div class="item-contacts">
                            <?php if ( function_exists( 'caniincasa_can_view_contacts' ) && caniincasa_can_view_contacts() ): ?>
                                <?php if ( $telefono ): ?>
                                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $telefono ) ); ?>" class="contact-item" title="Telefono">
                                        <span class="icon">📞</span>
                                    </a>
                                <?php endif; ?>

                                <?php if ( $email ): ?>
                                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-item" title="Email">
                                        <span class="icon">✉️</span>
                                    </a>
                                <?php endif; ?>

                                <?php if ( $sito_web ): ?>
                                    <a href="<?php echo esc_url( $sito_web ); ?>" target="_blank" rel="noopener" class="contact-item" title="Sito web">
                                        <span class="icon">🌐</span>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="protected-contact-message">
                                    <span class="icon">🔒</span>
                                    <a href="<?php echo home_url( '/registrati/' ); ?>">Registrati per vedere i contatti</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- View More Button -->
                    <a href="<?php the_permalink(); ?>" class="btn-view-more">
                        Visualizza dettagli
                    </a>

                </div>

            </div>
            <?php
        }
    } else {
        ?>
        <div class="no-items">
            <div class="no-items-icon">🔍</div>
            <h3>Nessun risultato trovato</h3>
            <p>Nessuna struttura trovata con i filtri selezionati.</p>
        </div>
        <?php
    }

    $html = ob_get_clean();
    wp_reset_postdata();

    // Build results info HTML
    $results_info = '<p class="results-count">Trovati <strong>' . $query->found_posts . '</strong> risultati';
    if ( $query->max_num_pages > 1 ) {
        $results_info .= ' (Pagina 1 di ' . $query->max_num_pages . ')';
    }
    $results_info .= '</p>';

    wp_send_json_success( array(
        'html'          => $html,
        'found_posts'   => $query->found_posts,
        'max_num_pages' => $query->max_num_pages,
        'results_info'  => $results_info,
    ) );
}
add_action( 'wp_ajax_filter_archive_by_provincia', 'caniincasa_ajax_filter_archive' );
add_action( 'wp_ajax_nopriv_filter_archive_by_provincia', 'caniincasa_ajax_filter_archive' );

/**
 * Include Required Files
 */

// Custom Post Types
require_once CANIINCASA_INC_DIR . '/custom-post-types.php';

// Custom Taxonomies
require_once CANIINCASA_INC_DIR . '/taxonomies.php';

// Populate Italian Provinces
require_once CANIINCASA_INC_DIR . '/populate-provinces.php';

// Custom Fields (ACF)
if ( file_exists( CANIINCASA_INC_DIR . '/custom-fields.php' ) ) {
    require_once CANIINCASA_INC_DIR . '/custom-fields.php';
}

// Template Functions
require_once CANIINCASA_INC_DIR . '/template-functions.php';

// Customizer
require_once CANIINCASA_INC_DIR . '/customizer.php';

// AJAX Handlers
if ( file_exists( CANIINCASA_INC_DIR . '/ajax-handlers.php' ) ) {
    require_once CANIINCASA_INC_DIR . '/ajax-handlers.php';
}

// Enqueue Scripts
require_once CANIINCASA_INC_DIR . '/enqueue-scripts.php';

// User System
require_once CANIINCASA_INC_DIR . '/user-system.php';

// Custom Post Type: Cucciolate
require_once CANIINCASA_INC_DIR . '/cpt-cucciolate.php';

/**
 * Add ACF Options Page (if ACF is active)
 */
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title' => __( 'Theme General Settings', 'caniincasa' ),
        'menu_title' => __( 'Theme Settings', 'caniincasa' ),
        'menu_slug'  => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ) );
}

/**
 * Remove WordPress version number
 * Security best practice
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Disable XML-RPC for security
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove emoji scripts for performance
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

/**
 * Add Security Headers
 */
function caniincasa_security_headers() {
    header( 'X-Content-Type-Options: nosniff' );
    header( 'X-Frame-Options: SAMEORIGIN' );
    header( 'X-XSS-Protection: 1; mode=block' );
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
}
add_action( 'send_headers', 'caniincasa_security_headers' );

/**
 * Custom Excerpt Length
 */
function caniincasa_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'caniincasa_excerpt_length' );

/**
 * Custom Excerpt More
 */
function caniincasa_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'caniincasa_excerpt_more' );

/**
 * DEBUG MODE per Local by Flywheel - Bypass Nonce Verification
 *
 * IMPORTANTE: Questo bypassa la sicurezza nonce SOLO su localhost!
 * RIMUOVI prima del deploy in produzione!
 *
 * Questo DEVE essere definito PRIMA di includere razze-ajax-filters.php
 */
if (
    ( defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local' ) ||
    ( isset($_SERVER['HTTP_HOST']) && strpos( $_SERVER['HTTP_HOST'], '.local' ) !== false ) ||
    ( isset($_SERVER['HTTP_HOST']) && strpos( $_SERVER['HTTP_HOST'], 'localhost' ) !== false )
) {
    define( 'RAZZE_SKIP_NONCE_CHECK', true );
    if ( function_exists('error_log') ) {
        error_log( '⚠️ RAZZE DEBUG MODE ATTIVO: Nonce check disabilitato per ' . $_SERVER['HTTP_HOST'] );
    }
}

/**
 * Include AJAX Filters for Razze Archive
 */
require_once CANIINCASA_INC_DIR . '/razze-ajax-filters.php';

/**
 * Enqueue Archive Razze Scripts & Styles
 */
function caniincasa_razze_archive_scripts() {
    // Only on razze archive
    if ( !is_post_type_archive( 'razze_di_cani' ) ) {
        return;
    }

    // Archive CSS
    wp_enqueue_style(
        'caniincasa-archive-razze',
        CANIINCASA_THEME_URI . '/css/archive-razze.css',
        array(),
        CANIINCASA_VERSION
    );

    // Archive JS
    wp_enqueue_script(
        'caniincasa-razze-filters',
        CANIINCASA_THEME_URI . '/js/razze-filters.js',
        array( 'jquery' ),
        CANIINCASA_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'caniincasa_razze_archive_scripts' );

/**
 * Enqueue Page Template Razze Scripts & Styles
 */
function caniincasa_page_razze_template_scripts() {
    // Template con filtri AJAX
    if ( is_page_template( 'page-templates/template-razze-archive.php' ) ) {
        // Page Template CSS
        wp_enqueue_style(
            'caniincasa-page-razze-archive',
            CANIINCASA_THEME_URI . '/css/page-razze-archive.css',
            array(),
            CANIINCASA_VERSION
        );

        // Page Template JS
        wp_enqueue_script(
            'caniincasa-page-razze-filters',
            CANIINCASA_THEME_URI . '/js/page-razze-filters.js',
            array( 'jquery' ),
            CANIINCASA_VERSION,
            true
        );

        // Localize script for AJAX
        wp_localize_script( 'caniincasa-page-razze-filters', 'razzeFilterData', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'razze_filter_nonce' ),
        ) );
    }

    // Template semplice senza filtri
    if ( is_page_template( 'page-templates/template-razze-semplice.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-razze-semplice',
            CANIINCASA_THEME_URI . '/css/page-razze-semplice.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template allevamenti
    if ( is_page_template( 'page-templates/template-allevamenti.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template canili
    if ( is_page_template( 'page-templates/template-canili.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template veterinari
    if ( is_page_template( 'page-templates/template-veterinari.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }

    // Template centri cinofili
    if ( is_page_template( 'page-templates/template-centri-cinofili.php' ) ) {
        wp_enqueue_style(
            'caniincasa-page-templates-grid',
            CANIINCASA_THEME_URI . '/css/page-templates-grid.css',
            array(),
            CANIINCASA_VERSION
        );
    }
}
add_action( 'wp_enqueue_scripts', 'caniincasa_page_razze_template_scripts' );
