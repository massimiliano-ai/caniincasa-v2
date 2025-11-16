<?php
/**
 * Single Annunci Cucciolate Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'cucciolata-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="cucciolata-single__layout">

                    <!-- Main Content -->
                    <div class="cucciolata-single__content">

                        <!-- Header -->
                        <header class="cucciolata-single__header">
                            <h1 class="cucciolata-single__title"><?php the_title(); ?></h1>

                            <?php
                            // Razza (relationship field ACF)
                            $razza = get_field( 'razza' );
                            if ( $razza ) :
                            ?>
                                <div class="cucciolata-razza">
                                    <strong><?php esc_html_e( 'Razza:', 'caniincasa' ); ?></strong>
                                    <a href="<?php echo get_permalink( $razza->ID ); ?>" class="razza-link">
                                        <?php echo esc_html( $razza->post_title ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="cucciolata-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Informazioni Cucciolata -->
                        <div class="cucciolata-info-grid">
                            <?php
                            $data_nascita = get_field( 'data_nascita' );
                            $numero_cuccioli = get_field( 'numero_cuccioli' );
                            $disponibilita_maschi = get_field( 'disponibilita_maschi' );
                            $disponibilita_femmine = get_field( 'disponibilita_femmine' );
                            $prezzo = get_field( 'prezzo' );
                            ?>

                            <?php if ( $data_nascita ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">📅</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Data di Nascita', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( date_i18n( 'd/m/Y', strtotime( $data_nascita ) ) ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $numero_cuccioli ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">🐕</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Numero Cuccioli', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $numero_cuccioli ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $disponibilita_maschi ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">♂️</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Maschi Disponibili', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $disponibilita_maschi ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $disponibilita_femmine ) : ?>
                                <div class="info-card">
                                    <div class="info-card__icon">♀️</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Femmine Disponibili', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo esc_html( $disponibilita_femmine ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ( $prezzo ) : ?>
                                <div class="info-card info-card--highlight">
                                    <div class="info-card__icon">💰</div>
                                    <div class="info-card__content">
                                        <div class="info-card__label"><?php esc_html_e( 'Prezzo', 'caniincasa' ); ?></div>
                                        <div class="info-card__value"><?php echo '€ ' . number_format( $prezzo, 0, ',', '.' ); ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="cucciolata-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Documenti Disponibili -->
                        <?php
                        $documenti = get_field( 'documenti_disponibili' );
                        if ( $documenti && is_array( $documenti ) ) :
                        ?>
                            <div class="documenti-section">
                                <h2><?php esc_html_e( 'Documenti Disponibili', 'caniincasa' ); ?></h2>
                                <ul class="documenti-list">
                                    <?php foreach ( $documenti as $doc ) : ?>
                                        <li><span class="checkmark">✓</span> <?php echo esc_html( $doc ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Foto Genitori -->
                        <?php
                        $foto_genitori = get_field( 'foto_genitori' );
                        if ( $foto_genitori ) :
                        ?>
                            <div class="genitori-section">
                                <h2><?php esc_html_e( 'Foto dei Genitori', 'caniincasa' ); ?></h2>
                                <div class="gallery-grid">
                                    <?php foreach ( $foto_genitori as $image ) : ?>
                                        <div class="gallery-item">
                                            <img src="<?php echo esc_url( $image['sizes']['caniincasa-card'] ); ?>"
                                                 alt="<?php echo esc_attr( $image['alt'] ); ?>"
                                                 loading="lazy">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div><!-- .cucciolata-single__content -->

                    <!-- Sidebar -->
                    <aside class="cucciolata-single__sidebar">

                        <!-- Allevamento -->
                        <?php
                        $allevamento = get_field( 'allevamento_riferimento' );
                        if ( $allevamento ) :
                        ?>
                            <div class="allevamento-box">
                                <h3><?php esc_html_e( 'Allevamento', 'caniincasa' ); ?></h3>
                                <a href="<?php echo get_permalink( $allevamento->ID ); ?>" class="allevamento-link">
                                    <strong><?php echo esc_html( $allevamento->post_title ); ?></strong>
                                </a>
                                <?php if ( has_post_thumbnail( $allevamento->ID ) ) : ?>
                                    <a href="<?php echo get_permalink( $allevamento->ID ); ?>">
                                        <?php echo get_the_post_thumbnail( $allevamento->ID, 'caniincasa-thumbnail' ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Contatto -->
                        <?php
                        $contatto = get_field( 'contatto' );
                        if ( $contatto ) :
                        ?>
                            <div class="contact-box">
                                <h3 class="contact-box__title"><?php esc_html_e( 'Informazioni Contatto', 'caniincasa' ); ?></h3>
                                <div class="contact-info">
                                    <?php echo wpautop( esc_html( $contatto ) ); ?>
                                </div>
                                <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn btn-primary btn-block">
                                    <?php esc_html_e( 'Richiedi Informazioni', 'caniincasa' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Scadenza Annuncio -->
                        <?php
                        $data_scadenza = get_field( 'data_scadenza' );
                        if ( $data_scadenza ) :
                            $scadenza_timestamp = strtotime( $data_scadenza );
                            $oggi = time();
                            $giorni_rimanenti = floor( ( $scadenza_timestamp - $oggi ) / ( 60 * 60 * 24 ) );
                        ?>
                            <div class="info-box">
                                <h4><?php esc_html_e( 'Validità Annuncio', 'caniincasa' ); ?></h4>
                                <?php if ( $giorni_rimanenti > 0 ) : ?>
                                    <p class="scadenza-info">
                                        <?php printf( esc_html__( 'Annuncio valido ancora per %d giorni', 'caniincasa' ), $giorni_rimanenti ); ?>
                                    </p>
                                <?php else : ?>
                                    <p class="scadenza-info scadenza-scaduta">
                                        <?php esc_html_e( 'Annuncio scaduto', 'caniincasa' ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- CTA Pubblica Annuncio -->
                        <div class="cta-card cta-card--small">
                            <h4><?php esc_html_e( 'Hai un annuncio da pubblicare?', 'caniincasa' ); ?></h4>
                            <p><?php esc_html_e( 'Pubblica il tuo annuncio gratuitamente', 'caniincasa' ); ?></p>
                            <a href="<?php echo esc_url( home_url( '/contattaci/' ) ); ?>" class="btn btn-sm">
                                <?php esc_html_e( 'Pubblica Annuncio', 'caniincasa' ); ?>
                            </a>
                        </div>

                    </aside><!-- .cucciolata-single__sidebar -->

                </div><!-- .cucciolata-single__layout -->

                <!-- Altri Annunci -->
                <?php
                $args = array(
                    'post_type'      => 'annunci_cucciolate',
                    'posts_per_page' => 3,
                    'post__not_in'   => array( get_the_ID() ),
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );

                $related_query = new WP_Query( $args );

                if ( $related_query->have_posts() ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">
                            <?php esc_html_e( 'Altri Annunci', 'caniincasa' ); ?>
                        </h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related_query->have_posts() ) :
                                $related_query->the_post();
                                ?>
                                <div class="card cucciolata-card">
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
                                        $prezzo_rel = get_field( 'prezzo' );
                                        if ( $prezzo_rel ) :
                                        ?>
                                            <div class="card-meta">
                                                <strong><?php echo '€ ' . number_format( $prezzo_rel, 0, ',', '.' ); ?></strong>
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
