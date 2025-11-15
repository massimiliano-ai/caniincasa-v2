<?php
/**
 * Template Name: Login
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Redirect if already logged in
if ( is_user_logged_in() ) {
    wp_redirect( home_url( '/dashboard/' ) );
    exit;
}

get_header();
?>

<main id="main-content" class="site-main page-login">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="auth-wrapper auth-wrapper-simple">

            <div class="auth-box">

                <div class="auth-header">
                    <h1 class="auth-title">Accedi</h1>
                    <p class="auth-subtitle">Benvenuto! Accedi al tuo account</p>
                </div>

                <form id="login-form" class="auth-form">

                    <?php wp_nonce_field( 'caniincasa_login_nonce', 'nonce' ); ?>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username o Email</label>
                        <input type="text" id="username" name="username" required autofocus>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember" value="1">
                            <span>Ricordami</span>
                        </label>
                        <a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-password">Password dimenticata?</a>
                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-full">
                            <span class="btn-text">Accedi</span>
                            <span class="btn-loading" style="display:none;">
                                <span class="spinner"></span> Accesso...
                            </span>
                        </button>
                    </div>

                    <!-- Messages -->
                    <div class="form-message" id="login-message" style="display:none;"></div>

                </form>

                <div class="auth-footer">
                    <p>Non hai un account? <a href="<?php echo home_url( '/registrati/' ); ?>">Registrati ora</a></p>
                </div>

                <!-- Social Login (opzionale) -->
                <!--
                <div class="social-login">
                    <p class="separator"><span>Oppure</span></p>
                    <button class="btn btn-social btn-google">
                        <span class="icon">G</span> Accedi con Google
                    </button>
                    <button class="btn btn-social btn-facebook">
                        <span class="icon">f</span> Accedi con Facebook
                    </button>
                </div>
                -->

            </div>

        </div>

    </div>

</main>

<?php get_footer(); ?>
