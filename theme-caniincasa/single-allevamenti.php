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

                        <!-- Header -->
                        <header class="allevamento-single__header">

                            <?php
                            $provincia = get_post_meta( get_the_ID(), 'provincia_', true );
                            $localita = get_post_meta( get_the_ID(), 'localita', true );
                            if ( $localita || $provincia ) :
                            ?>
                                <div class="allevamento-single__location">
                                    <i class="icon-location">📍</i>
                                    <?php
                                    if ( $localita ) {
                                        echo esc_html( $localita );
                                    }
                                    if ( $provincia ) {
                                        echo $localita ? ' (' . esc_html( $provincia ) . ')' : esc_html( $provincia );
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="allevamento-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Razze Trattate -->
                        <?php
                        $razze = wp_get_post_terms( get_the_ID(), 'razze_allevamenti' );
                        if ( ! empty( $razze ) && ! is_wp_error( $razze ) ) :
                        ?>
                            <div class="allevamento-single__razze">
                                <h2>Razze Allevate</h2>
                                <div class="razze-cards-grid">
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
                                        <div class="razza-card">
                                            <?php if ( $razza_image ) : ?>
                                                <div class="razza-card__image">
                                                    <a href="<?php echo esc_url( $razza_link ); ?>">
                                                        <img src="<?php echo esc_url( $razza_image ); ?>" alt="<?php echo esc_attr( $razza->name ); ?>" loading="lazy">
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="razza-card__content">
                                                <h3 class="razza-card__title">
                                                    <a href="<?php echo esc_url( $razza_link ); ?>">
                                                        <?php echo esc_html( $razza->name ); ?>
                                                    </a>
                                                </h3>
                                                <?php if ( ! empty( $razza_post ) && $razza_post[0]->post_excerpt ) : ?>
                                                    <p class="razza-card__excerpt">
                                                        <?php echo esc_html( wp_trim_words( $razza_post[0]->post_excerpt, 15 ) ); ?>
                                                    </p>
                                                <?php endif; ?>
                                                <a href="<?php echo esc_url( $razza_link ); ?>" class="razza-card__link">
                                                    Scopri di più →
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <div class="allevamento-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Reviews Section Placeholder -->
                        <div class="reviews-section" id="reviews">
                            <h2>Recensioni</h2>
                            <div class="reviews-placeholder">
                                <p>Sistema recensioni in fase di implementazione.</p>
                                <p>Presto sarà possibile leggere e lasciare recensioni per questo allevamento.</p>
                            </div>
                        </div>

                        <!-- CTA per proprietari -->
                        <div class="cta-card">
                            <div class="cta-card__icon">🐾</div>
                            <h3 class="cta-card__title">Sei il proprietario di questo allevamento?</h3>
                            <p class="cta-card__text">Aggiorna le informazioni, aggiungi foto e dettagli per renderlo più completo.</p>
                            <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn">
                                Aggiorna Informazioni
                            </a>
                        </div>

                    </div><!-- .allevamento-single__content -->

                    <!-- Sidebar -->
                    <aside class="allevamento-single__sidebar">

                        <!-- Contact Box -->
                        <?php caniincasa_contact_box( get_the_ID() ); ?>

                        <!-- Informazioni Aggiuntive -->
                        <div class="info-box">
                            <h3 class="info-box__title">Informazioni</h3>
                            <dl class="info-list">
                                <?php
                                $persona = get_post_meta( get_the_ID(), 'persona', true );
                                if ( $persona ) :
                                ?>
                                    <dt>Responsabile</dt>
                                    <dd><?php echo esc_html( $persona ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $affisso = get_post_meta( get_the_ID(), 'desaffisso', true );
                                if ( $affisso ) :
                                ?>
                                    <dt>Affisso</dt>
                                    <dd><?php echo esc_html( $affisso ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $id_affisso = get_post_meta( get_the_ID(), 'idaffisso', true );
                                if ( $id_affisso ) :
                                ?>
                                    <dt>ID Affisso</dt>
                                    <dd><?php echo esc_html( $id_affisso ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $sregcode = get_post_meta( get_the_ID(), 'sregcode', true );
                                if ( $sregcode ) :
                                ?>
                                    <dt>Codice Registrazione</dt>
                                    <dd><?php echo esc_html( $sregcode ); ?></dd>
                                <?php endif; ?>
                            </dl>
                        </div>

                        <!-- CTA Annuncio Cucciolata -->
                        <div class="cta-card cta-card--small">
                            <h4>Hai un annuncio da pubblicare?</h4>
                            <p>Pubblica il tuo annuncio</p>
                            <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn btn-sm">
                                Invia Annuncio
                            </a>
                        </div>

                    </aside><!-- .allevamento-single__sidebar -->

                </div><!-- .allevamento-single__layout -->

                <!-- Related Allevamenti -->
                <?php
                $related = caniincasa_get_related_posts( get_the_ID(), 3 );
                if ( $related ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">Altri Allevamenti nella Zona</h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related->have_posts() ) :
                                $related->the_post();
                                ?>
                                <div class="card allevamento-card">
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
                                        $prov = get_post_meta( get_the_ID(), 'provincia_', true );
                                        if ( $prov ) :
                                        ?>
                                            <div class="allevamento-card__location">
                                                <i class="icon-location">📍</i>
                                                <?php echo esc_html( $prov ); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-footer">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                                Visualizza
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
