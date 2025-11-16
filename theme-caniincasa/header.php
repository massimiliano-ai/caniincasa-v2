<?php
/**
 * The header template file
 *
 * @package CaninCasa
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link sr-only" href="#main-content">
        <?php esc_html_e( 'Skip to content', 'caniincasa' ); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-inner">
                <div class="site-branding">
                    <?php
                    if ( has_custom_logo() ) :
                        the_custom_logo();
                    else :
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                            ?>
                            <p class="site-description"><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'caniincasa' ); ?>">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="sr-only"><?php esc_html_e( 'Menu', 'caniincasa' ); ?></span>
                        <span class="hamburger-icon"></span>
                    </button>
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ) );
                    ?>
                </nav><!-- #site-navigation -->

                <!-- User Actions -->
                <div class="header-user-actions">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( home_url( '/dashboard/' ) ); ?>" class="user-link user-dashboard">
                            <span class="icon">👤</span>
                            <span class="text"><?php esc_html_e( 'Dashboard', 'caniincasa' ); ?></span>
                        </a>
                        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="user-link user-logout">
                            <span class="icon">🚪</span>
                            <span class="text"><?php esc_html_e( 'Esci', 'caniincasa' ); ?></span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>" class="user-link user-login">
                            <span class="icon">🔐</span>
                            <span class="text"><?php esc_html_e( 'Accedi', 'caniincasa' ); ?></span>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/registrati/' ) ); ?>" class="user-link user-register btn-primary">
                            <span class="icon">✨</span>
                            <span class="text"><?php esc_html_e( 'Registrati', 'caniincasa' ); ?></span>
                        </a>
                    <?php endif; ?>
                </div><!-- .header-user-actions -->
            </div><!-- .header-inner -->
        </div><!-- .container -->
    </header><!-- #masthead -->
