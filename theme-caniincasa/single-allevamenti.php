<?php
/**
 * Single Allevamenti Template
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
            'subtitle' => 'Allevamento',
        ) );
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'allevamento-single' ); ?>>

            <div class="container">

                <?php caniincasa_breadcrumbs(); ?>

                <div class="allevamento-single__layout">

                    <!-- Main Content -->
                    <div class="allevamento-single__content">

                        <!-- Info Table -->
                        <div class="info-table">
                            <?php
                            // Get custom fields
                            $persona = get_post_meta( get_the_ID(), 'persona', true );
                            $affisso = get_post_meta( get_the_ID(), 'desaffisso', true );
                            $id_affisso = get_post_meta( get_the_ID(), 'idaffisso', true );
                            $sregcode = get_post_meta( get_the_ID(), 'sregcode', true );
                            $indirizzo = get_post_meta( get_the_ID(), 'indirizzo', true );
                            $localita = get_post_meta( get_the_ID(), 'localita', true );
                            $provincia = get_post_meta( get_the_ID(), 'provincia_', true );
                            $regione = get_post_meta( get_the_ID(), 'regione', true );
                            $telefono = get_post_meta( get_the_ID(), 'telefono', true );
                            $email = get_post_meta( get_the_ID(), 'email', true );
                            $sito_web = get_post_meta( get_the_ID(), 'sito_web', true );
                            ?>

                            <?php if ( $persona ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Responsabile</div>
                                    <div class="info-value"><?php echo esc_html( $persona ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $affisso ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Affisso</div>
                                    <div class="info-value"><strong><?php echo esc_html( $affisso ); ?></strong></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $id_affisso ) : ?>
                                <div class="info-row">
                                    <div class="info-label">ID Affisso</div>
                                    <div class="info-value"><?php echo esc_html( $id_affisso ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $indirizzo ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Indirizzo</div>
                                    <div class="info-value"><?php echo esc_html( $indirizzo ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $localita || $provincia || $regione ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Località</div>
                                    <div class="info-value">
                                        <?php
                                        $location_parts = array();
                                        if ( $localita ) {
                                            $location_parts[] = esc_html( $localita );
                                        }
                                        if ( $provincia ) {
                                            $location_parts[] = '(' . esc_html( $provincia ) . ')';
                                        }
                                        echo implode( ' ', $location_parts );

                                        // Add regione on same line if exists
                                        if ( $regione ) {
                                            echo ' <span class="regione">' . esc_html( $regione ) . '</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $telefono ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Telefono</div>
                                    <div class="info-value">
                                        <a href="tel:<?php echo esc_attr( $telefono ); ?>"><?php echo esc_html( $telefono ); ?></a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $email ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Email</div>
                                    <div class="info-value"><?php echo esc_html( $email ); ?></div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $sito_web ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Sito Web</div>
                                    <div class="info-value">
                                        <a href="<?php echo esc_url( $sito_web ); ?>" target="_blank" rel="noopener noreferrer">
                                            Visita sito →
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $sregcode ) : ?>
                                <div class="info-row">
                                    <div class="info-label">Codice Registrazione</div>
                                    <div class="info-value"><?php echo esc_html( $sregcode ); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Razze Allevate -->
                        <?php
                        $razze = wp_get_post_terms( get_the_ID(), 'razze_allevamenti' );
                        if ( ! empty( $razze ) && ! is_wp_error( $razze ) ) :
                        ?>
                            <div class="allevamento-single__razze">
                                <h2>Razze Allevate</h2>
                                <div class="results-grid">
                                    <?php foreach ( $razze as $razza ) :
                                        // Try to find corresponding razza_di_cani post
                                        $razza_post = get_posts( array(
                                            'post_type' => 'razze_di_cani',
                                            'title' => $razza->name,
                                            'posts_per_page' => 1,
                                            'post_status' => 'publish',
                                        ) );

                                        $razza_link = ! empty( $razza_post ) ? get_permalink( $razza_post[0]->ID ) : get_term_link( $razza );
                                        $razza_image = ! empty( $razza_post ) && has_post_thumbnail( $razza_post[0]->ID )
                                            ? get_the_post_thumbnail_url( $razza_post[0]->ID, 'medium' )
                                            : '';
                                    ?>
                                        <div class="result-card match-good">
                                            <?php if ( $razza_image ) : ?>
                                                <div class="result-image">
                                                    <a href="<?php echo esc_url( $razza_link ); ?>">
                                                        <img src="<?php echo esc_url( $razza_image ); ?>" alt="<?php echo esc_attr( $razza->name ); ?>" loading="lazy">
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="result-content">
                                                <h3 class="result-name">
                                                    <a href="<?php echo esc_url( $razza_link ); ?>">
                                                        <?php echo esc_html( $razza->name ); ?>
                                                    </a>
                                                </h3>
                                                <a href="<?php echo esc_url( $razza_link ); ?>" class="btn btn-sm btn-outline">
                                                    Scopri di più →
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <?php if ( get_the_content() ) : ?>
                            <div class="allevamento-single__description">
                                <h2>Descrizione</h2>
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Featured Image -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="allevamento-single__image">
                                <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
                            </div>
                        <?php endif; ?>

                    </div><!-- .allevamento-single__content -->

                    <!-- Sidebar -->
                    <aside class="allevamento-single__sidebar">

                        <!-- CTA per proprietari -->
                        <div class="cta-card">
                            <h4>Sei il proprietario?</h4>
                            <p>Aggiorna le informazioni, aggiungi foto e dettagli per renderlo più completo.</p>
                            <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn btn-secondary btn-block">
                                Contattaci
                            </a>
                        </div>

                    </aside><!-- .allevamento-single__sidebar -->

                </div><!-- .allevamento-single__layout -->

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
