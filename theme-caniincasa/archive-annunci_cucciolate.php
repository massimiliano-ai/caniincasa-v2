<?php
/**
 * Archive Template for Annunci Cucciolate (Litter Announcements)
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-annunci">
    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <header class="page-hero">
            <h1 class="page-title">
                <?php esc_html_e( 'Annunci Cucciolate', 'caniincasa' ); ?>
            </h1>
            <p class="page-intro">
                <?php esc_html_e( 'Trova cuccioli disponibili da allevamenti certificati. Scegli la razza e la zona che preferisci.', 'caniincasa' ); ?>
            </p>
        </header>

        <?php
        // Pre-load caches for better performance
        if ( have_posts() ) {
            global $wp_query;
            $post_ids = wp_list_pluck( $wp_query->posts, 'ID' );
            update_post_caches( $wp_query->posts, 'annunci_cucciolate', true, true );
            update_object_term_cache( $post_ids, 'annunci_cucciolate' );
        }
        ?>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                <?php
                if ( have_posts() ) {
                    global $wp_query;
                    printf(
                        esc_html( _n( 'Trovato %d annuncio', 'Trovati %d annunci', $wp_query->found_posts, 'caniincasa' ) ),
                        '<strong>' . number_format_i18n( $wp_query->found_posts ) . '</strong>'
                    );
                }
                ?>
            </p>
        </div>

        <?php if ( have_posts() ) : ?>

            <!-- Annunci List Layout (Horizontal Cards) -->
            <div class="annunci-list-layout">

                <?php while ( have_posts() ) : the_post(); ?>

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
                                $ricerca_offerta = get_field( 'ricerca_offerta' );
                                if ( $ricerca_offerta === 'offerta' ) :
                                ?>
                                    <span class="badge badge-offerta">💼 Offro Cuccioli</span>
                                <?php elseif ( $ricerca_offerta === 'ricerca' ) : ?>
                                    <span class="badge badge-ricerca">🔍 Cerco Cucciolo</span>
                                <?php else : ?>
                                    <span class="badge badge-cucciolate">🐶 Cucciolata</span>
                                <?php endif; ?>
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
                                <?php
                                $data_nascita = get_field( 'data_nascita' );
                                if ( $data_nascita ) :
                                ?>
                                    <span class="annuncio-date"><?php echo esc_html( date_i18n( 'F j, Y', strtotime( $data_nascita ) ) ); ?></span>
                                <?php else: ?>
                                    <span class="annuncio-date"><?php echo get_the_date( 'F j, Y' ); ?></span>
                                <?php endif; ?>
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
                                // Razza
                                $razza = get_field( 'razza' );
                                if ( $razza ):
                                    $razza_nome = is_object( $razza ) ? $razza->post_title : $razza;
                                ?>
                                    <span class="meta-item">
                                        <span class="icon">🐕</span>
                                        <span class="text"><?php echo esc_html( $razza_nome ); ?></span>
                                    </span>
                                <?php endif; ?>
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
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( '← Precedente', 'caniincasa' ),
                'next_text' => __( 'Successivo →', 'caniincasa' ),
            ) );
            ?>

        <?php else : ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">📢</div>
                <h3>Nessun annuncio trovato</h3>
                <p>Non ci sono annunci pubblicati al momento.</p>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
