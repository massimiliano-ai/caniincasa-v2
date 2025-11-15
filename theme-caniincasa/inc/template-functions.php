<?php
/**
 * Template Functions
 * Helper functions for templates
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get Rating Stars HTML
 *
 * @param int $rating Rating value (1-5)
 * @param bool $show_value Show numeric value
 * @return string HTML output
 */
function caniincasa_get_rating_stars( $rating = 0, $show_value = true ) {
    $rating = absint( $rating );
    $rating = min( max( $rating, 0 ), 5 ); // Ensure rating is between 0 and 5

    $output = '<div class="rating-stars">';

    for ( $i = 1; $i <= 5; $i++ ) {
        $class = $i <= $rating ? 'star filled' : 'star';
        $output .= '<span class="' . esc_attr( $class ) . '">★</span>';
    }

    if ( $show_value ) {
        $output .= ' <span class="rating-value">' . esc_html( $rating ) . '/5</span>';
    }

    $output .= '</div>';

    return $output;
}

/**
 * Display Rating Stars
 *
 * @param int $rating Rating value (1-5)
 * @param bool $show_value Show numeric value
 */
function caniincasa_rating_stars( $rating = 0, $show_value = true ) {
    echo caniincasa_get_rating_stars( $rating, $show_value );
}

/**
 * Get Breadcrumbs HTML
 *
 * @return string HTML output
 */
function caniincasa_get_breadcrumbs() {
    if ( is_front_page() ) {
        return '';
    }

    $output = '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'caniincasa' ) . '">';
    $output .= '<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';

    // Home
    $output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    $output .= '<a href="' . esc_url( home_url( '/' ) ) . '" itemprop="item">';
    $output .= '<span itemprop="name">' . esc_html__( 'Home', 'caniincasa' ) . '</span>';
    $output .= '</a>';
    $output .= '<meta itemprop="position" content="1" />';
    $output .= '</li>';

    $position = 2;

    if ( is_single() || is_page() ) {
        $post_type = get_post_type();

        // Add post type archive
        if ( $post_type !== 'post' && $post_type !== 'page' ) {
            $post_type_object = get_post_type_object( $post_type );
            if ( $post_type_object ) {
                $output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                $output .= '<span itemprop="name">' . esc_html( $post_type_object->labels->name ) . '</span>';
                $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
                $output .= '</li>';
                $position++;
            }
        }

        // Add current page/post
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html( get_the_title() ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_category() || is_tax() || is_tag() ) {
        $term = get_queried_object();
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html( $term->name ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_archive() ) {
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html( get_the_archive_title() ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_search() ) {
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html__( 'Risultati ricerca per:', 'caniincasa' ) . ' ' . esc_html( get_search_query() ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_404() ) {
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html__( 'Pagina non trovata', 'caniincasa' ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';
    }

    $output .= '</ol>';
    $output .= '</nav>';

    return $output;
}

/**
 * Display Breadcrumbs
 */
function caniincasa_breadcrumbs() {
    echo caniincasa_get_breadcrumbs();
}

/**
 * Get Contact Info Box HTML
 *
 * @param int $post_id Post ID
 * @return string HTML output
 */
function caniincasa_get_contact_box( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $email = get_post_meta( $post_id, 'email', true );
    $telefono = get_post_meta( $post_id, 'telefono', true );
    $telefono_principale = get_post_meta( $post_id, 'telefono_principale', true );
    $cellulare = get_post_meta( $post_id, 'cellulare', true );
    $sito_web = get_post_meta( $post_id, 'sito_web', true );
    $indirizzo = get_post_meta( $post_id, 'indirizzo', true );
    $citta = get_post_meta( $post_id, 'citta', true );
    $provincia = get_post_meta( $post_id, 'provincia', true );

    $phone = $telefono_principale ? $telefono_principale : $telefono;
    $phone = $phone ? $phone : $cellulare;

    $output = '<div class="contact-box">';
    $output .= '<h3>' . esc_html__( 'Informazioni Contatto', 'caniincasa' ) . '</h3>';
    $output .= '<ul class="contact-list">';

    if ( $phone ) {
        $output .= '<li class="contact-phone">';
        $output .= '<i class="icon-phone">📞</i> ';
        $output .= '<a href="' . esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>';
        $output .= '</li>';
    }

    if ( $email ) {
        $output .= '<li class="contact-email">';
        $output .= '<i class="icon-email">✉️</i> ';
        $output .= '<a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>';
        $output .= '</li>';
    }

    if ( $sito_web ) {
        $output .= '<li class="contact-web">';
        $output .= '<i class="icon-web">🌐</i> ';
        $output .= '<a href="' . esc_url( $sito_web ) . '" target="_blank" rel="noopener">' . esc_html__( 'Visita il sito', 'caniincasa' ) . '</a>';
        $output .= '</li>';
    }

    if ( $indirizzo && $citta ) {
        $full_address = $indirizzo . ', ' . $citta;
        if ( $provincia ) {
            $full_address .= ' (' . $provincia . ')';
        }
        $output .= '<li class="contact-location">';
        $output .= '<i class="icon-location">📍</i> ';
        $output .= esc_html( $full_address );
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

/**
 * Display Contact Box
 *
 * @param int $post_id Post ID
 */
function caniincasa_contact_box( $post_id = null ) {
    echo caniincasa_get_contact_box( $post_id );
}

/**
 * Get Related Posts
 *
 * @param int $post_id Post ID
 * @param int $count Number of posts to retrieve
 * @return WP_Query|false
 */
function caniincasa_get_related_posts( $post_id = null, $count = 3 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $post_type = get_post_type( $post_id );
    $taxonomies = get_object_taxonomies( $post_type, 'names' );

    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $count,
        'post__not_in'   => array( $post_id ),
        'orderby'        => 'rand',
    );

    // Try to get related posts by taxonomy
    if ( ! empty( $taxonomies ) ) {
        $terms = wp_get_post_terms( $post_id, $taxonomies, array( 'fields' => 'ids' ) );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomies[0],
                    'field'    => 'term_id',
                    'terms'    => $terms,
                ),
            );
        }
    }

    $query = new WP_Query( $args );

    return $query->have_posts() ? $query : false;
}

/**
 * Sanitize Textarea Field
 *
 * @param string $input Input value
 * @return string Sanitized value
 */
function caniincasa_sanitize_textarea( $input ) {
    return wp_kses_post( $input );
}

/**
 * Get Province List (Italian Provinces)
 *
 * @return array
 */
function caniincasa_get_province_list() {
    return array(
        'AG' => 'Agrigento',
        'AL' => 'Alessandria',
        'AN' => 'Ancona',
        'AO' => 'Aosta',
        'AR' => 'Arezzo',
        'AP' => 'Ascoli Piceno',
        'AT' => 'Asti',
        'AV' => 'Avellino',
        'BA' => 'Bari',
        'BT' => 'Barletta-Andria-Trani',
        'BL' => 'Belluno',
        'BN' => 'Benevento',
        'BG' => 'Bergamo',
        'BI' => 'Biella',
        'BO' => 'Bologna',
        'BZ' => 'Bolzano',
        'BS' => 'Brescia',
        'BR' => 'Brindisi',
        'CA' => 'Cagliari',
        'CL' => 'Caltanissetta',
        'CB' => 'Campobasso',
        'CI' => 'Carbonia-Iglesias',
        'CE' => 'Caserta',
        'CT' => 'Catania',
        'CZ' => 'Catanzaro',
        'CH' => 'Chieti',
        'CO' => 'Como',
        'CS' => 'Cosenza',
        'CR' => 'Cremona',
        'KR' => 'Crotone',
        'CN' => 'Cuneo',
        'EN' => 'Enna',
        'FM' => 'Fermo',
        'FE' => 'Ferrara',
        'FI' => 'Firenze',
        'FG' => 'Foggia',
        'FC' => 'Forlì-Cesena',
        'FR' => 'Frosinone',
        'GE' => 'Genova',
        'GO' => 'Gorizia',
        'GR' => 'Grosseto',
        'IM' => 'Imperia',
        'IS' => 'Isernia',
        'SP' => 'La Spezia',
        'AQ' => 'L\'Aquila',
        'LT' => 'Latina',
        'LE' => 'Lecce',
        'LC' => 'Lecco',
        'LI' => 'Livorno',
        'LO' => 'Lodi',
        'LU' => 'Lucca',
        'MC' => 'Macerata',
        'MN' => 'Mantova',
        'MS' => 'Massa-Carrara',
        'MT' => 'Matera',
        'ME' => 'Messina',
        'MI' => 'Milano',
        'MO' => 'Modena',
        'MB' => 'Monza e Brianza',
        'NA' => 'Napoli',
        'NO' => 'Novara',
        'NU' => 'Nuoro',
        'OT' => 'Olbia-Tempio',
        'OR' => 'Oristano',
        'PD' => 'Padova',
        'PA' => 'Palermo',
        'PR' => 'Parma',
        'PV' => 'Pavia',
        'PG' => 'Perugia',
        'PU' => 'Pesaro e Urbino',
        'PE' => 'Pescara',
        'PC' => 'Piacenza',
        'PI' => 'Pisa',
        'PT' => 'Pistoia',
        'PN' => 'Pordenone',
        'PZ' => 'Potenza',
        'PO' => 'Prato',
        'RG' => 'Ragusa',
        'RA' => 'Ravenna',
        'RC' => 'Reggio Calabria',
        'RE' => 'Reggio Emilia',
        'RI' => 'Rieti',
        'RN' => 'Rimini',
        'RM' => 'Roma',
        'RO' => 'Rovigo',
        'SA' => 'Salerno',
        'VS' => 'Medio Campidano',
        'SS' => 'Sassari',
        'SV' => 'Savona',
        'SI' => 'Siena',
        'SR' => 'Siracusa',
        'SO' => 'Sondrio',
        'TA' => 'Taranto',
        'TE' => 'Teramo',
        'TR' => 'Terni',
        'TO' => 'Torino',
        'OG' => 'Ogliastra',
        'TP' => 'Trapani',
        'TN' => 'Trento',
        'TV' => 'Treviso',
        'TS' => 'Trieste',
        'UD' => 'Udine',
        'VA' => 'Varese',
        'VE' => 'Venezia',
        'VB' => 'Verbano-Cusio-Ossola',
        'VC' => 'Vercelli',
        'VR' => 'Verona',
        'VV' => 'Vibo Valentia',
        'VI' => 'Vicenza',
        'VT' => 'Viterbo',
    );
}

/**
 * Custom Comment Callback
 *
 * @param object $comment Comment object
 * @param array  $args    Comment args
 * @param int    $depth   Comment depth
 */
function caniincasa_custom_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar( $comment, 50 ); ?>
            </div>

            <div class="comment-content-wrapper">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        printf(
                            '<b class="fn">%s</b>',
                            get_comment_author_link()
                        );
                        ?>
                    </div>

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php
                                printf(
                                    esc_html__( '%1$s alle %2$s', 'caniincasa' ),
                                    get_comment_date(),
                                    get_comment_time()
                                );
                                ?>
                            </time>
                        </a>
                    </div>
                </footer>

                <?php if ( '0' === $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation">
                        <?php esc_html_e( 'Il tuo commento è in attesa di moderazione.', 'caniincasa' ); ?>
                    </p>
                <?php endif; ?>

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>

                <div class="comment-reply">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'depth'      => $depth,
                                'max_depth'  => $args['max_depth'],
                                'reply_text' => __( 'Rispondi', 'caniincasa' ),
                            )
                        )
                    );
                    ?>
                </div>
            </div>
        </article>
    <?php
}

/**
 * Get Rating Paws HTML
 * Displays paws (🐾) instead of stars for dog-specific ratings
 *
 * @param float $rating Rating value (1-5, can be decimal like 3.5)
 * @param bool $show_value Show numeric value
 * @param string $label Optional label text
 * @return string HTML output
 */
function caniincasa_get_rating_paws( $rating = 0, $show_value = true, $label = '' ) {
    // Ensure rating is between 0 and 5
    $rating = max( 0, min( 5, floatval( $rating ) ) );
    $rounded = round( $rating * 2 ) / 2; // Round to nearest 0.5

    $output = '<div class="rating-paws">';

    if ( $label ) {
        $output .= '<span class="rating-label">' . esc_html( $label ) . '</span>';
    }

    $output .= '<span class="paws-container" data-rating="' . esc_attr( $rating ) . '">';

    for ( $i = 1; $i <= 5; $i++ ) {
        if ( $i <= $rounded ) {
            // Full paw
            $output .= '<span class="paw filled" aria-label="' . esc_attr__( 'Pieno', 'caniincasa' ) . '">🐾</span>';
        } else {
            // Empty paw
            $output .= '<span class="paw empty" aria-label="' . esc_attr__( 'Vuoto', 'caniincasa' ) . '">🐾</span>';
        }
    }

    $output .= '</span>';

    if ( $show_value ) {
        $output .= ' <span class="rating-value">' . number_format_i18n( $rating, 1 ) . '/5</span>';
    }

    $output .= '</div>';

    return $output;
}

/**
 * Display Rating Paws
 *
 * @param float $rating Rating value (1-5)
 * @param bool $show_value Show numeric value
 * @param string $label Optional label text
 */
function caniincasa_rating_paws( $rating = 0, $show_value = true, $label = '' ) {
    echo caniincasa_get_rating_paws( $rating, $show_value, $label );
}

/**
 * Get Breed Characteristics HTML
 * Displays all breed characteristics with paw ratings
 *
 * @param int $post_id Post ID
 * @return string HTML output
 */
function caniincasa_get_breed_characteristics( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    // Check if ACF is available
    if ( ! function_exists( 'get_field' ) ) {
        return '';
    }

    // Define characteristic groups
    // Usa campi esistenti dove possibile, poi i nuovi
    $characteristics = array(
        'temperamento' => array(
            'title' => __( 'Temperamento & Comportamento', 'caniincasa' ),
            'icon' => '💪',
            'fields' => array(
                'energia_e_livelli_di_attivita' => __( 'Livello Energia', 'caniincasa' ), // Campo esistente
                'affettuosita' => __( 'Affettuosità', 'caniincasa' ), // Campo nuovo
                'vocalita_e_predisposizione_ad_abbaiare' => __( 'Vocalità / Abbaiare', 'caniincasa' ), // Campo esistente
                'socievolezza_cani' => __( 'Socievolezza con Altri Cani', 'caniincasa' ), // Campo nuovo
            ),
        ),
        'adattabilita' => array(
            'title' => __( 'Adattabilità', 'caniincasa' ),
            'icon' => '🏡',
            'fields' => array(
                'adattabilita_appartamento' => __( 'Adattabilità Appartamento', 'caniincasa' ), // Campo nuovo
                'adattabilita_clima_caldo' => __( 'Tolleranza al Caldo', 'caniincasa' ), // Campo esistente
                'adattabilita_clima_freddo' => __( 'Tolleranza al Freddo', 'caniincasa' ), // Campo esistente
                'tolleranza_alla_solitudine' => __( 'Tolleranza Solitudine', 'caniincasa' ), // Campo esistente
            ),
        ),
        'famiglia' => array(
            'title' => __( 'Famiglia & Socialità', 'caniincasa' ),
            'icon' => '👨‍👩‍👧‍👦',
            'fields' => array(
                'compatibilita_con_i_bambini' => __( 'Compatibilità con Bambini', 'caniincasa' ), // Campo esistente
                'tolleranza_estranei' => __( 'Tolleranza verso Estranei', 'caniincasa' ), // Campo nuovo
                'compatibilita_con_altri_animali_domestici' => __( 'Compatibilità Altri Animali', 'caniincasa' ), // Campo esistente
            ),
        ),
        'addestramento' => array(
            'title' => __( 'Addestramento & Cura', 'caniincasa' ),
            'icon' => '🎓',
            'fields' => array(
                'facilita_di_addestramento' => __( 'Facilità Addestramento', 'caniincasa' ), // Campo esistente
                'intelligenza' => __( 'Intelligenza', 'caniincasa' ), // Campo nuovo
                'esigenze_di_esercizio' => __( 'Bisogno di Esercizio', 'caniincasa' ), // Campo esistente
                'facilita_toelettatura' => __( 'Facilità Toelettatura', 'caniincasa' ), // Campo nuovo
                'cura_e_perdita_pelo_' => __( 'Cura e Perdita Pelo', 'caniincasa' ), // Campo esistente
                'predisposizioni_per_la_salute' => __( 'Predisposizioni Salute', 'caniincasa' ), // Campo esistente
            ),
        ),
        'esperienza' => array(
            'title' => __( 'Esperienza & Altri', 'caniincasa' ),
            'icon' => '💰',
            'fields' => array(
                'livello_esperienza_richiesto' => __( 'Livello Esperienza Richiesto', 'caniincasa' ), // Campo nuovo
                'costo_mantenimento' => __( 'Costo Mantenimento', 'caniincasa' ), // Campo nuovo
                'istinti_di_caccia' => __( 'Istinti di Caccia', 'caniincasa' ), // Campo esistente
            ),
        ),
    );

    $output = '<div class="breed-characteristics">';
    $output .= '<h2 class="characteristics-title">' . esc_html__( 'Caratteristiche della Razza', 'caniincasa' ) . '</h2>';

    // Quick summary cards (top characteristics)
    $quick_cards = array(
        'adattabilita_appartamento' => array( 'icon' => '🏠', 'label' => __( 'Appartamento', 'caniincasa' ) ),
        'compatibilita_bambini' => array( 'icon' => '👶', 'label' => __( 'Con Bambini', 'caniincasa' ) ),
        'livello_esperienza_richiesto' => array( 'icon' => '🎓', 'label' => __( 'Esperienza', 'caniincasa' ), 'invert' => true ),
    );

    $output .= '<div class="characteristics-quick-view">';
    $output .= '<h3>' . esc_html__( 'Adatto a Te?', 'caniincasa' ) . '</h3>';
    $output .= '<div class="quick-cards">';

    foreach ( $quick_cards as $field => $data ) {
        $value = get_field( $field, $post_id );
        if ( $value ) {
            // Invert scale for experience (lower is better)
            $display_value = isset( $data['invert'] ) && $data['invert'] ? ( 6 - $value ) : $value;
            $output .= '<div class="quick-card">';
            $output .= '<span class="quick-icon">' . $data['icon'] . '</span>';
            $output .= '<span class="quick-label">' . esc_html( $data['label'] ) . '</span>';
            $output .= caniincasa_get_rating_paws( $display_value, false );
            $output .= '</div>';
        }
    }

    $output .= '</div>'; // .quick-cards
    $output .= '</div>'; // .characteristics-quick-view

    // Detailed characteristics
    foreach ( $characteristics as $group_key => $group ) {
        $output .= '<div class="characteristic-group" data-group="' . esc_attr( $group_key ) . '">';
        $output .= '<h3 class="group-title">';
        $output .= '<span class="group-icon">' . $group['icon'] . '</span> ';
        $output .= esc_html( $group['title'] );
        $output .= '</h3>';
        $output .= '<div class="characteristic-list">';

        foreach ( $group['fields'] as $field_name => $field_label ) {
            $value = get_field( $field_name, $post_id );

            if ( $value !== null && $value !== '' ) {
                $output .= '<div class="characteristic-item" data-field="' . esc_attr( $field_name ) . '">';
                $output .= '<span class="characteristic-name">' . esc_html( $field_label ) . '</span>';
                $output .= caniincasa_get_rating_paws( $value, true );

                // Add text label if available
                $label_text = caniincasa_get_rating_label( $field_name, $value );
                if ( $label_text ) {
                    $output .= '<span class="characteristic-text">' . esc_html( $label_text ) . '</span>';
                }

                $output .= '</div>';
            }
        }

        $output .= '</div>'; // .characteristic-list
        $output .= '</div>'; // .characteristic-group
    }

    // Disclaimer
    $output .= '<div class="characteristics-disclaimer">';
    $output .= '<p><em>' . esc_html__( 'Le valutazioni rappresentano le caratteristiche tipiche della razza. Ogni cane è un individuo e può variare.', 'caniincasa' ) . '</em></p>';
    $output .= '</div>';

    $output .= '</div>'; // .breed-characteristics

    return $output;
}

/**
 * Display Breed Characteristics
 *
 * @param int $post_id Post ID
 */
function caniincasa_breed_characteristics( $post_id = null ) {
    echo caniincasa_get_breed_characteristics( $post_id );
}
