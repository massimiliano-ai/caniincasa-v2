<?php
/**
 * Archive Template for Canili (Dog Shelters)
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <header class="archive-header">
            <h1 class="archive-title">
                <?php esc_html_e( 'Canili e Rifugi', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova canili e rifugi vicino a te. Adotta un cane e dagli una seconda possibilità di essere felice.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Canili', 'caniincasa' ); ?></h2>

                    <form id="canili-filter-form" class="filter-form" method="get">

                        <!-- Provincia -->
                        <?php
                        $province = get_terms( array(
                            'taxonomy' => 'provincia',
                            'hide_empty' => true,
                        ) );
                        if ( ! empty( $province ) && ! is_wp_error( $province ) ) :
                        ?>
                            <div class="filter-group">
                                <label for="filter-provincia"><?php esc_html_e( 'Provincia', 'caniincasa' ); ?></label>
                                <select id="filter-provincia" name="provincia" class="form-control">
                                    <option value=""><?php esc_html_e( 'Tutte le province', 'caniincasa' ); ?></option>
                                    <?php
                                    $selected_provincia = get_query_var( 'provincia' );
                                    foreach ( $province as $provincia ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $provincia->slug ); ?>" <?php selected( $selected_provincia, $provincia->slug ); ?>>
                                            <?php echo esc_html( $provincia->name ); ?> (<?php echo esc_html( $provincia->count ); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Tipo Struttura -->
                        <div class="filter-group">
                            <label for="filter-tipo"><?php esc_html_e( 'Tipo struttura', 'caniincasa' ); ?></label>
                            <select id="filter-tipo" name="tipo_canile" class="form-control">
                                <option value=""><?php esc_html_e( 'Tutti i tipi', 'caniincasa' ); ?></option>
                                <?php
                                $tipi = array(
                                    'canile-comunale' => 'Canile Comunale',
                                    'rifugio-privato' => 'Rifugio Privato',
                                    'oasi' => 'Oasi per Cani',
                                    'associazione' => 'Associazione',
                                );
                                $selected_tipo = get_query_var( 'tipo_canile' );
                                foreach ( $tipi as $value => $label ) :
                                ?>
                                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_tipo, $value ); ?>>
                                        <?php echo esc_html( $label ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Cani Disponibili -->
                        <div class="filter-group">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="cani_disponibili_adozione"
                                    value="1"
                                    <?php checked( get_query_var( 'cani_disponibili_adozione' ), '1' ); ?>
                                />
                                <span><?php esc_html_e( 'Con cani disponibili per adozione', 'caniincasa' ); ?></span>
                            </label>
                        </div>

                        <!-- Servizi -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Servizi disponibili', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="visite_consentite"
                                        value="1"
                                        <?php checked( get_query_var( 'visite_consentite' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Visite consentite', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="volontariato_accettato"
                                        value="1"
                                        <?php checked( get_query_var( 'volontariato_accettato' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Accetta volontari', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="donazioni_accettate"
                                        value="1"
                                        <?php checked( get_query_var( 'donazioni_accettate' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Accetta donazioni', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="adozione_distanza"
                                        value="1"
                                        <?php checked( get_query_var( 'adozione_distanza' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Adozione a distanza', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary btn-block">
                                <?php esc_html_e( 'Applica Filtri', 'caniincasa' ); ?>
                            </button>
                            <button type="button" id="reset-filters" class="btn btn-outline btn-block">
                                <?php esc_html_e( 'Reset Filtri', 'caniincasa' ); ?>
                            </button>
                        </div>

                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="archive-content">
                <?php if ( have_posts() ) : ?>

                    <?php
                    // Pre-load caches for better performance
                    global $wp_query;
                    $post_ids = wp_list_pluck( $wp_query->posts, 'ID' );
                    update_post_caches( $wp_query->posts, 'canili', true, true );
                    update_object_term_cache( $post_ids, 'canili' );
                    ?>

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            printf(
                                esc_html( _n( '%d canile trovato', '%d canili trovati', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                    </div>

                    <div class="canili-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card canile-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <?php if ( get_field( 'cani_disponibili_adozione' ) ) : ?>
                                        <span class="badge badge--success">♥ Adozioni disponibili</span>
                                    <?php endif; ?>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Location -->
                                    <?php
                                    $indirizzo = get_field( 'indirizzo' );
                                    $citta = get_field( 'citta' );
                                    $provincia_terms = get_the_terms( get_the_ID(), 'provincia' );
                                    if ( $indirizzo || $citta || $provincia_terms ) :
                                    ?>
                                        <div class="canile-location">
                                            <span class="icon">📍</span>
                                            <?php
                                            if ( $citta ) {
                                                echo esc_html( $citta );
                                            }
                                            if ( $provincia_terms && ! is_wp_error( $provincia_terms ) ) {
                                                echo ' (' . esc_html( $provincia_terms[0]->name ) . ')';
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Stats -->
                                    <?php
                                    $cani_ospitati = get_field( 'numero_cani_ospitati' );
                                    if ( $cani_ospitati ) :
                                    ?>
                                        <div class="canile-stats">
                                            <span class="stat">
                                                <strong><?php echo esc_html( $cani_ospitati ); ?></strong>
                                                <?php esc_html_e( 'cani ospitati', 'caniincasa' ); ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </div>

                                    <!-- Services Icons -->
                                    <div class="canile-services">
                                        <?php
                                        if ( get_field( 'visite_consentite' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Visite consentite', 'caniincasa' ) . '">👥</span>';
                                        endif;
                                        if ( get_field( 'volontariato_accettato' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Accetta volontari', 'caniincasa' ) . '">🤝</span>';
                                        endif;
                                        if ( get_field( 'donazioni_accettate' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Accetta donazioni', 'caniincasa' ) . '">💝</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-block">
                                            <?php esc_html_e( 'Scopri di più', 'caniincasa' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( '← Precedente', 'caniincasa' ),
                        'next_text' => __( 'Successivo →', 'caniincasa' ),
                    ) );
                    ?>

                <?php else : ?>

                    <div class="no-results">
                        <div class="no-results__icon">🏠</div>
                        <h2><?php esc_html_e( 'Nessun canile trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare in un\'altra provincia.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
