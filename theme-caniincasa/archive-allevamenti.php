<?php
/**
 * Archive Template for Allevamenti (Breeders)
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'title' => 'Allevamenti di Cani',
        'subtitle' => 'Trova allevamenti certificati e professionali nella tua zona',
    ) );
    ?>

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Allevamenti', 'caniincasa' ); ?></h2>

                    <form id="allevamenti-filter-form" class="filter-form" method="get">

                        <!-- Search by Name -->
                        <div class="filter-group">
                            <label for="filter-search"><?php esc_html_e( 'Cerca per nome', 'caniincasa' ); ?></label>
                            <input
                                type="text"
                                id="filter-search"
                                name="search_allevamento"
                                class="form-control"
                                placeholder="<?php esc_attr_e( 'Nome allevamento...', 'caniincasa' ); ?>"
                                value="<?php echo esc_attr( get_query_var( 'search_allevamento' ) ); ?>"
                            />
                        </div>

                        <!-- Regione -->
                        <div class="filter-group">
                            <label for="filter-regione"><?php esc_html_e( 'Regione', 'caniincasa' ); ?></label>
                            <select id="filter-regione" name="regione" class="form-control">
                                <option value=""><?php esc_html_e( 'Tutte le regioni', 'caniincasa' ); ?></option>
                                <?php
                                $regioni = array(
                                    'abruzzo' => 'Abruzzo',
                                    'basilicata' => 'Basilicata',
                                    'calabria' => 'Calabria',
                                    'campania' => 'Campania',
                                    'emilia-romagna' => 'Emilia-Romagna',
                                    'friuli-venezia-giulia' => 'Friuli-Venezia Giulia',
                                    'lazio' => 'Lazio',
                                    'liguria' => 'Liguria',
                                    'lombardia' => 'Lombardia',
                                    'marche' => 'Marche',
                                    'molise' => 'Molise',
                                    'piemonte' => 'Piemonte',
                                    'puglia' => 'Puglia',
                                    'sardegna' => 'Sardegna',
                                    'sicilia' => 'Sicilia',
                                    'toscana' => 'Toscana',
                                    'trentino-alto-adige' => 'Trentino-Alto Adige',
                                    'umbria' => 'Umbria',
                                    'valle-daosta' => 'Valle d\'Aosta',
                                    'veneto' => 'Veneto',
                                );
                                $selected_regione = get_query_var( 'regione' );
                                foreach ( $regioni as $value => $label ) :
                                ?>
                                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_regione, $value ); ?>>
                                        <?php echo esc_html( $label ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Razze Allevate (Taxonomy) -->
                        <?php
                        $razze = get_terms( array(
                            'taxonomy' => 'razze_allevamenti',
                            'hide_empty' => true,
                            'orderby' => 'name',
                            'order' => 'ASC',
                        ) );
                        if ( ! empty( $razze ) && ! is_wp_error( $razze ) ) :
                        ?>
                            <div class="filter-group">
                                <label for="filter-razza"><?php esc_html_e( 'Razza allevata', 'caniincasa' ); ?></label>
                                <select id="filter-razza" name="razze_allevamenti" class="form-control">
                                    <option value=""><?php esc_html_e( 'Tutte le razze', 'caniincasa' ); ?></option>
                                    <?php
                                    $selected_razza = get_query_var( 'razze_allevamenti' );
                                    foreach ( $razze as $razza ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $razza->slug ); ?>" <?php selected( $selected_razza, $razza->slug ); ?>>
                                            <?php echo esc_html( $razza->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Action Buttons -->
                        <div class="filter-actions">
                            <button type="submit" class="btn btn-primary btn-block">
                                <?php esc_html_e( 'Applica Filtri', 'caniincasa' ); ?>
                            </button>
                            <button type="button" id="reset-filters" class="btn btn-outline btn-block">
                                <?php esc_html_e( 'Reset Filtri', 'caniincasa' ); ?>
                            </button>
                        </div>

                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="archive-content">
                <?php if ( have_posts() ) : ?>

                    <?php
                    // Pre-load caches for better performance
                    global $wp_query;
                    $post_ids = wp_list_pluck( $wp_query->posts, 'ID' );
                    update_post_caches( $wp_query->posts, 'allevamenti', true, true );
                    update_object_term_cache( $post_ids, 'allevamenti' );
                    ?>

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            printf(
                                esc_html( _n( '%d allevamento trovato', '%d allevamenti trovati', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                        <div class="results-sort">
                            <label for="sort-order" class="sr-only"><?php esc_html_e( 'Ordina per', 'caniincasa' ); ?></label>
                            <select id="sort-order" name="orderby" class="form-control form-control-sm">
                                <option value="title" <?php selected( get_query_var( 'orderby' ), 'title' ); ?>>
                                    <?php esc_html_e( 'Nome A-Z', 'caniincasa' ); ?>
                                </option>
                                <option value="date" <?php selected( get_query_var( 'orderby' ), 'date' ); ?>>
                                    <?php esc_html_e( 'Più recenti', 'caniincasa' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="allevamenti-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card allevamento-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <!-- Badges -->
                                    <div class="allevamento-card__badges">
                                        <?php
                                        if ( get_field( 'certificato_enci' ) ) :
                                            echo '<span class="badge badge--enci">ENCI</span>';
                                        endif;
                                        if ( get_field( 'certificato_fci' ) ) :
                                            echo '<span class="badge badge--fci">FCI</span>';
                                        endif;
                                        if ( get_field( 'cuccioli_disponibili' ) ) :
                                            echo '<span class="badge badge--available">Cuccioli Disponibili</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Location -->
                                    <?php
                                    $localita = get_post_meta( get_the_ID(), 'localita', true );
                                    $provincia = get_post_meta( get_the_ID(), 'provincia_', true );

                                    $location_parts = array();

                                    // Localita
                                    if ( $localita ) {
                                        $location_parts[] = $localita;
                                    }

                                    // Provincia
                                    if ( $provincia ) {
                                        $location_parts[] = '(' . $provincia . ')';
                                    }

                                    if ( ! empty( $location_parts ) ) :
                                    ?>
                                        <div class="allevamento-card__location">
                                            <span class="icon">📍</span>
                                            <?php echo esc_html( implode( ' ', $location_parts ) ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Razze Allevate -->
                                    <?php
                                    $razze_terms = get_the_terms( get_the_ID(), 'razze_allevamenti' );
                                    if ( ! empty( $razze_terms ) && ! is_wp_error( $razze_terms ) ) :
                                    ?>
                                        <div class="allevamento-card__breeds">
                                            <strong><?php esc_html_e( 'Razze allevate:', 'caniincasa' ); ?></strong>
                                            <div class="card-tags">
                                                <?php
                                                $count = 0;
                                                foreach ( $razze_terms as $razza_term ) :
                                                    if ( $count < 3 ) :
                                                        echo '<span class="tag">' . esc_html( $razza_term->name ) . '</span>';
                                                        $count++;
                                                    endif;
                                                endforeach;
                                                if ( count( $razze_terms ) > 3 ) :
                                                    echo '<span class="tag tag--more">+' . ( count( $razze_terms ) - 3 ) . '</span>';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                            <?php esc_html_e( 'Visualizza Dettagli', 'caniincasa' ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __( '← Precedente', 'caniincasa' ),
                        'next_text' => __( 'Successivo →', 'caniincasa' ),
                    ) );
                    ?>

                <?php else : ?>

                    <div class="no-results">
                        <div class="no-results__icon">🏠</div>
                        <h2><?php esc_html_e( 'Nessun allevamento trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare in un\'altra provincia.', 'caniincasa' ); ?></p>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('reset-filters').click();">
                            <?php esc_html_e( 'Reset Filtri', 'caniincasa' ); ?>
                        </button>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
