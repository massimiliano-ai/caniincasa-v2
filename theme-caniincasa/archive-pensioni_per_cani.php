<?php
/**
 * Archive Template for Pensioni per Cani (Dog Boarding)
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
                <?php esc_html_e( 'Pensioni per Cani', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova pensioni per cani sicure e accoglienti per lasciare il tuo amico a quattro zampe durante le tue vacanze.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Pensioni', 'caniincasa' ); ?></h2>

                    <form id="pensioni-filter-form" class="filter-form" method="get">

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

                        <!-- Fascia Prezzo Giornaliero -->
                        <div class="filter-group">
                            <label for="filter-prezzo"><?php esc_html_e( 'Tariffa massima (€/giorno)', 'caniincasa' ); ?></label>
                            <input
                                type="number"
                                id="filter-prezzo"
                                name="tariffa_max"
                                class="form-control"
                                min="10"
                                max="100"
                                step="5"
                                placeholder="€"
                                value="<?php echo esc_attr( get_query_var( 'tariffa_max' ) ); ?>"
                            />
                        </div>

                        <!-- Servizi Inclusi -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Servizi inclusi', 'caniincasa' ); ?></label>
                            <div class="checkbox-group checkbox-group--scrollable">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_toelettatura"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_toelettatura' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Toelettatura', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_veterinario"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_veterinario' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Assistenza veterinaria', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_passeggiate"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_passeggiate' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Passeggiate quotidiane', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_addestramento"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_addestramento' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Addestramento', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_webcam"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_webcam' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Webcam per monitoraggio', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_trasporto"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_trasporto' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Servizio trasporto', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Struttura -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Tipo di struttura', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="area_esterna"
                                        value="1"
                                        <?php checked( get_query_var( 'area_esterna' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Area esterna', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="box_interni"
                                        value="1"
                                        <?php checked( get_query_var( 'box_interni' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Box interni', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="climatizzata"
                                        value="1"
                                        <?php checked( get_query_var( 'climatizzata' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Climatizzata', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Disponibilità -->
                        <div class="filter-group">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="posti_disponibili"
                                    value="1"
                                    <?php checked( get_query_var( 'posti_disponibili' ), '1' ); ?>
                                />
                                <span><?php esc_html_e( 'Solo con posti disponibili', 'caniincasa' ); ?></span>
                            </label>
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
                    update_post_caches( $wp_query->posts, 'pensioni_per_cani', true, true );
                    update_object_term_cache( $post_ids, 'pensioni_per_cani' );
                    ?>

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            printf(
                                esc_html( _n( '%d pensione trovata', '%d pensioni trovate', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                        <div class="results-sort">
                            <label for="sort-order" class="sr-only"><?php esc_html_e( 'Ordina per', 'caniincasa' ); ?></label>
                            <select id="sort-order" name="orderby" class="form-control form-control-sm">
                                <option value="date" <?php selected( get_query_var( 'orderby' ), 'date' ); ?>>
                                    <?php esc_html_e( 'Più recenti', 'caniincasa' ); ?>
                                </option>
                                <option value="price-low" <?php selected( get_query_var( 'orderby' ), 'price-low' ); ?>>
                                    <?php esc_html_e( 'Prezzo crescente', 'caniincasa' ); ?>
                                </option>
                                <option value="price-high" <?php selected( get_query_var( 'orderby' ), 'price-high' ); ?>>
                                    <?php esc_html_e( 'Prezzo decrescente', 'caniincasa' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="pensioni-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card pensione-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <?php if ( get_field( 'posti_disponibili' ) ) : ?>
                                        <span class="badge badge--success">✓ Posti disponibili</span>
                                    <?php endif; ?>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Location -->
                                    <?php
                                    $citta = get_field( 'citta' );
                                    $provincia_terms = get_the_terms( get_the_ID(), 'provincia' );
                                    if ( $citta || $provincia_terms ) :
                                    ?>
                                        <div class="pensione-location">
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

                                    <!-- Price & Capacity -->
                                    <div class="pensione-info">
                                        <?php
                                        $tariffa = get_field( 'tariffa_giornaliera' );
                                        $capacita = get_field( 'capacita_massima' );

                                        if ( $tariffa ) :
                                            echo '<div class="info-item price">';
                                            echo '<strong>€' . esc_html( number_format( $tariffa, 0 ) ) . '</strong>/giorno';
                                            echo '</div>';
                                        endif;

                                        if ( $capacita ) :
                                            echo '<div class="info-item">';
                                            echo '<span class="icon">🏠</span> ';
                                            echo esc_html__( 'Max', 'caniincasa' ) . ' ' . esc_html( $capacita ) . ' ' . esc_html__( 'cani', 'caniincasa' );
                                            echo '</div>';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                                    </div>

                                    <!-- Services Icons -->
                                    <div class="pensione-services">
                                        <?php
                                        if ( get_field( 'area_esterna' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Area esterna', 'caniincasa' ) . '">🌳</span>';
                                        endif;
                                        if ( get_field( 'servizio_webcam' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Webcam', 'caniincasa' ) . '">📹</span>';
                                        endif;
                                        if ( get_field( 'servizio_veterinario' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Assistenza veterinaria', 'caniincasa' ) . '">🏥</span>';
                                        endif;
                                        if ( get_field( 'servizio_toelettatura' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Toelettatura', 'caniincasa' ) . '">✂️</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-block">
                                            <?php esc_html_e( 'Visualizza Dettagli', 'caniincasa' ); ?>
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
                        <div class="no-results__icon">🏨</div>
                        <h2><?php esc_html_e( 'Nessuna pensione trovata', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare in un\'altra zona.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
