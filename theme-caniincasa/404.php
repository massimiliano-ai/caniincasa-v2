<?php
/**
 * 404 Error Page Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">
        <div class="error-404">
            <div class="error-404__content">
                <div class="error-404__icon">
                    <span class="error-code">404</span>
                    <span class="error-emoji">🐕</span>
                </div>

                <h1 class="error-404__title">
                    <?php esc_html_e( 'Oops! Pagina non trovata', 'caniincasa' ); ?>
                </h1>

                <p class="error-404__description">
                    <?php esc_html_e( 'La pagina che stai cercando potrebbe essere stata rimossa, rinominata o è temporaneamente non disponibile.', 'caniincasa' ); ?>
                </p>

                <div class="error-404__search">
                    <h2><?php esc_html_e( 'Prova a cercare:', 'caniincasa' ); ?></h2>
                    <?php get_search_form(); ?>
                </div>

                <div class="error-404__actions">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Torna alla Home', 'caniincasa' ); ?>
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline">
                        <?php esc_html_e( 'Torna Indietro', 'caniincasa' ); ?>
                    </a>
                </div>

                <!-- Quick Links -->
                <div class="error-404__links">
                    <h3><?php esc_html_e( 'Link Utili:', 'caniincasa' ); ?></h3>
                    <div class="quick-links-grid">
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'razze_di_cani' ) ); ?>" class="quick-link">
                            <span class="quick-link__icon">🐕</span>
                            <span class="quick-link__label"><?php esc_html_e( 'Razze di Cani', 'caniincasa' ); ?></span>
                        </a>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'allevamenti' ) ); ?>" class="quick-link">
                            <span class="quick-link__icon">🏠</span>
                            <span class="quick-link__label"><?php esc_html_e( 'Allevamenti', 'caniincasa' ); ?></span>
                        </a>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'struttureveterinarie' ) ); ?>" class="quick-link">
                            <span class="quick-link__icon">🏥</span>
                            <span class="quick-link__label"><?php esc_html_e( 'Veterinari', 'caniincasa' ); ?></span>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="quick-link">
                            <span class="quick-link__icon">📝</span>
                            <span class="quick-link__label"><?php esc_html_e( 'Blog', 'caniincasa' ); ?></span>
                        </a>
                    </div>
                </div>

                <!-- Latest Posts -->
                <?php
                $recent_posts = new WP_Query( array(
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                ) );

                if ( $recent_posts->have_posts() ) :
                ?>
                    <div class="error-404__recent">
                        <h3><?php esc_html_e( 'Ultimi Articoli:', 'caniincasa' ); ?></h3>
                        <ul class="recent-posts-list">
                            <?php
                            while ( $recent_posts->have_posts() ) :
                                $recent_posts->the_post();
                                ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <span class="recent-post-thumb">
                                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <span class="recent-post-title"><?php the_title(); ?></span>
                                    </a>
                                </li>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
