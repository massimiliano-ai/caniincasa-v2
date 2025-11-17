<?php
/**
 * Template Name: Chi Siamo
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>

        <!-- Hero Section -->
        <?php
        caniincasa_page_hero( array(
            'subtitle' => 'Chi Siamo',
            'use_excerpt' => false,
        ) );
        ?>

        <div class="container">

            <?php caniincasa_breadcrumbs(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content page-about' ); ?>>

                <!-- Main Content -->
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="about-image-section">
                        <?php the_post_thumbnail( 'full', array( 'class' => 'about-featured-image' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="about-content-section">
                    <?php the_content(); ?>
                </div>

                <!-- Mission & Values -->
                <div class="about-values-section">
                    <h2 class="section-title"><?php esc_html_e( 'I Nostri Valori', 'caniincasa' ); ?></h2>

                    <div class="values-grid">
                        <div class="value-card">
                            <div class="value-card__icon">❤️</div>
                            <h3 class="value-card__title"><?php esc_html_e( 'Amore per gli Animali', 'caniincasa' ); ?></h3>
                            <p class="value-card__description">
                                <?php esc_html_e( 'La passione per i cani guida ogni nostro progetto e iniziativa.', 'caniincasa' ); ?>
                            </p>
                        </div>

                        <div class="value-card">
                            <div class="value-card__icon">✅</div>
                            <h3 class="value-card__title"><?php esc_html_e( 'Affidabilità', 'caniincasa' ); ?></h3>
                            <p class="value-card__description">
                                <?php esc_html_e( 'Informazioni verificate e allevatori certificati per la tua sicurezza.', 'caniincasa' ); ?>
                            </p>
                        </div>

                        <div class="value-card">
                            <div class="value-card__icon">🎓</div>
                            <h3 class="value-card__title"><?php esc_html_e( 'Educazione', 'caniincasa' ); ?></h3>
                            <p class="value-card__description">
                                <?php esc_html_e( 'Condividiamo conoscenza per una convivenza felice con i tuoi cani.', 'caniincasa' ); ?>
                            </p>
                        </div>

                        <div class="value-card">
                            <div class="value-card__icon">🤝</div>
                            <h3 class="value-card__title"><?php esc_html_e( 'Comunità', 'caniincasa' ); ?></h3>
                            <p class="value-card__description">
                                <?php esc_html_e( 'Creiamo una rete di appassionati e professionisti del settore cinofilo.', 'caniincasa' ); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="about-stats-section">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-card__number">300+</div>
                            <div class="stat-card__label"><?php esc_html_e( 'Razze di Cani', 'caniincasa' ); ?></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-card__number">1000+</div>
                            <div class="stat-card__label"><?php esc_html_e( 'Allevamenti', 'caniincasa' ); ?></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-card__number">500+</div>
                            <div class="stat-card__label"><?php esc_html_e( 'Articoli', 'caniincasa' ); ?></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-card__number">50K+</div>
                            <div class="stat-card__label"><?php esc_html_e( 'Utenti al Mese', 'caniincasa' ); ?></div>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="about-cta-section">
                    <div class="cta-box">
                        <h2><?php esc_html_e( 'Unisciti alla Nostra Community', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Scopri tutto sul mondo dei cani e trova il compagno perfetto per te.', 'caniincasa' ); ?></p>
                        <div class="cta-buttons">
                            <a href="<?php echo esc_url( get_post_type_archive_link( 'razze_di_cani' ) ); ?>" class="btn btn-primary btn-lg">
                                <?php esc_html_e( 'Esplora le Razze', 'caniincasa' ); ?>
                            </a>
                            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contatti' ) ) ); ?>" class="btn btn-outline btn-lg">
                                <?php esc_html_e( 'Contattaci', 'caniincasa' ); ?>
                            </a>
                        </div>
                    </div>
                </div>

            </article>

        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
