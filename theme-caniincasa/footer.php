<?php
/**
 * The footer template file
 *
 * @package CaninCasa
 * @since 1.0.0
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="footer-widgets">
                    <div class="footer-widget-area">
                        <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar( 'footer-1' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="footer-widget-area">
                        <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar( 'footer-2' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="footer-widget-area">
                        <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                            <div class="footer-widget">
                                <?php dynamic_sidebar( 'footer-3' ); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div><!-- .footer-widgets -->
            <?php endif; ?>

            <div class="site-info">
                <div class="footer-info-left">
                    <p class="footer-copyright">
                        <?php
                        $copyright = get_theme_mod( 'caniincasa_footer_copyright', '© ' . date( 'Y' ) . ' CaninCasa.it - Tutti i diritti riservati' );
                        echo wp_kses_post( $copyright );
                        ?>
                    </p>
                </div>

                <div class="footer-info-right">
                    <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Navigation', 'caniincasa' ); ?>">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'footer',
                            'menu_id'        => 'footer-menu',
                            'menu_class'     => 'footer-menu',
                            'container'      => false,
                            'depth'          => 1,
                            'fallback_cb'    => false,
                        ) );
                        ?>
                    </nav>

                    <p class="contact-info">
                        <a href="mailto:info@caniincasa.it">info@caniincasa.it</a>
                    </p>
                </div>
            </div><!-- .site-info -->
        </div><!-- .container -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
