<?php
/**
 * Template Name: Centri Cinofili - Griglia
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-centri-cinofili">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'subtitle' => 'Centri Cinofili',
    ) );
    ?>

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Filtri Zona -->
        <div class="filters-wrapper">
            <h3 class="filters-title">Filtra per zona</h3>
            <div class="filters-row">
                <div class="filter-group">
                    <label for="filter-provincia">Provincia:</label>
                    <select id="filter-provincia" class="filter-select" data-post-type="centri_cinofili">
                        <option value="">Tutte le province</option>
                        <?php
                        // Get all unique province values from ACF field 'provincia'
                        global $wpdb;
                        $province_values = $wpdb->get_col( "
                            SELECT DISTINCT meta_value
                            FROM {$wpdb->postmeta} pm
                            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                            WHERE pm.meta_key = 'provincia'
                            AND pm.meta_value != ''
                            AND p.post_type = 'centri_cinofili'
                            AND p.post_status = 'publish'
                            ORDER BY pm.meta_value ASC
                        " );

                        foreach ( $province_values as $provincia ):
                        ?>
                            <option value="<?php echo esc_attr( $provincia ); ?>">
                                <?php echo esc_html( $provincia ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button id="reset-filters" class="btn btn-outline">Ripristina filtri</button>
            </div>
        </div>

        <?php
        // Query per tutti i centri cinofili
        // For page templates, check both 'paged' and 'page' query vars
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( $paged < 1 ) {
            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        }
        if ( $paged < 1 ) {
            $paged = 1;
        }

        $args = array(
            'post_type' => 'centri_cinofili',
            'post_status' => 'publish',
            'posts_per_page' => 24,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $centri_query = new WP_Query( $args );
        ?>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="loading-spinner" style="display:none;">
            <div class="spinner"></div>
            <p>Caricamento...</p>
        </div>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                Trovati <strong><?php echo $centri_query->found_posts; ?></strong> centri cinofili
                <?php if ( $centri_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $centri_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $centri_query->have_posts() ): ?>

            <!-- Centri Cinofili Grid -->
            <div class="items-grid" id="items-grid">

                <?php while ( $centri_query->have_posts() ): $centri_query->the_post(); ?>

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
                            // Tipologia corsi/servizi
                            $corsi = get_field( 'corsi_offerti' );
                            if ( $corsi ):
                            ?>
                                <div class="item-courses">
                                    <span class="icon">🎓</span>
                                    <span class="text"><?php echo esc_html( wp_trim_words( $corsi, 5, '...' ) ); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Certificazioni/Qualifiche
                            $certificazioni = get_field( 'certificazioni' );
                            if ( $certificazioni ):
                            ?>
                                <div class="item-badge">
                                    <span class="badge badge-info">✓ Certificato</span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Indirizzo
                            $indirizzo = get_field( 'indirizzo' );
                            $citta = get_field( 'citta' );
                            if ( $indirizzo || $citta ):
                            ?>
                                <div class="item-address">
                                    <span class="icon">🏠</span>
                                    <span class="text">
                                        <?php
                                        if ( $indirizzo ) {
                                            echo esc_html( wp_trim_words( $indirizzo, 5, '' ) );
                                            if ( $citta ) echo ', ';
                                        }
                                        if ( $citta ) echo esc_html( $citta );
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Excerpt
                            if ( has_excerpt() ):
                            ?>
                                <div class="item-excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
                                </div>
                            <?php endif; ?>

                            <!-- View More Button -->
                            <a href="<?php the_permalink(); ?>" class="btn-view-more">
                                Visualizza dettagli
                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <?php if ( $centri_query->max_num_pages > 1 ): ?>
                <div class="pagination-wrapper">
                    <?php
                    echo caniincasa_get_pagination_with_filters( array(
                        'total' => $centri_query->max_num_pages,
                        'current' => max( 1, $paged ),
                    ) );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">🎓</div>
                <h3>Nessun centro cinofilo trovato</h3>
                <p>Non ci sono centri cinofili pubblicati al momento.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
