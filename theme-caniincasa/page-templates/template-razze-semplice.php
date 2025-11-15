<?php
/**
 * Template Name: Razze - Griglia Semplice
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-razze-simple">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Hero Section -->
        <div class="razze-hero">
            <h1 class="page-title">
                <?php echo esc_html( get_the_title() ); ?>
            </h1>
            <?php if ( get_the_content() ): ?>
                <div class="page-intro">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        // Query per tutte le razze
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type' => 'razze_di_cani',
            'post_status' => 'publish',
            'posts_per_page' => 24,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $razze_query = new WP_Query( $args );
        ?>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                Trovate <strong><?php echo $razze_query->found_posts; ?></strong> razze
                <?php if ( $razze_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $razze_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $razze_query->have_posts() ): ?>

            <!-- Razze Grid -->
            <div class="razze-grid-simple">

                <?php while ( $razze_query->have_posts() ): $razze_query->the_post(); ?>

                    <a href="<?php the_permalink(); ?>" class="razza-card-simple">

                        <!-- Image -->
                        <div class="razza-card-image">
                            <?php if ( has_post_thumbnail() ): ?>
                                <?php the_post_thumbnail( 'medium_large', array(
                                    'loading' => 'lazy',
                                    'alt' => get_the_title()
                                ) ); ?>
                            <?php else: ?>
                                <div class="no-image">
                                    <span class="icon">🐕</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Content -->
                        <div class="razza-card-content">
                            <h3 class="razza-card-title">
                                <?php the_title(); ?>
                            </h3>

                            <?php
                            // Meta info opzionale
                            $energia = get_field( 'energia_e_livelli_di_attivita' );
                            $appartamento = get_field( 'adattabilita_appartamento' );
                            $origine = get_field( 'nazione_origine' );

                            if ( $energia || $appartamento || $origine ):
                            ?>
                                <div class="razza-card-meta">
                                    <?php if ( $energia ): ?>
                                        <span class="meta-item">
                                            <span class="icon">⚡</span>
                                            <span class="value"><?php echo number_format( $energia, 1 ); ?></span>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ( $appartamento ): ?>
                                        <span class="meta-item">
                                            <span class="icon">🏠</span>
                                            <span class="value"><?php echo number_format( $appartamento, 1 ); ?></span>
                                        </span>
                                    <?php endif; ?>

                                    <?php if ( $origine ): ?>
                                        <span class="meta-item meta-origin">
                                            <span class="icon">🌍</span>
                                            <span class="value"><?php echo esc_html( wp_trim_words( $origine, 3, '...' ) ); ?></span>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </a>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <?php if ( $razze_query->max_num_pages > 1 ): ?>
                <div class="razze-pagination">
                    <?php
                    echo paginate_links( array(
                        'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, $paged ),
                        'total' => $razze_query->max_num_pages,
                        'prev_text' => '&laquo; Precedente',
                        'next_text' => 'Successiva &raquo;',
                        'type' => 'list',
                    ) );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-razze">
                <div class="no-razze-icon">🐕</div>
                <h3>Nessuna razza trovata</h3>
                <p>Non ci sono razze pubblicate al momento. Importa le razze per visualizzarle qui.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
