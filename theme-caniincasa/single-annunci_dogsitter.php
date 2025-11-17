<?php
/**
 * Single Annunci Dogsitter Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <?php
        // Hero Section
        caniincasa_page_hero( array(
            'subtitle' => 'Annuncio Dogsitter',
        ) );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'dogsitter-single' ); ?>>

            <div class="container">

                <!-- Breadcrumbs Boxed -->
                <div class="breadcrumbs-box">
                    <?php caniincasa_breadcrumbs(); ?>
                </div>
                <div class="dogsitter-single__layout">

                    <!-- Main Content -->
                    <div class="dogsitter-single__content">

                        <header class="dogsitter-single__header">
                            <h1 class="dogsitter-single__title"><?php the_title(); ?></h1>

                            <?php
                            $zona = get_field( 'zona_disponibilita' );
                            if ( $zona ) :
                            ?>
                                <div class="dogsitter-zona">
                                    <i class="icon-location">📍</i> <?php echo esc_html( $zona ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="dogsitter-info-grid">
                            <?php
                            $tariffe = get_field( 'tariffe' );
                            $esperienza = get_field( 'esperienza' );
                            $disponibilita = get_field( 'disponibilita' );
                            $servizi = get_field( 'servizi' );
                            $taglie = get_field( 'taglie' );
                            $comune = get_field( 'comune' );
                            $zona = get_field( 'zona_disponibilita' );
                            $province = wp_get_post_terms( get_the_ID(), 'provincia' );

                            // Map esperienza labels
                            $esperienza_labels = array(
                                'meno-1' => 'Meno di 1 anno',
                                '1-3' => '1-3 anni',
                                '3-5' => '3-5 anni',
                                '5-10' => '5-10 anni',
                                'oltre-10' => 'Oltre 10 anni',
                            );
                            ?>

                            <!-- Tariffa Oraria -->
                            <?php if ( $tariffe ) : ?>
                                <div class="info-card info-card--highlight">
                                    <div class="info-card__icon">💰</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Tariffa Oraria', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo '€ ' . esc_html( $tariffe ) . '/h'; ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Esperienza -->
                            <?php if ( $esperienza ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">⭐</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Esperienza', 'caniincasa' ); ?></div>
                                        <div class="info-card__value">
                                            <?php echo esc_html( isset( $esperienza_labels[$esperienza] ) ? $esperienza_labels[$esperienza] : $esperienza ); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Comune -->
                            <?php if ( $comune ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">📍</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Comune', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $comune ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Provincia -->
                            <?php if ( ! empty( $province ) && ! is_wp_error( $province ) ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">🗺️</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Provincia', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $province[0]->name ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Zona Disponibilità -->
                            <?php if ( $zona ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">🌍</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Zona di Servizio', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $zona ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Data Pubblicazione -->
                            <div class="info-card">
                                <div class="info-card__icon">📆</div>
                                <div class="info-card__content">
                                    <div class="info-card__label"><?php esc_html_e( 'Pubblicato il', 'caniincasa' ); ?></div>
                                    <div class="info-card__value"><?php echo get_the_date( 'd/m/Y' ); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Disponibilità Oraria -->
                        <?php if ( $disponibilita && is_array( $disponibilita ) && ! empty( $disponibilita ) ) : ?>
                            <div class="dogsitter-section">
                                <h2><?php esc_html_e( 'Disponibilità Oraria', 'caniincasa' ); ?></h2>
                                <div class="badges-list">
                                    <?php
                                    $disp_labels = array(
                                        'mattina' => '🌅 Mattina',
                                        'pomeriggio' => '☀️ Pomeriggio',
                                        'sera' => '🌆 Sera',
                                        'weekend' => '📅 Weekend',
                                        'notturno' => '🌙 Notturno',
                                    );
                                    foreach ( $disponibilita as $disp ) :
                                    ?>
                                        <span class="badge badge-info">
                                            <?php echo esc_html( isset( $disp_labels[$disp] ) ? $disp_labels[$disp] : $disp ); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Servizi Offerti -->
                        <?php if ( $servizi && is_array( $servizi ) && ! empty( $servizi ) ) : ?>
                            <div class="servizi-section">
                                <h2><?php esc_html_e( 'Servizi Offerti', 'caniincasa' ); ?></h2>
                                <ul class="servizi-list">
                                    <?php
                                    $servizi_labels = array(
                                        'passeggiate' => 'Passeggiate',
                                        'pensione' => 'Pensione a casa mia',
                                        'domicilio' => 'Assistenza a domicilio',
                                        'toelettatura' => 'Toelettatura base',
                                        'trasporto' => 'Trasporto',
                                        'addestramento' => 'Addestramento base',
                                    );
                                    foreach ( $servizi as $servizio ) :
                                    ?>
                                        <li>
                                            <span class="checkmark">✓</span>
                                            <?php echo esc_html( isset( $servizi_labels[$servizio] ) ? $servizi_labels[$servizio] : $servizio ); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Taglie Accettate -->
                        <?php if ( $taglie && is_array( $taglie ) && ! empty( $taglie ) ) : ?>
                            <div class="dogsitter-section">
                                <h2><?php esc_html_e( 'Taglie Accettate', 'caniincasa' ); ?></h2>
                                <div class="badges-list">
                                    <?php
                                    $taglie_labels = array(
                                        'piccola' => '🐕 Piccola (fino a 10kg)',
                                        'media' => '🐕 Media (10-25kg)',
                                        'grande' => '🐕 Grande (25-45kg)',
                                        'gigante' => '🐕 Gigante (oltre 45kg)',
                                    );
                                    foreach ( $taglie as $taglia ) :
                                    ?>
                                        <span class="badge badge-success">
                                            <?php echo esc_html( isset( $taglie_labels[$taglia] ) ? $taglie_labels[$taglia] : $taglia ); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Descrizione -->
                        <div class="dogsitter-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Form Contatto -->
                        <?php if ( is_user_logged_in() && get_the_author_meta( 'ID' ) != get_current_user_id() ) : ?>
                            <div class="annuncio-contact-section">
                                <h2 class="section-title">💬 Contatta il Dogsitter</h2>
                                <p class="contact-intro">Interessato ai servizi? Invia un messaggio diretto al dogsitter.</p>

                                <form id="contact-annuncio-form" class="contact-form">
                                    <?php wp_nonce_field( 'caniincasa_send_message', 'message_nonce' ); ?>
                                    <input type="hidden" name="annuncio_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="tipo_annuncio" value="annunci_dogsitter">

                                    <div class="form-group">
                                        <label for="messaggio">Il Tuo Messaggio *</label>
                                        <textarea id="messaggio" name="messaggio" rows="6" required
                                                  placeholder="Scrivi qui il tuo messaggio..."></textarea>
                                        <small class="form-help">Descrivi le tue esigenze e fai le tue domande</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="telefono">Telefono di Contatto (opzionale)</label>
                                        <input type="tel" id="telefono" name="telefono"
                                               placeholder="Es: 333 1234567">
                                        <small class="form-help">Se vuoi essere ricontattato telefonicamente</small>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary">
                                            📤 Invia Messaggio
                                        </button>
                                    </div>

                                    <div id="contact-response" class="form-response"></div>
                                </form>
                            </div>
                        <?php elseif ( ! is_user_logged_in() ) : ?>
                            <div class="annuncio-contact-section">
                                <div class="login-prompt">
                                    <h3>💬 Vuoi contattare il dogsitter?</h3>
                                    <p>Per inviare un messaggio devi essere registrato e loggato.</p>
                                    <a href="<?php echo wp_login_url( get_permalink() ); ?>" class="btn btn-primary">
                                        Accedi o Registrati
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div><!-- .dogsitter-single__content -->

                    <!-- Sidebar -->
                    <aside class="dogsitter-single__sidebar">

                        <div class="contact-box">
                            <h3 class="contact-box__title"><?php esc_html_e( 'Contatti', 'caniincasa' ); ?></h3>
                            <ul class="contact-list">
                                <?php
                                $telefono = get_field( 'contatto_telefono' );
                                if ( $telefono ) :
                                ?>
                                    <li class="contact-phone">
                                        <i class="icon-phone">📞</i>
                                        <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $telefono ) ); ?>">
                                            <?php echo esc_html( $telefono ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $email = get_field( 'contatto_email' );
                                if ( $email ) :
                                ?>
                                    <li class="contact-email">
                                        <i class="icon-email">✉️</i>
                                        <?php echo esc_html( $email ); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>

                    </aside><!-- .dogsitter-single__sidebar -->

                </div><!-- .dogsitter-single__layout -->

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
