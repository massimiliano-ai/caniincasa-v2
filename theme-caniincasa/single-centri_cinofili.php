<?php
/**
 * Single Centri Cinofili Template
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
            'subtitle' => 'Centro Cinofilo',
        ) );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'centro-single' ); ?>>

            <div class="container">

                <?php caniincasa_breadcrumbs(); ?>

                <div class="centro-single__layout">

                    <!-- Main Content -->
                    <div class="centro-single__content">

                        <header class="centro-single__header">

                            <?php
                            $citta = get_field( 'citta' );
                            $provincia = get_field( 'provincia' );
                            if ( $citta || $provincia ) :
                            ?>
                                <div class="centro-single__location">
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
                                <div class="centro-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="centro-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Corsi Disponibili -->
                        <?php
                        $corsi = get_field( 'corsi_disponibili' );
                        if ( $corsi && is_array( $corsi ) ) :
                        ?>
                            <div class="corsi-section">
                                <h2><?php esc_html_e( 'Corsi Disponibili', 'caniincasa' ); ?></h2>
                                <div class="corsi-grid">
                                    <?php foreach ( $corsi as $corso ) : ?>
                                        <div class="corso-card">
                                            <h3 class="corso-card__title"><?php echo esc_html( $corso['nome_corso'] ?? '' ); ?></h3>
                                            <div class="corso-card__description">
                                                <?php echo wpautop( esc_html( $corso['descrizione'] ?? '' ) ); ?>
                                            </div>
                                            <?php if ( ! empty( $corso['durata'] ) ) : ?>
                                                <div class="corso-card__info">
                                                    <strong><?php esc_html_e( 'Durata:', 'caniincasa' ); ?></strong>
                                                    <?php echo esc_html( $corso['durata'] ); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $corso['costo'] ) ) : ?>
                                                <div class="corso-card__price">
                                                    <?php echo '€ ' . number_format( $corso['costo'], 0, ',', '.' ); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div><!-- .centro-single__content -->

                    <!-- Sidebar -->
                    <aside class="centro-single__sidebar">

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
                                    <?php esc_html_e( 'Chiama Ora', 'caniincasa' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>

                    </aside><!-- .centro-single__sidebar -->

                </div><!-- .centro-single__layout -->

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
