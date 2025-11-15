<?php
/**
 * Single FAQ Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'faq-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="faq-single__content">

                    <header class="faq-single__header">
                        <h1 class="faq-single__question"><?php the_title(); ?></h1>
                    </header>

                    <div class="faq-single__answer">
                        <?php the_content(); ?>
                    </div>

                    <!-- Related FAQs -->
                    <?php
                    $related = caniincasa_get_related_posts( get_the_ID(), 5 );
                    if ( $related ) :
                    ?>
                        <div class="related-faqs">
                            <h2><?php esc_html_e( 'Altre Domande Frequenti', 'caniincasa' ); ?></h2>
                            <ul class="faq-list">
                                <?php
                                while ( $related->have_posts() ) :
                                    $related->the_post();
                                    ?>
                                    <li class="faq-item">
                                        <a href="<?php the_permalink(); ?>" class="faq-link">
                                            <span class="faq-icon">❓</span>
                                            <span class="faq-question"><?php the_title(); ?></span>
                                        </a>
                                    </li>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div><!-- .faq-single__content -->

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
