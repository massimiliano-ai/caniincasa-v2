<?php
/**
 * Homepage Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main homepage">

    <!-- Hero Section -->
    <section class="hero hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero__title hero-title">
                    <?php echo esc_html( get_theme_mod( 'caniincasa_hero_title', __( 'Benvenuto su CaninCasa.it', 'caniincasa' ) ) ); ?>
                </h1>
                <p class="hero__subtitle hero-subtitle">
                    <?php echo esc_html( get_theme_mod( 'caniincasa_hero_subtitle', __( 'Tutto quello che devi sapere sui cani', 'caniincasa' ) ) ); ?>
                </p>
                <div class="hero__cta hero-actions">
                    <a href="<?php echo esc_url( get_theme_mod( 'caniincasa_hero_button_url', get_post_type_archive_link( 'razze_di_cani' ) ) ); ?>" class="btn btn-primary btn-lg">
                        <?php echo esc_html( get_theme_mod( 'caniincasa_hero_button_text', __( 'Scopri di più', 'caniincasa' ) ) ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'allevamenti' ) ); ?>" class="btn btn-secondary btn-lg">
                        <?php esc_html_e( 'Trova un Allevamento', 'caniincasa' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Access Features -->
    <section class="features-section">
        <div class="container">
            <div class="grid grid-4">
                <div class="feature-card">
                    <div class="feature-card__icon">🐕</div>
                    <h3 class="feature-card__title"><?php esc_html_e( 'Database Razze', 'caniincasa' ); ?></h3>
                    <p class="feature-card__description">
                        <?php esc_html_e( 'Scopri tutte le razze canine con schede complete', 'caniincasa' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'razze_di_cani' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'Esplora', 'caniincasa' ); ?>
                    </a>
                </div>

                <div class="feature-card">
                    <div class="feature-card__icon">🏠</div>
                    <h3 class="feature-card__title"><?php esc_html_e( 'Allevamenti', 'caniincasa' ); ?></h3>
                    <p class="feature-card__description">
                        <?php esc_html_e( 'Trova allevamenti certificati vicino a te', 'caniincasa' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'allevamenti' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'Cerca', 'caniincasa' ); ?>
                    </a>
                </div>

                <div class="feature-card">
                    <div class="feature-card__icon">🏥</div>
                    <h3 class="feature-card__title"><?php esc_html_e( 'Veterinari', 'caniincasa' ); ?></h3>
                    <p class="feature-card__description">
                        <?php esc_html_e( 'Trova cliniche veterinarie e pronto soccorso', 'caniincasa' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'struttureveterinarie' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'Trova', 'caniincasa' ); ?>
                    </a>
                </div>

                <div class="feature-card">
                    <div class="feature-card__icon">🎓</div>
                    <h3 class="feature-card__title"><?php esc_html_e( 'Centri Cinofili', 'caniincasa' ); ?></h3>
                    <p class="feature-card__description">
                        <?php esc_html_e( 'Addestramento e corsi per cani', 'caniincasa' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'centri_cinofili' ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'Scopri', 'caniincasa' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Breed -->
    <?php
    $featured_razza_args = array(
        'post_type'      => 'razze_di_cani',
        'posts_per_page' => 1,
        'orderby'        => 'rand',
    );
    $featured_razza = new WP_Query( $featured_razza_args );

    if ( $featured_razza->have_posts() ) :
        while ( $featured_razza->have_posts() ) : $featured_razza->the_post();
    ?>
        <section class="featured-razza-section">
            <div class="container">
                <h2 class="section-title">
                    <?php esc_html_e( 'Razza in Evidenza', 'caniincasa' ); ?>
                </h2>
                <div class="featured-razza">
                    <div class="featured-razza__image">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'caniincasa-featured' );
                        }
                        ?>
                    </div>
                    <div class="featured-razza__content">
                        <h3 class="featured-razza__title"><?php the_title(); ?></h3>
                        <div class="featured-razza__excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                            <?php esc_html_e( 'Scopri di più', 'caniincasa' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    <?php
        endwhile;
        wp_reset_postdata();
    endif;
    ?>

    <!-- Latest Blog Posts -->
    <?php
    $blog_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    );
    $blog_query = new WP_Query( $blog_args );

    if ( $blog_query->have_posts() ) :
    ?>
        <section class="blog-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">
                        <?php esc_html_e( 'Ultimi Articoli dal Blog', 'caniincasa' ); ?>
                    </h2>
                    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="btn btn-outline">
                        <?php esc_html_e( 'Tutti gli Articoli', 'caniincasa' ); ?>
                    </a>
                </div>

                <div class="grid grid-3">
                    <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
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

                                <div class="card-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="card-meta">
                                    <span class="post-card__date">
                                        <?php echo get_the_date(); ?>
                                    </span>
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
            </div>
        </section>
    <?php
    endif;
    wp_reset_postdata();
    ?>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="grid grid-2">
                <div class="cta-card">
                    <div class="cta-card__icon">🐾</div>
                    <h3 class="cta-card__title">
                        <?php esc_html_e( 'Vuoi proporre una cucciolata o una adozione?', 'caniincasa' ); ?>
                    </h3>
                    <p class="cta-card__text">
                        <?php esc_html_e( 'Contattaci per aggiungere il tuo annuncio al nostro database', 'caniincasa' ); ?>
                    </p>
                    <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn">
                        <?php esc_html_e( 'Scrivici!', 'caniincasa' ); ?>
                    </a>
                </div>

                <div class="cta-card">
                    <div class="cta-card__icon">📋</div>
                    <h3 class="cta-card__title">
                        <?php esc_html_e( 'Sei il proprietario di un allevamento o struttura?', 'caniincasa' ); ?>
                    </h3>
                    <p class="cta-card__text">
                        <?php esc_html_e( 'Aggiungi o aggiorna le tue informazioni nel nostro database', 'caniincasa' ); ?>
                    </p>
                    <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn">
                        <?php esc_html_e( 'Contattaci', 'caniincasa' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
