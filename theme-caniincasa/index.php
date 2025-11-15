<?php
/**
 * The main template file
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        <div class="content-area">
            <?php
            if ( have_posts() ) :

                // Start the Loop
                while ( have_posts() ) :
                    the_post();

                    get_template_part( 'template-parts/content', get_post_type() );

                endwhile;

                // Pagination
                the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '&laquo; Previous', 'caniincasa' ),
                    'next_text' => __( 'Next &raquo;', 'caniincasa' ),
                ) );

            else :

                get_template_part( 'template-parts/content', 'none' );

            endif;
            ?>
        </div><!-- .content-area -->
    </div><!-- .container -->
</main><!-- #main-content -->

<?php
get_footer();
