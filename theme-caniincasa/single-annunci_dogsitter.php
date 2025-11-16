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

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'dogsitter-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
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
                            $tariffa = get_field( 'tariffa_oraria' );
                            $esperienza = get_field( 'esperienza' );
                            $disponibilita = get_field( 'disponibilita_oraria' );
                            ?>

                            <?php if ( $tariffa ) : ?>
                                <div class="info-card info-card--highlight">
                                    <div class="info-card__icon">💰</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Tariffa Oraria', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo '€ ' . esc_html( $tariffa ); ?>/h</div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $disponibilita ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">📅</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Disponibilità', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $disponibilita ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if ( $esperienza ) : ?>
                            <div class="dogsitter-section">
                                <h2><?php esc_html_e( 'Esperienza', 'caniincasa' ); ?></h2>
                                <div class="dogsitter-content">
                                    <?php echo wpautop( esc_html( $esperienza ) ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="dogsitter-single__description">
                            <?php the_content(); ?>
                        </div>

                        <?php
                        $servizi = get_field( 'servizi_offerti' );
                        if ( $servizi && is_array( $servizi ) ) :
                        ?>
                            <div class="servizi-section">
                                <h2><?php esc_html_e( 'Servizi Offerti', 'caniincasa' ); ?></h2>
                                <ul class="servizi-list">
                                    <?php foreach ( $servizi as $servizio ) : ?>
                                        <li><span class="checkmark">✓</span> <?php echo esc_html( $servizio ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
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
