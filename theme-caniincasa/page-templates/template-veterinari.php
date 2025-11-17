<?php
/**
 * Template Name: Veterinari - Griglia
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-veterinari">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'subtitle' => 'Veterinari - Cliniche e Ambulatori',
    ) );
    ?>

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Filtri -->
        <div class="filters-wrapper">
            <form method="get" id="filters-form" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group filter-search">
                        <label for="filter-search">Cerca:</label>
                        <input type="text" id="filter-search" name="search" class="filter-input" placeholder="Cerca per nome..." data-post-type="struttureveterinarie" value="<?php echo esc_attr( isset( $_GET['search'] ) ? $_GET['search'] : '' ); ?>">
                    </div>

                    <div class="filter-group">
                        <label for="filter-provincia">Provincia:</label>
                        <select id="filter-provincia" name="provincia" class="filter-select" data-post-type="struttureveterinarie">
                            <option value="">Tutti</option>
                            <?php
                            // Get all unique province values from ACF field 'provincia_estesa'
                            global $wpdb;
                            $province_values = $wpdb->get_col( "
                                SELECT DISTINCT meta_value
                                FROM {$wpdb->postmeta} pm
                                INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                                WHERE pm.meta_key = 'provincia_estesa'
                                AND pm.meta_value != ''
                                AND p.post_type = 'struttureveterinarie'
                                AND p.post_status = 'publish'
                                ORDER BY pm.meta_value ASC
                            " );

                            $selected_provincia = isset( $_GET['provincia'] ) ? $_GET['provincia'] : '';
                            foreach ( $province_values as $provincia ):
                            ?>
                                <option value="<?php echo esc_attr( $provincia ); ?>" <?php selected( $selected_provincia, $provincia ); ?>>
                                    <?php echo esc_html( $provincia ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="filter-servizi">Servizi Offerti:</label>
                        <select id="filter-servizi" name="servizi" class="filter-select">
                            <option value="">Tutti</option>
                            <?php
                            // Get all unique services from ACF field 'servizi_offerti'
                            $servizi_values = $wpdb->get_col( "
                                SELECT DISTINCT meta_value
                                FROM {$wpdb->postmeta} pm
                                INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                                WHERE pm.meta_key = 'servizi_offerti'
                                AND pm.meta_value != ''
                                AND p.post_type = 'struttureveterinarie'
                                AND p.post_status = 'publish'
                                ORDER BY pm.meta_value ASC
                            " );

                            // Split comma-separated services and get unique values
                            $all_servizi = array();
                            foreach ( $servizi_values as $servizi_string ) {
                                $servizi_array = array_map( 'trim', explode( ',', $servizi_string ) );
                                $all_servizi = array_merge( $all_servizi, $servizi_array );
                            }
                            $all_servizi = array_unique( array_filter( $all_servizi ) );
                            sort( $all_servizi );

                            $selected_servizio = isset( $_GET['servizi'] ) ? $_GET['servizi'] : '';
                            foreach ( $all_servizi as $servizio ):
                            ?>
                                <option value="<?php echo esc_attr( $servizio ); ?>" <?php selected( $selected_servizio, $servizio ); ?>>
                                    <?php echo esc_html( $servizio ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <button type="submit" id="apply-filters" class="btn btn-primary">Filtra</button>
                    </div>

                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <button type="button" id="reset-filters" class="btn btn-outline">Ripristina</button>
                    </div>
                </div>
            </form>
        </div>

        <?php
        // Query per tutte le strutture veterinarie
        // For page templates, check both 'paged' and 'page' query vars
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( $paged < 1 ) {
            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        }
        if ( $paged < 1 ) {
            $paged = 1;
        }

        // Build query args
        $args = array(
            'post_type' => 'struttureveterinarie',
            'post_status' => 'publish',
            'posts_per_page' => 24,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        // Add search filter
        if ( isset( $_GET['search'] ) && ! empty( $_GET['search'] ) ) {
            $args['s'] = sanitize_text_field( $_GET['search'] );
        }

        // Build meta query for ACF filters
        $meta_query = array( 'relation' => 'AND' );

        // Filter by provincia
        if ( isset( $_GET['provincia'] ) && ! empty( $_GET['provincia'] ) ) {
            $meta_query[] = array(
                'key' => 'provincia_estesa',
                'value' => sanitize_text_field( $_GET['provincia'] ),
                'compare' => '=',
            );
        }

        // Filter by servizi offerti
        if ( isset( $_GET['servizi'] ) && ! empty( $_GET['servizi'] ) ) {
            $meta_query[] = array(
                'key' => 'servizi_offerti',
                'value' => sanitize_text_field( $_GET['servizi'] ),
                'compare' => 'LIKE',
            );
        }

        // Add meta query if filters are set
        if ( count( $meta_query ) > 1 ) {
            $args['meta_query'] = $meta_query;
        }

        $veterinari_query = new WP_Query( $args );
        ?>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="loading-spinner" style="display:none;">
            <div class="spinner"></div>
            <p>Caricamento...</p>
        </div>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                Trovate <strong><?php echo $veterinari_query->found_posts; ?></strong> strutture veterinarie
                <?php if ( $veterinari_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $veterinari_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $veterinari_query->have_posts() ): ?>

            <?php
            // Pre-load caches for better performance
            $post_ids = wp_list_pluck( $veterinari_query->posts, 'ID' );
            update_post_caches( $veterinari_query->posts, 'struttureveterinarie', true, true );
            update_object_term_cache( $post_ids, 'struttureveterinarie' );
            ?>

            <!-- Veterinari Grid -->
            <div class="items-grid" id="items-grid">

                <?php while ( $veterinari_query->have_posts() ): $veterinari_query->the_post(); ?>

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
                            // Servizi veterinari
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
                            <?php endif; ?>

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
                                            echo esc_html( $indirizzo );
                                            if ( $localita ) echo ', ';
                                        }
                                        if ( $localita ) echo esc_html( $localita );
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Orari apertura badge
                            $orari = get_field( 'orari_apertura' );
                            $h24 = get_field( 'servizio_h24' );
                            if ( $h24 ):
                            ?>
                                <div class="item-badge">
                                    <span class="badge badge-success">⏰ Aperto 24/7</span>
                                </div>
                            <?php elseif ( $orari ): ?>
                                <div class="item-info">
                                    <span class="icon">🕐</span>
                                    <span class="text"><?php echo esc_html( wp_trim_words( $orari, 5, '...' ) ); ?></span>
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
            <?php if ( $veterinari_query->max_num_pages > 1 ): ?>
                <div class="pagination-wrapper">
                    <?php
                    echo caniincasa_get_pagination_with_filters( array(
                        'total' => $veterinari_query->max_num_pages,
                        'current' => max( 1, $paged ),
                    ) );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">🏥</div>
                <h3>Nessuna struttura veterinaria trovata</h3>
                <p>Non ci sono strutture veterinarie pubblicate al momento.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
