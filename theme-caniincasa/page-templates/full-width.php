<?php
/**
 * Template Name: Full Width (Larghezza Intera)
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content page-content--full-width' ); ?>>

                <header class="page-header page-header--centered">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if ( has_excerpt() ) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="page-featured-image page-featured-image--large">
                        <?php the_post_thumbnail( 'full', array( 'class' => 'featured-image' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="page-entry-content page-entry-content--wide">
                    <?php
                    the_content();

                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pagine:', 'caniincasa' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
