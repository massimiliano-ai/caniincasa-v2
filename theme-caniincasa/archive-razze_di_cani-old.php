<?php
/**
 * Archive Template for Razze di Cani (Dog Breeds)
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <header class="archive-header">
            <h1 class="archive-title">
                <?php esc_html_e( 'Razze di Cani', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Scopri tutte le razze di cani con caratteristiche, temperamento e informazioni utili per trovare il compagno perfetto.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Razze', 'caniincasa' ); ?></h2>

                    <form id="razze-filter-form" class="filter-form" method="get">

                        <!-- Search by Name -->
                        <div class="filter-group">
                            <label for="filter-search"><?php esc_html_e( 'Cerca per nome', 'caniincasa' ); ?></label>
                            <input
                                type="text"
                                id="filter-search"
                                name="search_breed"
                                class="form-control"
                                placeholder="<?php esc_attr_e( 'Es: Labrador, Pastore...', 'caniincasa' ); ?>"
                                value="<?php echo esc_attr( get_query_var( 'search_breed' ) ); ?>"
                            />
                        </div>

                        <!-- Taglia (Size) -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Taglia', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <?php
                                $taglie = array(
                                    'toy' => 'Toy (< 5kg)',
                                    'piccola' => 'Piccola (5-10kg)',
                                    'media' => 'Media (10-25kg)',
                                    'grande' => 'Grande (25-45kg)',
                                    'gigante' => 'Gigante (> 45kg)',
                                );
                                $selected_taglie = (array) get_query_var( 'taglia' );
                                foreach ( $taglie as $value => $label ) :
                                ?>
                                    <label class="checkbox-label">
                                        <input
                                            type="checkbox"
                                            name="taglia[]"
                                            value="<?php echo esc_attr( $value ); ?>"
                                            <?php checked( in_array( $value, $selected_taglie ) ); ?>
                                        />
                                        <span><?php echo esc_html( $label ); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Livello Energia -->
                        <div class="filter-group">
                            <label for="filter-energia"><?php esc_html_e( 'Livello Energia', 'caniincasa' ); ?></label>
                            <select id="filter-energia" name="livello_energia" class="form-control">
                                <option value=""><?php esc_html_e( 'Tutti i livelli', 'caniincasa' ); ?></option>
                                <?php
                                $energia_levels = array(
                                    'basso' => 'Basso',
                                    'medio' => 'Medio',
                                    'alto' => 'Alto',
                                    'molto-alto' => 'Molto Alto',
                                );
                                $selected_energia = get_query_var( 'livello_energia' );
                                foreach ( $energia_levels as $value => $label ) :
                                ?>
                                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_energia, $value ); ?>>
                                        <?php echo esc_html( $label ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tipo per Famiglie -->
                        <div class="filter-group">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="adatto_famiglie"
                                    value="1"
                                    <?php checked( get_query_var( 'adatto_famiglie' ), '1' ); ?>
                                />
                                <span><?php esc_html_e( 'Adatto alle famiglie', 'caniincasa' ); ?></span>
                            </label>
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="adatto_bambini"
                                    value="1"
                                    <?php checked( get_query_var( 'adatto_bambini' ), '1' ); ?>
                                />
                                <span><?php esc_html_e( 'Adatto ai bambini', 'caniincasa' ); ?></span>
                            </label>
                        </div>

                        <!-- Tipologia (Taxonomy) -->
                        <?php
                        $tipologie = get_terms( array(
                            'taxonomy' => 'tipologia_di_cani',
                            'hide_empty' => true,
                        ) );
                        if ( ! empty( $tipologie ) && ! is_wp_error( $tipologie ) ) :
                        ?>
                            <div class="filter-group">
                                <label for="filter-tipologia"><?php esc_html_e( 'Tipologia', 'caniincasa' ); ?></label>
                                <select id="filter-tipologia" name="tipologia_di_cani" class="form-control">
                                    <option value=""><?php esc_html_e( 'Tutte le tipologie', 'caniincasa' ); ?></option>
                                    <?php
                                    $selected_tipologia = get_query_var( 'tipologia_di_cani' );
                                    foreach ( $tipologie as $tipologia ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $tipologia->slug ); ?>" <?php selected( $selected_tipologia, $tipologia->slug ); ?>>
                                            <?php echo esc_html( $tipologia->name ); ?> (<?php echo esc_html( $tipologia->count ); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Paese Origine -->
                        <div class="filter-group">
                            <label for="filter-origine"><?php esc_html_e( 'Paese di Origine', 'caniincasa' ); ?></label>
                            <input
                                type="text"
                                id="filter-origine"
                                name="paese_origine"
                                class="form-control"
                                placeholder="<?php esc_attr_e( 'Es: Italia, Germania...', 'caniincasa' ); ?>"
                                value="<?php echo esc_attr( get_query_var( 'paese_origine' ) ); ?>"
                            />
                        </div>

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

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            global $wp_query;
                            printf(
                                esc_html( _n( '%d razza trovata', '%d razze trovate', $wp_query->found_posts, 'caniincasa' ) ),
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
                                <option value="title-desc" <?php selected( get_query_var( 'orderby' ), 'title-desc' ); ?>>
                                    <?php esc_html_e( 'Nome Z-A', 'caniincasa' ); ?>
                                </option>
                                <option value="date" <?php selected( get_query_var( 'orderby' ), 'date' ); ?>>
                                    <?php esc_html_e( 'Più recenti', 'caniincasa' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="razze-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card razza-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <!-- Taglia Badge -->
                                    <?php
                                    $taglia = get_field( 'taglia' );
                                    if ( $taglia ) :
                                    ?>
                                        <span class="razza-card__badge razza-card__badge--<?php echo esc_attr( $taglia ); ?>">
                                            <?php echo esc_html( ucfirst( $taglia ) ); ?>
                                        </span>
                                    <?php endif; ?>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Quick Characteristics -->
                                    <div class="razza-card__characteristics">
                                        <?php
                                        $altezza = get_field( 'altezza_cm' );
                                        $peso = get_field( 'peso_kg' );
                                        $aspettativa = get_field( 'aspettativa_vita_anni' );

                                        if ( $altezza ) :
                                            echo '<span class="characteristic"><span class="icon">📏</span> ' . esc_html( $altezza ) . ' cm</span>';
                                        endif;

                                        if ( $peso ) :
                                            echo '<span class="characteristic"><span class="icon">⚖️</span> ' . esc_html( $peso ) . ' kg</span>';
                                        endif;

                                        if ( $aspettativa ) :
                                            echo '<span class="characteristic"><span class="icon">🎂</span> ' . esc_html( $aspettativa ) . ' anni</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <!-- Taxonomies -->
                                    <?php
                                    $terms = get_the_terms( get_the_ID(), 'tipologia_di_cani' );
                                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
                                    ?>
                                        <div class="card-tags">
                                            <?php
                                            foreach ( $terms as $term ) :
                                                echo '<a href="' . esc_url( get_term_link( $term ) ) . '" class="tag">' . esc_html( $term->name ) . '</a>';
                                            endforeach;
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                            <?php esc_html_e( 'Scopri di più', 'caniincasa' ); ?>
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
                        <div class="no-results__icon">🔍</div>
                        <h2><?php esc_html_e( 'Nessuna razza trovata', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare con criteri diversi.', 'caniincasa' ); ?></p>
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
