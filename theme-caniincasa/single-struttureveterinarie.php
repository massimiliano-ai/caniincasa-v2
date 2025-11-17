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

        <?php
        // Hero Section
        caniincasa_page_hero( array(
            'subtitle' => 'Veterinario o Struttura Veterinaria',
        ) );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'veterinario-single' ); ?>>

            <div class="container">

                <?php caniincasa_breadcrumbs(); ?>

                <div class="veterinario-single__layout">

                    <!-- Main Content -->
                    <div class="veterinario-single__content">

                        <!-- Info Table -->
                        <div class="info-table">
                            <?php
                            // Get ACF fields
                            $direttore = get_field( 'direttore_sanitario' );
                            $indirizzo = get_field( 'indirizzo' );
                            $localita = get_field( 'localita' ) ?: get_field( 'comune' );
                            $provincia = get_field( 'provincia_estesa' );
                            $telefono = get_field( 'telefono' );
                            $pronto_soccorso = get_field( 'pronto_soccorso_h24' );
                            $reperibilita = get_field( 'reperibilita_h24' );
                            $servizi = get_field( 'servizi_offerti' );
                            $orari = get_field( 'orari_di_apertura' );
                            ?>

                            <?php if ( $direttore ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Direttore sanitario', 'caniincasa' ); ?></div>
                                    <div class="info-value"><?php echo esc_html( $direttore ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $indirizzo ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Indirizzo', 'caniincasa' ); ?></div>
                                    <div class="info-value"><?php echo esc_html( $indirizzo ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $localita || $provincia ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Località', 'caniincasa' ); ?></div>
                                    <div class="info-value">
                                        <?php
                                        if ( $localita && $provincia ) {
                                            echo esc_html( $localita ) . ' - ' . esc_html( $provincia );
                                        } elseif ( $localita ) {
                                            echo esc_html( $localita );
                                        } else {
                                            echo esc_html( $provincia );
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $telefono ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Telefono', 'caniincasa' ); ?></div>
                                    <div class="info-value"><?php echo esc_html( $telefono ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $pronto_soccorso ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Pronto Soccorso Veterinario', 'caniincasa' ); ?></div>
                                    <div class="info-value"><strong><?php echo $pronto_soccorso === '1' || $pronto_soccorso === 'SI' ? 'SI' : esc_html( $pronto_soccorso ); ?></strong></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $reperibilita ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Reperibilità:', 'caniincasa' ); ?></div>
                                    <div class="info-value"><?php echo $reperibilita === '1' || $reperibilita === 'SI' ? 'SI' : esc_html( $reperibilita ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $servizi ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Servizi Offerti', 'caniincasa' ); ?></div>
                                    <div class="info-value"><?php echo esc_html( $servizi ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $orari ) : ?>
                                <div class="info-row">
                                    <div class="info-label"><?php esc_html_e( 'Orari Apertura', 'caniincasa' ); ?></div>
                                    <div class="info-value">
                                        <?php
                                        // Output orari with allowed HTML tags
                                        echo wp_kses_post( $orari );
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div><!-- .veterinario-single__content -->

                    <!-- Sidebar -->
                    <aside class="veterinario-single__sidebar">

                        <!-- Cerca altro veterinario -->
                        <div class="sidebar-box">
                            <h3><?php esc_html_e( 'Cerca altro veterinario', 'caniincasa' ); ?></h3>
                            <a href="<?php echo esc_url( home_url( '/veterinari/' ) ); ?>" class="btn btn-primary btn-block">
                                <?php esc_html_e( 'Vai all\'elenco', 'caniincasa' ); ?>
                            </a>
                        </div>

                        <!-- CTA Aggiorna Info -->
                        <div class="cta-card">
                            <h4><?php esc_html_e( 'Sei il proprietario vuoi aggiornare i dati', 'caniincasa' ); ?></h4>
                            <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn btn-secondary btn-block">
                                <?php esc_html_e( 'Contattaci', 'caniincasa' ); ?>
                            </a>
                        </div>

                        <!-- Vuoi proporre una cucciolata -->
                        <div class="sidebar-box sidebar-box--secondary">
                            <h4><?php esc_html_e( 'Vuoi proporre una cucciolata o una adozione? scrivici!!', 'caniincasa' ); ?></h4>
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
