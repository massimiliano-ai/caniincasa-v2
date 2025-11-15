<?php
/**
 * Template Name: Contatti
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

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content page-contatti' ); ?>>

                <header class="page-header page-header--centered">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if ( has_excerpt() ) : ?>
                        <div class="page-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="contatti-layout">

                    <!-- Contact Form -->
                    <div class="contatti-form-section">
                        <div class="card">
                            <div class="card-content">
                                <h2><?php esc_html_e( 'Invia un Messaggio', 'caniincasa' ); ?></h2>

                                <?php
                                // Check if Contact Form 7 is active
                                if ( function_exists( 'wpcf7' ) ) :
                                    // Display Contact Form 7 shortcode
                                    // User will need to replace 123 with their actual form ID
                                    echo do_shortcode( '[contact-form-7 id="123" title="Modulo di contatto"]' );
                                else :
                                    // Fallback simple contact form
                                    ?>
                                    <form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                                        <input type="hidden" name="action" value="caniincasa_contact_form">
                                        <?php wp_nonce_field( 'caniincasa_contact_form', 'contact_nonce' ); ?>

                                        <div class="form-group">
                                            <label for="contact-name"><?php esc_html_e( 'Nome e Cognome', 'caniincasa' ); ?> <span class="required">*</span></label>
                                            <input type="text" id="contact-name" name="contact_name" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact-email"><?php esc_html_e( 'Email', 'caniincasa' ); ?> <span class="required">*</span></label>
                                            <input type="email" id="contact-email" name="contact_email" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact-phone"><?php esc_html_e( 'Telefono', 'caniincasa' ); ?></label>
                                            <input type="tel" id="contact-phone" name="contact_phone" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="contact-subject"><?php esc_html_e( 'Oggetto', 'caniincasa' ); ?> <span class="required">*</span></label>
                                            <input type="text" id="contact-subject" name="contact_subject" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact-message"><?php esc_html_e( 'Messaggio', 'caniincasa' ); ?> <span class="required">*</span></label>
                                            <textarea id="contact-message" name="contact_message" class="form-control" rows="6" required></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="checkbox-label">
                                                <input type="checkbox" name="contact_privacy" required>
                                                <span><?php esc_html_e( 'Accetto la', 'caniincasa' ); ?> <a href="<?php echo esc_url( get_privacy_policy_url() ); ?>"><?php esc_html_e( 'Privacy Policy', 'caniincasa' ); ?></a> <span class="required">*</span></span>
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <?php esc_html_e( 'Invia Messaggio', 'caniincasa' ); ?>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="contatti-info-section">

                        <!-- Contact Details Card -->
                        <div class="card contact-info-card">
                            <div class="card-content">
                                <h3><?php esc_html_e( 'Informazioni di Contatto', 'caniincasa' ); ?></h3>

                                <div class="contact-info-list">
                                    <div class="contact-info-item">
                                        <span class="icon">📧</span>
                                        <div class="info-content">
                                            <strong><?php esc_html_e( 'Email', 'caniincasa' ); ?></strong>
                                            <a href="mailto:info@caniincasa.it">info@caniincasa.it</a>
                                        </div>
                                    </div>

                                    <div class="contact-info-item">
                                        <span class="icon">📞</span>
                                        <div class="info-content">
                                            <strong><?php esc_html_e( 'Telefono', 'caniincasa' ); ?></strong>
                                            <a href="tel:+39123456789">+39 123 456 789</a>
                                        </div>
                                    </div>

                                    <div class="contact-info-item">
                                        <span class="icon">📍</span>
                                        <div class="info-content">
                                            <strong><?php esc_html_e( 'Indirizzo', 'caniincasa' ); ?></strong>
                                            <p>Via Example 123<br>00100 Roma, Italia</p>
                                        </div>
                                    </div>

                                    <div class="contact-info-item">
                                        <span class="icon">🕒</span>
                                        <div class="info-content">
                                            <strong><?php esc_html_e( 'Orari', 'caniincasa' ); ?></strong>
                                            <p>Lun-Ven: 9:00 - 18:00<br>Sab: 9:00 - 13:00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Card -->
                        <div class="card social-media-card">
                            <div class="card-content">
                                <h3><?php esc_html_e( 'Seguici sui Social', 'caniincasa' ); ?></h3>

                                <div class="social-links">
                                    <a href="#" class="social-link social-link--facebook" target="_blank" rel="noopener">
                                        <span class="icon">📘</span> Facebook
                                    </a>
                                    <a href="#" class="social-link social-link--instagram" target="_blank" rel="noopener">
                                        <span class="icon">📷</span> Instagram
                                    </a>
                                    <a href="#" class="social-link social-link--twitter" target="_blank" rel="noopener">
                                        <span class="icon">🐦</span> Twitter
                                    </a>
                                    <a href="#" class="social-link social-link--youtube" target="_blank" rel="noopener">
                                        <span class="icon">📹</span> YouTube
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Link -->
                        <div class="card faq-link-card">
                            <div class="card-content">
                                <h3><?php esc_html_e( 'Hai domande?', 'caniincasa' ); ?></h3>
                                <p><?php esc_html_e( 'Consulta le nostre FAQ per trovare risposte immediate alle domande più frequenti.', 'caniincasa' ); ?></p>
                                <a href="<?php echo esc_url( get_post_type_archive_link( 'faq' ) ); ?>" class="btn btn-outline btn-block">
                                    <?php esc_html_e( 'Vai alle FAQ', 'caniincasa' ); ?>
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

                <?php if ( get_the_content() ) : ?>
                    <div class="page-entry-content">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
