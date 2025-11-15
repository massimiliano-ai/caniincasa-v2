<?php
/**
 * Search Results Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <header class="search-header">
            <h1 class="search-title">
                <?php
                printf(
                    esc_html__( 'Risultati ricerca per: %s', 'caniincasa' ),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            <?php if ( have_posts() ) : ?>
                <p class="search-count">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html( _n( '%d risultato trovato', '%d risultati trovati', $wp_query->found_posts, 'caniincasa' ) ),
                        number_format_i18n( $wp_query->found_posts )
                    );
                    ?>
                </p>
            <?php endif; ?>
        </header>

        <div class="search-layout">
            <div class="search-content">
                <?php if ( have_posts() ) : ?>

                    <div class="search-results">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            $post_type = get_post_type();
                            ?>
                            <article class="search-result-item">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="search-result__image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'caniincasa-thumbnail' ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="search-result__content">
                                    <div class="search-result__meta">
                                        <?php
                                        $post_type_obj = get_post_type_object( $post_type );
                                        if ( $post_type_obj ) :
                                        ?>
                                            <span class="post-type-badge">
                                                <?php echo esc_html( $post_type_obj->labels->singular_name ); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="search-result__title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <div class="search-result__excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="search-result__link">
                                        <?php esc_html_e( 'Visualizza →', 'caniincasa' ); ?>
                                    </a>
                                </div>
                            </article>
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
                        <h2><?php esc_html_e( 'Nessun risultato trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a cercare con parole chiave diverse o più generiche.', 'caniincasa' ); ?></p>

                        <!-- Search Form -->
                        <div class="search-form-wrapper">
                            <?php get_search_form(); ?>
                        </div>

                        <!-- Suggestions -->
                        <div class="search-suggestions">
                            <h3><?php esc_html_e( 'Potresti essere interessato a:', 'caniincasa' ); ?></h3>
                            <ul class="suggestions-list">
                                <li><a href="<?php echo esc_url( get_post_type_archive_link( 'razze_di_cani' ) ); ?>"><?php esc_html_e( 'Tutte le Razze di Cani', 'caniincasa' ); ?></a></li>
                                <li><a href="<?php echo esc_url( get_post_type_archive_link( 'allevamenti' ) ); ?>"><?php esc_html_e( 'Allevamenti', 'caniincasa' ); ?></a></li>
                                <li><a href="<?php echo esc_url( get_post_type_archive_link( 'struttureveterinarie' ) ); ?>"><?php esc_html_e( 'Veterinari', 'caniincasa' ); ?></a></li>
                                <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'caniincasa' ); ?></a></li>
                            </ul>
                        </div>
                    </div>

                <?php endif; ?>
            </div>

            <aside class="search-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>

    </div>
</main>

<?php get_footer(); ?>
