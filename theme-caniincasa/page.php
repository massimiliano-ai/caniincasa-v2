<?php
/**
 * The template for displaying all pages
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

        <?php
        // Hero Section
        caniincasa_page_hero( array(
            'use_excerpt' => true,
        ) );
        ?>

        <div class="container">

            <?php caniincasa_breadcrumbs(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'featured-image' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="page-entry-content">
                    <?php
                    the_content();

                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pagine:', 'caniincasa' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div>

                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <div class="page-comments">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>

            </article>

        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
