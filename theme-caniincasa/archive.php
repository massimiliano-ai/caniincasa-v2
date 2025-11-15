<?php
/**
 * Archive Template
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
            <?php
            the_archive_title( '<h1 class="archive-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <div class="archive-layout">
            <div class="archive-content">
                <?php if ( have_posts() ) : ?>

                    <div class="posts-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card post-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <?php
                                    $categories = get_the_category();
                                    if ( ! empty( $categories ) ) :
                                    ?>
                                        <a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="post-card__category">
                                            <?php echo esc_html( $categories[0]->name ); ?>
                                        </a>
                                    <?php endif; ?>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <div class="card-meta">
                                        <span class="post-card__date">
                                            <?php echo get_the_date(); ?>
                                        </span>
                                    </div>

                                    <div class="card-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                            <?php esc_html_e( 'Leggi tutto', 'caniincasa' ); ?>
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
                        <h2><?php esc_html_e( 'Nessun contenuto trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Non ci sono articoli da visualizzare in questo archivio.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

            <aside class="archive-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>

    </div>
</main>

<?php get_footer(); ?>
