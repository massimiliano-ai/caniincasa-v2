<?php
/**
 * Template Name: Registrazione
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

<main id="main-content" class="site-main page-registrazione">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="auth-wrapper">

            <div class="auth-box">

                <div class="auth-header">
                    <h1 class="auth-title">Registrati</h1>
                    <p class="auth-subtitle">Crea il tuo account per accedere a tutti i servizi</p>
                </div>

                <form id="register-form" class="auth-form">

                    <?php wp_nonce_field( 'caniincasa_register_nonce', 'nonce' ); ?>

                    <!-- Nome e Cognome -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome *</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="cognome">Cognome *</label>
                            <input type="text" id="cognome" name="cognome" required>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" name="username" required minlength="4">
                        <small>Minimo 4 caratteri</small>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <!-- Telefono -->
                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="tel" id="telefono" name="telefono" placeholder="+39 ...">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" required minlength="8">
                        <small>Minimo 8 caratteri</small>
                    </div>

                    <!-- Conferma Password -->
                    <div class="form-group">
                        <label for="password_confirm">Conferma Password *</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>

                    <!-- Privacy -->
                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="privacy" id="privacy" required>
                            <span>Accetto la <a href="<?php echo home_url( '/privacy-policy/' ); ?>" target="_blank">Privacy Policy</a> *</span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-full">
                            <span class="btn-text">Registrati</span>
                            <span class="btn-loading" style="display:none;">
                                <span class="spinner"></span> Registrazione...
                            </span>
                        </button>
                    </div>

                    <!-- Messages -->
                    <div class="form-message" id="register-message" style="display:none;"></div>

                </form>

                <div class="auth-footer">
                    <p>Hai già un account? <a href="<?php echo home_url( '/login/' ); ?>">Accedi</a></p>
                </div>

            </div>

            <!-- Benefits Sidebar -->
            <div class="auth-benefits">
                <h3>Vantaggi della registrazione</h3>
                <ul class="benefits-list">
                    <li>
                        <span class="icon">✓</span>
                        <div>
                            <strong>Inserisci annunci</strong>
                            <p>Pubblica cucciolate e annunci di adozione</p>
                        </div>
                    </li>
                    <li>
                        <span class="icon">✓</span>
                        <div>
                            <strong>Vedi contatti</strong>
                            <p>Accedi ai recapiti di allevatori e strutture</p>
                        </div>
                    </li>
                    <li>
                        <span class="icon">✓</span>
                        <div>
                            <strong>Segnala modifiche</strong>
                            <p>Contribuisci a migliorare i contenuti</p>
                        </div>
                    </li>
                    <li>
                        <span class="icon">✓</span>
                        <div>
                            <strong>Salva preferiti</strong>
                            <p>Crea liste di razze e annunci preferiti</p>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</main>

<?php get_footer(); ?>
