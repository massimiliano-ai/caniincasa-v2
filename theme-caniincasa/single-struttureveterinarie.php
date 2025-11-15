<?php
/**
 * Single Strutture Veterinarie Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'veterinario-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="veterinario-single__layout">

                    <!-- Main Content -->
                    <div class="veterinario-single__content">

                        <!-- Header -->
                        <header class="veterinario-single__header">
                            <?php
                            $pronto_soccorso = get_post_meta( get_the_ID(), 'pronto_soccorso', true );
                            if ( $pronto_soccorso ) :
                            ?>
                                <div class="emergency-badge">
                                    <span class="emergency-icon">🚨</span>
                                    <?php esc_html_e( 'Pronto Soccorso 24h', 'caniincasa' ); ?>
                                </div>
                            <?php endif; ?>

                            <h1 class="veterinario-single__title"><?php the_title(); ?></h1>

                            <?php
                            $citta = get_post_meta( get_the_ID(), 'citta', true );
                            $provincia = get_post_meta( get_the_ID(), 'provincia', true );
                            if ( $citta || $provincia ) :
                            ?>
                                <div class="veterinario-single__location">
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
                                <div class="veterinario-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Direttore Sanitario -->
                        <?php
                        $direttore = get_post_meta( get_the_ID(), 'direttore_sanitario', true );
                        if ( $direttore ) :
                        ?>
                            <div class="info-highlight">
                                <strong><?php esc_html_e( 'Direttore Sanitario:', 'caniincasa' ); ?></strong>
                                <?php echo esc_html( $direttore ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <div class="veterinario-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Servizi Offerti -->
                        <?php
                        $servizi = get_post_meta( get_the_ID(), 'servizi_offerti', true );
                        if ( $servizi ) :
                        ?>
                            <div class="servizi-section">
                                <h2><?php esc_html_e( 'Servizi Offerti', 'caniincasa' ); ?></h2>
                                <div class="servizi-list">
                                    <?php echo wpautop( esc_html( $servizi ) ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Servizi Tags (taxonomy) -->
                        <?php
                        $servizi_terms = wp_get_post_terms( get_the_ID(), 'servizi_veterinari' );
                        if ( ! empty( $servizi_terms ) && ! is_wp_error( $servizi_terms ) ) :
                        ?>
                            <div class="servizi-tags">
                                <h3><?php esc_html_e( 'Specializzazioni', 'caniincasa' ); ?></h3>
                                <div class="tag-list">
                                    <?php foreach ( $servizi_terms as $term ) : ?>
                                        <span class="tag tag-servizio"><?php echo esc_html( $term->name ); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Orari Apertura -->
                        <?php
                        // Se hai un repeater ACF per orari, usa questo
                        // Se è un campo textarea, mostralo così:
                        $orari = get_post_meta( get_the_ID(), 'orari_apertura', true );
                        if ( $orari ) :
                        ?>
                            <div class="orari-section">
                                <h2><?php esc_html_e( 'Orari di Apertura', 'caniincasa' ); ?></h2>
                                <div class="orari-content">
                                    <?php echo wpautop( esc_html( $orari ) ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div><!-- .veterinario-single__content -->

                    <!-- Sidebar -->
                    <aside class="veterinario-single__sidebar">

                        <!-- Contact Box -->
                        <?php
                        $telefono_principale = get_post_meta( get_the_ID(), 'telefono_principale', true );
                        $telefono_reperibilita = get_post_meta( get_the_ID(), 'telefono_reperibilita', true );
                        $email = get_post_meta( get_the_ID(), 'email', true );
                        $sito_web = get_post_meta( get_the_ID(), 'sito_web', true );
                        $indirizzo_completo = get_post_meta( get_the_ID(), 'indirizzo_completo', true );
                        ?>

                        <div class="contact-box">
                            <h3 class="contact-box__title"><?php esc_html_e( 'Contatti', 'caniincasa' ); ?></h3>
                            <ul class="contact-list">
                                <?php if ( $telefono_principale ) : ?>
                                    <li class="contact-phone">
                                        <i class="icon-phone">📞</i>
                                        <div>
                                            <strong><?php esc_html_e( 'Telefono:', 'caniincasa' ); ?></strong><br>
                                            <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $telefono_principale ) ); ?>">
                                                <?php echo esc_html( $telefono_principale ); ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $telefono_reperibilita ) : ?>
                                    <li class="contact-phone">
                                        <i class="icon-phone">📱</i>
                                        <div>
                                            <strong><?php esc_html_e( 'Reperibilità:', 'caniincasa' ); ?></strong><br>
                                            <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $telefono_reperibilita ) ); ?>">
                                                <?php echo esc_html( $telefono_reperibilita ); ?>
                                            </a>
                                        </div>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $email ) : ?>
                                    <li class="contact-email">
                                        <i class="icon-email">✉️</i>
                                        <a href="<?php echo esc_url( 'mailto:' . $email ); ?>">
                                            <?php echo esc_html( $email ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $sito_web ) : ?>
                                    <li class="contact-web">
                                        <i class="icon-web">🌐</i>
                                        <a href="<?php echo esc_url( $sito_web ); ?>" target="_blank" rel="noopener">
                                            <?php esc_html_e( 'Visita il sito', 'caniincasa' ); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $indirizzo_completo ) : ?>
                                    <li class="contact-location">
                                        <i class="icon-location">📍</i>
                                        <?php echo esc_html( $indirizzo_completo ); ?>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <?php if ( $telefono_principale ) : ?>
                                <a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $telefono_principale ) ); ?>" class="btn btn-primary btn-block">
                                    <?php esc_html_e( 'Chiama Ora', 'caniincasa' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Info Box -->
                        <div class="info-box">
                            <h3 class="info-box__title"><?php esc_html_e( 'Informazioni', 'caniincasa' ); ?></h3>
                            <dl class="info-list">
                                <?php
                                $cap = get_post_meta( get_the_ID(), 'cap', true );
                                if ( $cap ) :
                                ?>
                                    <dt><?php esc_html_e( 'CAP', 'caniincasa' ); ?></dt>
                                    <dd><?php echo esc_html( $cap ); ?></dd>
                                <?php endif; ?>

                                <?php if ( $pronto_soccorso ) : ?>
                                    <dt><?php esc_html_e( 'Pronto Soccorso', 'caniincasa' ); ?></dt>
                                    <dd><span class="badge badge-success">Disponibile 24h</span></dd>
                                <?php endif; ?>
                            </dl>
                        </div>

                        <!-- CTA Aggiorna Info -->
                        <div class="cta-card cta-card--small">
                            <h4><?php esc_html_e( 'Sei il proprietario?', 'caniincasa' ); ?></h4>
                            <p><?php esc_html_e( 'Aggiorna le informazioni della tua struttura', 'caniincasa' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn btn-sm">
                                <?php esc_html_e( 'Contattaci', 'caniincasa' ); ?>
                            </a>
                        </div>

                    </aside><!-- .veterinario-single__sidebar -->

                </div><!-- .veterinario-single__layout -->

                <!-- Related Veterinari -->
                <?php
                $args = array(
                    'post_type'      => 'struttureveterinarie',
                    'posts_per_page' => 3,
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'rand',
                );

                if ( $provincia ) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'provincia',
                            'field'    => 'slug',
                            'terms'    => sanitize_title( $provincia ),
                        ),
                    );
                }

                $related_query = new WP_Query( $args );

                if ( $related_query->have_posts() ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">
                            <?php esc_html_e( 'Altre Strutture Veterinarie nella Zona', 'caniincasa' ); ?>
                        </h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related_query->have_posts() ) :
                                $related_query->the_post();
                                ?>
                                <div class="card veterinario-card">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="card-content">
                                        <?php if ( get_post_meta( get_the_ID(), 'pronto_soccorso', true ) ) : ?>
                                            <span class="veterinario-card__emergency">
                                                <?php esc_html_e( 'Pronto Soccorso 24h', 'caniincasa' ); ?>
                                            </span>
                                        <?php endif; ?>
                                        <h3 class="card-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php
                                        $citta_rel = get_post_meta( get_the_ID(), 'citta', true );
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
