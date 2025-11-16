<?php
/**
 * Template Name: Canili - Griglia
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-canili">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'subtitle' => 'Canili',
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
                    <input
                        type="text"
                        id="filter-provincia"
                        class="filter-search"
                        list="province-list"
                        placeholder="Cerca provincia..."
                        data-post-type="canili"
                        autocomplete="off"
                    >
                    <datalist id="province-list">
                        <?php
                        // Get all unique province values from ACF fields 'provincia_estesa' (fallback to 'provincia')
                        global $wpdb;
                        $province_values = $wpdb->get_col( "
                            SELECT DISTINCT COALESCE(NULLIF(pm1.meta_value, ''), pm2.meta_value) as provincia
                            FROM {$wpdb->posts} p
                            LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id AND pm1.meta_key = 'provincia_estesa'
                            LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id AND pm2.meta_key = 'provincia'
                            WHERE p.post_type = 'canili'
                            AND p.post_status = 'publish'
                            AND (pm1.meta_value != '' OR pm2.meta_value != '')
                            ORDER BY provincia ASC
                        " );

                        foreach ( $province_values as $provincia ):
                            if ( ! empty( $provincia ) ):
                        ?>
                            <option value="<?php echo esc_attr( $provincia ); ?>">
                        <?php endif; endforeach; ?>
                    </datalist>
                </div>
                <button id="reset-filters" class="btn btn-outline">Ripristina filtri</button>
            </div>
        </div>

        <?php
        // Query per tutti i canili
        // For page templates, use 'page' instead of 'paged'
        $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        if ( $paged == 0 ) {
            $paged = 1;
        }

        $args = array(
            'post_type' => 'canili',
            'post_status' => 'publish',
            'posts_per_page' => 12,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $canili_query = new WP_Query( $args );
        ?>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="loading-spinner" style="display:none;">
            <div class="spinner"></div>
            <p>Caricamento...</p>
        </div>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                Trovati <strong><?php echo $canili_query->found_posts; ?></strong> canili
                <?php if ( $canili_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $canili_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $canili_query->have_posts() ): ?>

            <!-- Canili Grid -->
            <div class="items-grid" id="items-grid">

                <?php while ( $canili_query->have_posts() ): $canili_query->the_post(); ?>

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
                            // Provincia (try taxonomy first, then ACF field)
                            $province = wp_get_post_terms( get_the_ID(), 'provincia' );
                            $provincia_text = get_field( 'provincia' ) ?: get_field( 'provincia_estesa' );

                            if ( ! empty( $province ) && ! is_wp_error( $province ) ):
                            ?>
                                <div class="item-location">
                                    <span class="icon">📍</span>
                                    <span class="text"><?php echo esc_html( $province[0]->name ); ?></span>
                                </div>
                            <?php elseif ( $provincia_text ): ?>
                                <div class="item-location">
                                    <span class="icon">📍</span>
                                    <span class="text"><?php echo esc_html( $provincia_text ); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Indirizzo e Comune
                            $indirizzo = get_field( 'indirizzo' );
                            $comune = get_field( 'comune' );
                            if ( $indirizzo || $comune ):
                            ?>
                                <div class="item-address">
                                    <span class="icon">🏠</span>
                                    <span class="text">
                                        <?php
                                        if ( $indirizzo ) {
                                            echo esc_html( $indirizzo );
                                            if ( $comune ) echo ', ';
                                        }
                                        if ( $comune ) echo esc_html( $comune );
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

                            <?php
                            // Riferimento
                            $riferimento = get_field( 'riferimento' );
                            if ( $riferimento ):
                            ?>
                                <div class="item-info">
                                    <span class="icon">👤</span>
                                    <span class="text"><strong>Riferimento:</strong> <?php echo esc_html( $riferimento ); ?></span>
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
            <?php if ( $canili_query->max_num_pages > 1 ): ?>
                <div class="pagination-wrapper">
                    <?php
                    echo caniincasa_get_pagination_with_filters( array(
                        'total' => $canili_query->max_num_pages,
                        'current' => max( 1, $paged ),
                    ) );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">🏠</div>
                <h3>Nessun canile trovato</h3>
                <p>Non ci sono canili pubblicati al momento.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
