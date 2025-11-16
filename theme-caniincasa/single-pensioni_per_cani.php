<?php
/**
 * Single Pensioni per Cani Template
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
            'subtitle' => 'Pensione per Cani',
        ) );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'pensione-single' ); ?>>

            <div class="container">

                <?php caniincasa_breadcrumbs(); ?>

                <div class="pensione-single__layout">

                    <!-- Main Content -->
                    <div class="pensione-single__content">

                        <header class="pensione-single__header">

                            <?php
                            $citta = get_field( 'citta' );
                            $provincia = get_field( 'provincia' );
                            if ( $citta || $provincia ) :
                            ?>
                                <div class="pensione-single__location">
                                    <i class="icon-location">📍</i>
                                    <?php
                                    if ( $citta ) {
                                        echo esc_html( $citta );
                                    }
                                    if ( $provincia ) {
                                        echo $citta ? ' (' . esc_html( $provincia ) . ')' : esc_html( $provincia );
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="pensione-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="pensione-info-grid">
                            <?php
                            $tariffa = get_field( 'tariffa_giornaliera' );
                            $capienza = get_field( 'capienza_massima' );
                            ?>

                            <?php if ( $tariffa ) : ?>
                                <div class="info-card info-card--highlight">
                                    <div class="info-card__icon">💰</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Tariffa Giornaliera', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo '€ ' . esc_html( $tariffa ); ?>/giorno</div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $capienza ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">🏠</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Capienza Massima', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $capienza ); ?> <?php esc_html_e( 'cani', 'caniincasa' ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="pensione-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Servizi Inclusi -->
                        <?php
                        $servizi = get_field( 'servizi_inclusi' );
                        if ( $servizi && is_array( $servizi ) ) :
                        ?>
                            <div class="servizi-section">
                                <h2><?php esc_html_e( 'Servizi Inclusi', 'caniincasa' ); ?></h2>
                                <ul class="servizi-list">
                                    <?php foreach ( $servizi as $servizio ) : ?>
                                        <li><span class="checkmark">✓</span> <?php echo esc_html( $servizio ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Foto Struttura -->
                        <?php
                        $foto_struttura = get_field( 'foto_struttura' );
                        if ( $foto_struttura ) :
                        ?>
                            <div class="gallery-section">
                                <h2><?php esc_html_e( 'Foto della Struttura', 'caniincasa' ); ?></h2>
                                <div class="gallery-grid">
                                    <?php foreach ( $foto_struttura as $image ) : ?>
                                        <div class="gallery-item">
                                            <img src="<?php echo esc_url( $image['sizes']['caniincasa-card'] ); ?>"
                                                 alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                                 loading="lazy">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div><!-- .pensione-single__content -->

                    <!-- Sidebar -->
                    <aside class="pensione-single__sidebar">

                        <div class="contact-box">
                            <h3 class="contact-box__title"><?php esc_html_e( 'Contatti', 'caniincasa' ); ?></h3>
                            <ul class="contact-list">
                                <?php
                                $telefono = get_field( 'telefono' );
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
                                $email = get_field( 'email' );
                                if ( $email ) :
                                ?>
                                    <li class="contact-email">
                                        <i class="icon-email">✉️</i>
                                        <a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
                                            <?php echo esc_html( $email ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $sito_web = get_field( 'sito_web' );
                                if ( $sito_web ) :
                                ?>
                                    <li class="contact-web">
                                        <i class="icon-web">🌐</i>
                                        <a href="<?php echo esc_url( $sito_web ); ?>" target="_blank" rel="noopener">
                                            <?php esc_html_e( 'Visita il sito', 'caniincasa' ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                $indirizzo = get_field( 'indirizzo' );
                                if ( $indirizzo && $citta ) :
                                ?>
                                    <li class="contact-location">
                                        <i class="icon-location">📍</i>
                                        <?php echo esc_html( $indirizzo . ', ' . $citta ); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <?php if ( $telefono ) : ?>
                                <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $telefono ) ); ?>" class="btn btn-primary btn-block">
                                    <?php esc_html_e( 'Prenota Ora', 'caniincasa' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>

                    </aside><!-- .pensione-single__sidebar -->

                </div><!-- .pensione-single__layout -->

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
