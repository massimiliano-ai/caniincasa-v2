<?php
/**
 * Archive Template for FAQ
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
                <?php esc_html_e( 'Domande Frequenti (FAQ)', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova risposte alle domande più frequenti su cani, razze, addestramento, salute e molto altro.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra FAQ', 'caniincasa' ); ?></h2>

                    <form id="faq-filter-form" class="filter-form" method="get">

                        <!-- Search -->
                        <div class="filter-group">
                            <label for="filter-search"><?php esc_html_e( 'Cerca domanda', 'caniincasa' ); ?></label>
                            <input
                                type="text"
                                id="filter-search"
                                name="search_faq"
                                class="form-control"
                                placeholder="<?php esc_attr_e( 'Parole chiave...', 'caniincasa' ); ?>"
                                value="<?php echo esc_attr( get_query_var( 'search_faq' ) ); ?>"
                            />
                        </div>

                        <!-- Categoria FAQ (Taxonomy) -->
                        <?php
                        $categorie_faq = get_terms( array(
                            'taxonomy' => 'categoria_faq',
                            'hide_empty' => true,
                        ) );
                        if ( ! empty( $categorie_faq ) && ! is_wp_error( $categorie_faq ) ) :
                        ?>
                            <div class="filter-group">
                                <label><?php esc_html_e( 'Categoria', 'caniincasa' ); ?></label>
                                <div class="checkbox-group checkbox-group--scrollable">
                                    <?php
                                    $selected_categorie = (array) get_query_var( 'categoria_faq' );
                                    foreach ( $categorie_faq as $categoria ) :
                                    ?>
                                        <label class="checkbox-label">
                                            <input
                                                type="checkbox"
                                                name="categoria_faq[]"
                                                value="<?php echo esc_attr( $categoria->slug ); ?>"
                                                <?php checked( in_array( $categoria->slug, $selected_categorie ) ); ?>
                                            />
                                            <span><?php echo esc_html( $categoria->name ); ?> (<?php echo esc_html( $categoria->count ); ?>)</span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Argomento -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Argomento', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <?php
                                $argomenti = array(
                                    'salute' => 'Salute',
                                    'alimentazione' => 'Alimentazione',
                                    'comportamento' => 'Comportamento',
                                    'addestramento' => 'Addestramento',
                                    'razze' => 'Razze',
                                    'cuccioli' => 'Cuccioli',
                                    'legislazione' => 'Legislazione',
                                    'viaggi' => 'Viaggi',
                                );
                                $selected_argomenti = (array) get_query_var( 'argomento' );
                                foreach ( $argomenti as $value => $label ) :
                                ?>
                                    <label class="checkbox-label">
                                        <input
                                            type="checkbox"
                                            name="argomento[]"
                                            value="<?php echo esc_attr( $value ); ?>"
                                            <?php checked( in_array( $value, $selected_argomenti ) ); ?>
                                        />
                                        <span><?php echo esc_html( $label ); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
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
                                esc_html( _n( '%d domanda trovata', '%d domande trovate', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                    </div>

                    <div class="faq-list">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article class="faq-card card">
                                <div class="card-content">
                                    <div class="faq-icon">❓</div>

                                    <h2 class="card-title faq-question">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>

                                    <?php
                                    $terms = get_the_terms( get_the_ID(), 'categoria_faq' );
                                    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
                                    ?>
                                        <div class="card-tags">
                                            <?php
                                            foreach ( $terms as $term ) :
                                                echo '<span class="tag">' . esc_html( $term->name ) . '</span>';
                                            endforeach;
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="faq-answer-preview">
                                        <?php echo wp_trim_words( get_the_excerpt(), 25 ); ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm">
                                            <?php esc_html_e( 'Leggi risposta completa', 'caniincasa' ); ?> →
                                        </a>
                                    </div>
                                </div>
                            </article>
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
                        <div class="no-results__icon">❓</div>
                        <h2><?php esc_html_e( 'Nessuna FAQ trovata', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare con parole diverse.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
