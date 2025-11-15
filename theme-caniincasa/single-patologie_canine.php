<?php
/**
 * Single Patologie Canine Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'patologia-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="patologia-single__layout">

                    <!-- Main Content -->
                    <div class="patologia-single__content">

                        <!-- Header -->
                        <header class="patologia-single__header">
                            <h1 class="patologia-single__title"><?php the_title(); ?></h1>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="patologia-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Description -->
                        <div class="patologia-single__description">
                            <?php the_content(); ?>
                        </div>

                    </div><!-- .patologia-single__content -->

                    <!-- Sidebar -->
                    <aside class="patologia-single__sidebar">

                        <!-- Info Box -->
                        <div class="info-box info-box--warning">
                            <h3 class="info-box__title">⚠️ <?php esc_html_e( 'Attenzione', 'caniincasa' ); ?></h3>
                            <p><?php esc_html_e( 'Le informazioni contenute in questa pagina sono a scopo informativo. Consulta sempre il tuo veterinario per una diagnosi accurata e un trattamento appropriato.', 'caniincasa' ); ?></p>
                        </div>

                        <!-- CTA Veterinari -->
                        <div class="cta-card cta-card--small">
                            <h4><?php esc_html_e( 'Trova un Veterinario', 'caniincasa' ); ?></h4>
                            <p><?php esc_html_e( 'Cerca una struttura veterinaria vicino a te', 'caniincasa' ); ?></p>
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'struttureveterinarie' ) ); ?>" class="btn btn-sm">
                                <?php esc_html_e( 'Cerca', 'caniincasa' ); ?>
                            </a>
                        </div>

                    </aside><!-- .patologia-single__sidebar -->

                </div><!-- .patologia-single__layout -->

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
