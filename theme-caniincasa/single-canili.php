<?php
/**
 * Single Canili Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'canile-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="canile-single__layout">

                    <!-- Main Content -->
                    <div class="canile-single__content">

                        <!-- Header -->
                        <header class="canile-single__header">
                            <h1 class="canile-single__title"><?php the_title(); ?></h1>

                            <?php
                            $citta = get_field( 'citta' );
                            $provincia = get_field( 'provincia' );
                            if ( $citta || $provincia ) :
                            ?>
                                <div class="canile-single__location">
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
                                <div class="canile-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Tipo Struttura Badge -->
                        <?php
                        $tipo_struttura = get_field( 'tipo_struttura' );
                        if ( $tipo_struttura ) :
                        ?>
                            <div class="struttura-badge">
                                <span class="badge badge-info">
                                    <?php echo esc_html( ucfirst( $tipo_struttura ) ); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <div class="canile-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Cani Disponibili -->
                        <?php
                        $cani_disponibili = get_field( 'cani_disponibili' );
                        if ( $cani_disponibili ) :
                        ?>
                            <div class="info-highlight">
                                <div class="info-highlight__icon">🐕</div>
                                <div class="info-highlight__content">
                                    <h3><?php esc_html_e( 'Cani Disponibili per Adozione', 'caniincasa' ); ?></h3>
                                    <p class="info-highlight__value"><?php echo esc_html( $cani_disponibili ); ?> <?php esc_html_e( 'cani', 'caniincasa' ); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Orari Visite -->
                        <?php
                        $orari_visite = get_field( 'orari_visite' );
                        if ( $orari_visite ) :
                        ?>
                            <div class="orari-section">
                                <h2><?php esc_html_e( 'Orari per le Visite', 'caniincasa' ); ?></h2>
                                <div class="orari-content">
                                    <?php
                                    if ( is_array( $orari_visite ) ) :
                                        // Se è un repeater ACF
                                        foreach ( $orari_visite as $orario ) :
                                            ?>
                                            <div class="orario-item">
                                                <strong><?php echo esc_html( $orario['giorno'] ?? '' ); ?>:</strong>
                                                <?php echo esc_html( $orario['orario'] ?? '' ); ?>
                                            </div>
                                        <?php
                                        endforeach;
                                    else :
                                        // Se è un campo textarea
                                        echo wpautop( esc_html( $orari_visite ) );
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- CTA Adozione -->
                        <div class="cta-box cta-box--adoption">
                            <div class="cta-box__icon">❤️</div>
                            <h3><?php esc_html_e( 'Vuoi adottare un cane?', 'caniincasa' ); ?></h3>
                            <p><?php esc_html_e( 'Contatta il canile per informazioni sulle adozioni e per conoscere i cani disponibili.', 'caniincasa' ); ?></p>
                            <a href="#contatti" class="btn btn-primary">
                                <?php esc_html_e( 'Contatta il Canile', 'caniincasa' ); ?>
                            </a>
                        </div>

                    </div><!-- .canile-single__content -->

                    <!-- Sidebar -->
                    <aside class="canile-single__sidebar" id="contatti">

                        <!-- Contact Box -->
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

                        <!-- Info Box -->
                        <div class="info-box">
                            <h3 class="info-box__title"><?php esc_html_e( 'Informazioni', 'caniincasa' ); ?></h3>
                            <dl class="info-list">
                                <?php
                                $nome_struttura = get_field( 'nome_struttura' );
                                if ( $nome_struttura ) :
                                ?>
                                    <dt><?php esc_html_e( 'Nome Struttura', 'caniincasa' ); ?></dt>
                                    <dd><?php echo esc_html( $nome_struttura ); ?></dd>
                                <?php endif; ?>

                                <?php if ( $tipo_struttura ) : ?>
                                    <dt><?php esc_html_e( 'Tipo', 'caniincasa' ); ?></dt>
                                    <dd><?php echo esc_html( ucfirst( $tipo_struttura ) ); ?></dd>
                                <?php endif; ?>

                                <?php if ( $cani_disponibili ) : ?>
                                    <dt><?php esc_html_e( 'Cani Ospitati', 'caniincasa' ); ?></dt>
                                    <dd><?php echo esc_html( $cani_disponibili ); ?></dd>
                                <?php endif; ?>
                            </dl>
                        </div>

                        <!-- CTA Info -->
                        <div class="cta-card cta-card--small">
                            <h4><?php esc_html_e( 'Volontariato', 'caniincasa' ); ?></h4>
                            <p><?php esc_html_e( 'Vuoi fare volontariato? Contatta il canile per informazioni.', 'caniincasa' ); ?></p>
                        </div>

                    </aside><!-- .canile-single__sidebar -->

                </div><!-- .canile-single__layout -->

                <!-- Altri Canili -->
                <?php
                $args = array(
                    'post_type'      => 'canili',
                    'posts_per_page' => 3,
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                );

                $related_query = new WP_Query( $args );

                if ( $related_query->have_posts() ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">
                            <?php esc_html_e( 'Altri Canili', 'caniincasa' ); ?>
                        </h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related_query->have_posts() ) :
                                $related_query->the_post();
                                ?>
                                <div class="card canile-card">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-content">
                                        <h3 class="card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php
                                        $citta_rel = get_field( 'citta' );
                                        if ( $citta_rel ) :
                                        ?>
                                            <div class="card-meta">
                                                <i class="icon-location">📍</i> <?php echo esc_html( $citta_rel ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-footer">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                                <?php esc_html_e( 'Visualizza', 'caniincasa' ); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
