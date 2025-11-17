<?php
/**
 * Template Name: Annunci - Griglia
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-annunci">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'subtitle' => 'Annunci',
    ) );
    ?>

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <?php
        // Query per tutti gli annunci
        // For page templates, check both 'paged' and 'page' query vars
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( $paged < 1 ) {
            $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
        }
        if ( $paged < 1 ) {
            $paged = 1;
        }

        // Query per tutti i tipi di annunci
        $post_types = array( 'annunci_cucciolate', 'annunci_dogsitter' );

        $args = array(
            'post_type' => $post_types,
            'post_status' => 'publish',
            'posts_per_page' => 24,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $annunci_query = new WP_Query( $args );

        // Pre-carica term cache e meta cache per migliorare performance
        if ( $annunci_query->have_posts() ) {
            $post_ids = wp_list_pluck( $annunci_query->posts, 'ID' );
            // Pre-carica cache per entrambi i post types
            foreach ( $post_types as $post_type ) {
                update_post_caches( $annunci_query->posts, $post_type, true, true );
                update_object_term_cache( $post_ids, $post_type );
            }
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
                Trovati <strong><?php echo $annunci_query->found_posts; ?></strong> annunci
                <?php if ( $annunci_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $annunci_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $annunci_query->have_posts() ): ?>

            <!-- Annunci List Layout (Horizontal Cards) -->
            <div class="annunci-list-layout" id="items-grid">

                <?php while ( $annunci_query->have_posts() ): $annunci_query->the_post(); ?>

                    <article class="annuncio-horizontal-card">

                        <!-- Image Section (Left) -->
                        <div class="annuncio-image-wrapper">
                            <?php if ( has_post_thumbnail() ): ?>
                                <a href="<?php the_permalink(); ?>" class="annuncio-image-link">
                                    <?php the_post_thumbnail( 'large', array(
                                        'loading' => 'lazy',
                                        'alt' => get_the_title(),
                                        'class' => 'annuncio-featured-image'
                                    ) ); ?>
                                </a>
                            <?php else: ?>
                                <div class="annuncio-placeholder-image">
                                    <span class="placeholder-icon">📢</span>
                                </div>
                            <?php endif; ?>

                            <!-- Badge Tipo Annuncio -->
                            <div class="annuncio-type-badge">
                                <?php
                                $post_type = get_post_type();
                                if ( $post_type === 'annunci_cucciolate' ) {
                                    echo '<span class="badge badge-cucciolate">🐶 Cucciolata</span>';
                                } elseif ( $post_type === 'annunci_dogsitter' ) {
                                    echo '<span class="badge badge-dogsitter">🦴 Dogsitter</span>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Content Section (Right) -->
                        <div class="annuncio-content-wrapper">

                            <h2 class="annuncio-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <!-- Meta Info -->
                            <div class="annuncio-meta">
                                <span class="annuncio-date"><?php echo get_the_date( 'F j, Y' ); ?></span>
                            </div>

                            <!-- Description -->
                            <div class="annuncio-description">
                                <?php
                                if ( has_excerpt() ) {
                                    echo wp_trim_words( get_the_excerpt(), 30, '...' );
                                } else {
                                    echo wp_trim_words( get_the_content(), 30, '...' );
                                }
                                ?>
                            </div>

                            <!-- Additional Meta -->
                            <div class="annuncio-additional-meta">
                                <?php
                                // Provincia
                                $province = wp_get_post_terms( get_the_ID(), 'provincia' );
                                if ( ! empty( $province ) && ! is_wp_error( $province ) ):
                                ?>
                                    <span class="meta-item">
                                        <span class="icon">📍</span>
                                        <span class="text"><?php echo esc_html( $province[0]->name ); ?></span>
                                    </span>
                                <?php endif; ?>

                                <?php
                                // Razza (per cucciolate)
                                if ( get_post_type() === 'annunci_cucciolate' ):
                                    $razza = get_field( 'razza' );
                                    if ( $razza ):
                                ?>
                                    <span class="meta-item">
                                        <span class="icon">🐕</span>
                                        <span class="text"><?php echo esc_html( $razza ); ?></span>
                                    </span>
                                <?php endif; endif; ?>
                            </div>

                            <!-- Learn More Link -->
                            <a href="<?php the_permalink(); ?>" class="annuncio-learn-more">
                                Learn more
                            </a>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <?php if ( $annunci_query->max_num_pages > 1 ): ?>
                <div class="pagination-wrapper">
                    <?php
                    echo caniincasa_get_pagination_with_filters( array(
                        'total' => $annunci_query->max_num_pages,
                        'current' => max( 1, $paged ),
                    ), array() );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">📢</div>
                <h3>Nessun annuncio trovato</h3>
                <p>Non ci sono annunci pubblicati al momento con i filtri selezionati.</p>
                <?php if ( is_user_logged_in() ): ?>
                    <a href="<?php echo esc_url( home_url( '/inserisci-annuncio/' ) ); ?>" class="btn btn-primary">
                        Pubblica un annuncio
                    </a>
                <?php endif; ?>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
