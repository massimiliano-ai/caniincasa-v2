<?php
/**
 * Template Name: Allevamenti - Griglia
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-allevamenti">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'subtitle' => 'Allevamenti',
    ) );
    ?>

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Filtri Zona e Razze -->
        <div class="filters-wrapper">
            <h3 class="filters-title">Filtra allevamenti</h3>
            <form id="filtri-allevamenti-form" method="GET">
                <div class="filters-row">
                    <div class="filter-group">
                        <label for="filter-provincia">Provincia:</label>
                        <select id="filter-provincia" name="filter_provincia" class="filter-select" data-post-type="allevamenti">
                            <option value="">Tutte le province</option>
                            <?php
                            // Get all unique province values from ACF field 'desprovincia'
                            global $wpdb;
                            $province_values = $wpdb->get_col( "
                                SELECT DISTINCT pm.meta_value
                                FROM {$wpdb->posts} p
                                INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                                WHERE pm.meta_key = 'desprovincia'
                                AND p.post_type = 'allevamenti'
                                AND p.post_status = 'publish'
                                AND pm.meta_value != ''
                                ORDER BY pm.meta_value ASC
                            " );

                            $selected_provincia = isset( $_GET['filter_provincia'] ) ? $_GET['filter_provincia'] : '';

                            foreach ( $province_values as $provincia ):
                                if ( ! empty( $provincia ) ):
                            ?>
                                <option value="<?php echo esc_attr( $provincia ); ?>" <?php selected( $selected_provincia, $provincia ); ?>>
                                    <?php echo esc_html( $provincia ); ?>
                                </option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="filter-razza">Razza:</label>
                        <select id="filter-razza" name="filter_razza" class="filter-select">
                            <option value="">Tutte le razze</option>
                            <?php
                            // Get all razze_allevamenti taxonomy terms
                            $razze_terms = get_terms( array(
                                'taxonomy' => 'razze_allevamenti',
                                'hide_empty' => true,
                                'orderby' => 'name',
                                'order' => 'ASC',
                            ) );

                            $selected_razza = isset( $_GET['filter_razza'] ) ? $_GET['filter_razza'] : '';

                            if ( ! empty( $razze_terms ) && ! is_wp_error( $razze_terms ) ):
                                foreach ( $razze_terms as $razza_term ):
                            ?>
                                <option value="<?php echo esc_attr( $razza_term->slug ); ?>" <?php selected( $selected_razza, $razza_term->slug ); ?>>
                                    <?php echo esc_html( $razza_term->name ); ?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary">Filtra</button>
                    </div>

                    <div class="filter-group">
                        <button type="button" id="reset-filters" class="btn btn-outline">Ripristina filtri</button>
                    </div>
                </div>
            </form>
        </div>

        <?php
        // Query per tutti gli allevamenti
        // For page templates, check both 'paged' and 'page' query vars
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( $paged < 1 ) {
            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        }
        if ( $paged < 1 ) {
            $paged = 1;
        }

        $args = array(
            'post_type' => 'allevamenti',
            'post_status' => 'publish',
            'posts_per_page' => 12,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        // Apply filters
        $meta_query = array( 'relation' => 'AND' );
        $tax_query = array( 'relation' => 'AND' );

        // Filter by provincia (ACF field)
        if ( isset( $_GET['filter_provincia'] ) && ! empty( $_GET['filter_provincia'] ) ) {
            $meta_query[] = array(
                'key' => 'desprovincia',
                'value' => sanitize_text_field( $_GET['filter_provincia'] ),
                'compare' => '='
            );
        }

        // Filter by razza (taxonomy)
        if ( isset( $_GET['filter_razza'] ) && ! empty( $_GET['filter_razza'] ) ) {
            $tax_query[] = array(
                'taxonomy' => 'razze_allevamenti',
                'field' => 'slug',
                'terms' => sanitize_text_field( $_GET['filter_razza'] )
            );
        }

        if ( count( $meta_query ) > 1 ) {
            $args['meta_query'] = $meta_query;
        }

        if ( count( $tax_query ) > 1 ) {
            $args['tax_query'] = $tax_query;
        }

        $allevamenti_query = new WP_Query( $args );

        // Pre-carica term cache e meta cache per migliorare performance
        if ( $allevamenti_query->have_posts() ) {
            $post_ids = wp_list_pluck( $allevamenti_query->posts, 'ID' );
            update_post_caches( $allevamenti_query->posts, 'allevamenti', true, true );
            update_object_term_cache( $post_ids, 'allevamenti' );
        }
        ?>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="loading-spinner" style="display:none;">
            <div class="spinner"></div>
            <p>Caricamento...</p>
        </div>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                Trovati <strong><?php echo $allevamenti_query->found_posts; ?></strong> allevamenti
                <?php if ( $allevamenti_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $allevamenti_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $allevamenti_query->have_posts() ): ?>

            <!-- Allevamenti Grid -->
            <div class="items-grid" id="items-grid">

                <?php while ( $allevamenti_query->have_posts() ): $allevamenti_query->the_post(); ?>

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
                            // Località e Provincia (usando campi ACF)
                            $localita = get_field( 'localita' ); // Comune
                            $provincia = get_field( 'desprovincia' ) ?: get_field( 'provincia_' );

                            if ( $localita || $provincia ):
                            ?>
                                <div class="item-location">
                                    <span class="icon">📍</span>
                                    <span class="text">
                                        <?php
                                        $location_parts = array();
                                        if ( $localita ) {
                                            $location_parts[] = esc_html( $localita );
                                        }
                                        if ( $provincia ) {
                                            $location_parts[] = '(' . esc_html( $provincia ) . ')';
                                        }
                                        echo implode( ' ', $location_parts );
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Razze allevate
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
            <?php if ( $allevamenti_query->max_num_pages > 1 ): ?>
                <div class="pagination-wrapper">
                    <?php
                    echo caniincasa_get_pagination_with_filters( array(
                        'total' => $allevamenti_query->max_num_pages,
                        'current' => max( 1, $paged ),
                    ) );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">🏠</div>
                <h3>Nessun allevamento trovato</h3>
                <p>Non ci sono allevamenti pubblicati al momento.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
