<?php
/**
 * Single Razze di Cani Template
 *
 * Layout 1/3 + 2/3 (Desktop)
 * Layout invertito su Mobile
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'razza-single' ); ?>>

            <div class="container">
                <?php caniincasa_breadcrumbs(); ?>

                <div class="razza-layout">

                    <!-- COLONNA PRINCIPALE 2/3 (Desktop) / Prima su Mobile -->
                    <div class="razza-content">

                        <!-- Titolo -->
                        <header class="razza-header">
                            <h1 class="razza-title"><?php the_title(); ?></h1>
                        </header>

                        <!-- Descrizione Generale -->
                        <?php
                        $descrizione_generale = get_field( 'descrizione_generale' );
                        if ( $descrizione_generale ) :
                        ?>
                            <div class="razza-description">
                                <?php echo wp_kses_post( $descrizione_generale ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Sezioni Contenuto -->
                        <div class="razza-sections">

                            <?php
                            // Definisci le sezioni con i rispettivi campi ACF
                            $sections = array(
                                'origini_storia' => array(
                                    'title' => 'Origini e Storia',
                                    'icon'  => '📜',
                                ),
                                'aspetto_fisico' => array(
                                    'title' => 'Aspetto Fisico',
                                    'icon'  => '🐕',
                                ),
                                'carattere_temperamento' => array(
                                    'title' => 'Carattere e Temperamento',
                                    'icon'  => '💛',
                                ),
                                'salute_cura' => array(
                                    'title' => 'Salute e Cura',
                                    'icon'  => '🏥',
                                ),
                                'attivita_addestramento' => array(
                                    'title' => 'Attività e Addestramento',
                                    'icon'  => '🎾',
                                ),
                                'ideale_per' => array(
                                    'title' => 'Ideale Per',
                                    'icon'  => '✨',
                                ),
                            );

                            foreach ( $sections as $field_name => $section ) :
                                $content = get_field( $field_name );
                                if ( $content ) :
                            ?>
                                <div class="razza-section" id="section-<?php echo esc_attr( $field_name ); ?>">
                                    <h2 class="razza-section__title">
                                        <span class="section-icon"><?php echo $section['icon']; ?></span>
                                        <?php echo esc_html( $section['title'] ); ?>
                                    </h2>
                                    <div class="razza-section__content">
                                        <?php echo wp_kses_post( $content ); ?>
                                    </div>
                                </div>
                            <?php
                                endif;
                            endforeach;
                            ?>

                        </div><!-- .razza-sections -->

                        <!-- Box Caratteristiche con Zampette -->
                        <?php
                        // Display new paw-based rating system
                        if ( function_exists( 'caniincasa_breed_characteristics' ) ) {
                            caniincasa_breed_characteristics();
                        }
                        ?>

                    </div><!-- .razza-content -->

                    <!-- SIDEBAR 1/3 (Desktop) / Dopo su Mobile -->
                    <aside class="razza-sidebar">

                        <!-- Immagine in Evidenza -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="sidebar-featured-image">
                                <?php the_post_thumbnail( 'medium_large', array(
                                    'class' => 'sidebar-image',
                                    'alt'   => get_the_title(),
                                ) ); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Box Informazioni Razza -->
                        <?php
                        $nazione_origine     = get_field( 'nazione_origine' );
                        $colorazioni         = get_field( 'colorazioni' );
                        $temperamento_breve  = get_field( 'temperamento_breve' );

                        if ( $nazione_origine || $colorazioni || $temperamento_breve ) :
                        ?>
                            <div class="info-box info-box--primary">
                                <h3 class="info-box__title">📋 Informazioni Razza</h3>
                                <dl class="info-list">

                                    <?php if ( $nazione_origine ) : ?>
                                        <dt>🌍 Nazione Origine</dt>
                                        <dd><?php echo esc_html( $nazione_origine ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $colorazioni ) : ?>
                                        <dt>🎨 Colorazioni</dt>
                                        <dd><?php echo nl2br( esc_html( $colorazioni ) ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $temperamento_breve ) : ?>
                                        <dt>💭 Temperamento</dt>
                                        <dd><?php echo esc_html( $temperamento_breve ); ?></dd>
                                    <?php endif; ?>

                                </dl>
                            </div>
                        <?php endif; ?>

                        <!-- Box Caratteristiche Fisiche -->
                        <?php
                        $altezza_min_maschio = get_post_meta( get_the_ID(), 'altezza_minima_maschio', true );
                        $altezza_max_maschio = get_post_meta( get_the_ID(), 'altezza_massima_maschio', true );
                        $altezza_min_femmina = get_post_meta( get_the_ID(), 'altezza_minima_femmina', true );
                        $altezza_max_femmina = get_post_meta( get_the_ID(), 'altezza_massima_femmina', true );
                        $peso_min_maschio    = get_post_meta( get_the_ID(), 'peso_minimo_maschio', true );
                        $peso_max_maschio    = get_post_meta( get_the_ID(), 'peso_massimo_maschio', true );
                        $peso_min_femmina    = get_post_meta( get_the_ID(), 'peso_minimo_femmina', true );
                        $peso_max_femmina    = get_post_meta( get_the_ID(), 'peso_massimo_femmina', true );
                        $vita_min            = get_post_meta( get_the_ID(), 'aspettativa_di_vita_minima', true );
                        $vita_max            = get_post_meta( get_the_ID(), 'aspettativa_di_vita_massima', true );
                        $gruppo              = get_post_meta( get_the_ID(), 'gruppo_razza', true );

                        if ( $altezza_min_maschio || $peso_min_maschio || $vita_min || $gruppo ) :
                        ?>
                            <div class="info-box">
                                <h3 class="info-box__title">📏 Caratteristiche Fisiche</h3>
                                <dl class="info-list">

                                    <?php if ( $altezza_min_maschio && $altezza_max_maschio ) : ?>
                                        <dt>Altezza Maschio</dt>
                                        <dd><?php echo esc_html( $altezza_min_maschio . ' - ' . $altezza_max_maschio . ' cm' ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $altezza_min_femmina && $altezza_max_femmina ) : ?>
                                        <dt>Altezza Femmina</dt>
                                        <dd><?php echo esc_html( $altezza_min_femmina . ' - ' . $altezza_max_femmina . ' cm' ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $peso_min_maschio && $peso_max_maschio ) : ?>
                                        <dt>Peso Maschio</dt>
                                        <dd><?php echo esc_html( $peso_min_maschio . ' - ' . $peso_max_maschio . ' kg' ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $peso_min_femmina && $peso_max_femmina ) : ?>
                                        <dt>Peso Femmina</dt>
                                        <dd><?php echo esc_html( $peso_min_femmina . ' - ' . $peso_max_femmina . ' kg' ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $vita_min && $vita_max ) : ?>
                                        <dt>Aspettativa di Vita</dt>
                                        <dd><?php echo esc_html( $vita_min . ' - ' . $vita_max . ' anni' ); ?></dd>
                                    <?php endif; ?>

                                    <?php if ( $gruppo ) : ?>
                                        <dt>Gruppo FCI</dt>
                                        <dd><?php echo esc_html( $gruppo ); ?></dd>
                                    <?php endif; ?>

                                </dl>
                            </div>
                        <?php endif; ?>

                        <!-- Allevamenti Collegati -->
                        <?php
                        // Get the current razza taxonomy term
                        $current_razza_slug = get_post_field( 'post_name', get_the_ID() );
                        $current_razza_name = get_the_title();

                        // Try to find the corresponding razze_allevamenti term
                        $razza_term = get_term_by( 'slug', $current_razza_slug, 'razze_allevamenti' );
                        if ( ! $razza_term ) {
                            // Try by name if slug doesn't match
                            $razza_term = get_term_by( 'name', $current_razza_name, 'razze_allevamenti' );
                        }

                        $args = array(
                            'post_type'      => 'allevamenti',
                            'posts_per_page' => 5,
                            'orderby'        => 'rand',
                            'post_status'    => 'publish',
                        );

                        // Only add tax_query if we found a matching term
                        if ( $razza_term ) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'razze_allevamenti',
                                    'field'    => 'term_id',
                                    'terms'    => $razza_term->term_id,
                                ),
                            );
                        }

                        $allevamenti_query = new WP_Query( $args );

                        if ( $allevamenti_query->have_posts() ) :
                            // Build the "view all" link with filter
                            $view_all_link = home_url( '/allevamenti/' );
                            if ( $razza_term ) {
                                $view_all_link = add_query_arg( 'filter_razza', $razza_term->slug, $view_all_link );
                            }
                        ?>
                            <div class="info-box info-box--allevamenti">
                                <h3 class="info-box__title">🏠 Allevamenti di <?php the_title(); ?></h3>
                                <p class="info-box__description">
                                    <?php
                                    printf(
                                        esc_html__( 'Selezionati casualmente %d allevamenti che allevano %s', 'caniincasa' ),
                                        min( 5, $allevamenti_query->found_posts ),
                                        esc_html( $current_razza_name )
                                    );
                                    ?>
                                </p>
                                <ul class="related-list">
                                    <?php while ( $allevamenti_query->have_posts() ) : $allevamenti_query->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>" class="allevamento-link">
                                                <?php the_title(); ?>
                                            </a>
                                            <?php
                                            $provincia = get_post_meta( get_the_ID(), 'desprovincia', true );
                                            if ( ! $provincia ) {
                                                $provincia = get_post_meta( get_the_ID(), 'provincia_', true );
                                            }
                                            if ( $provincia ) :
                                                echo ' <span class="provincia">(' . esc_html( $provincia ) . ')</span>';
                                            endif;
                                            ?>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <a href="<?php echo esc_url( $view_all_link ); ?>" class="btn btn-outline btn-block">
                                    <?php
                                    printf(
                                        esc_html__( 'Vedi tutti gli allevamenti di %s (%d)', 'caniincasa' ),
                                        esc_html( $current_razza_name ),
                                        $allevamenti_query->found_posts
                                    );
                                    ?>
                                </a>
                            </div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>

                    </aside><!-- .razza-sidebar -->

                </div><!-- .razza-layout -->

                <!-- Related Content -->
                <?php
                $related = caniincasa_get_related_posts( get_the_ID(), 3 );
                if ( $related ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">Altre Razze che Potrebbero Interessarti</h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related->have_posts() ) :
                                $related->the_post();
                                get_template_part( 'template-parts/content', 'razza-card' );
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
