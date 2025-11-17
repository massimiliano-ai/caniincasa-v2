<?php
/**
 * Archive Template for Annunci Dogsitter
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
                <?php esc_html_e( 'Dog Sitter Disponibili', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova dog sitter qualificati e affidabili nella tua zona per la cura del tuo cane.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Dog Sitter', 'caniincasa' ); ?></h2>

                    <form id="dogsitter-filter-form" class="filter-form" method="get">

                        <!-- Provincia -->
                        <?php
                        $province = get_terms( array(
                            'taxonomy' => 'provincia',
                            'hide_empty' => true,
                        ) );
                        if ( ! empty( $province ) && ! is_wp_error( $province ) ) :
                        ?>
                            <div class="filter-group">
                                <label for="filter-provincia"><?php esc_html_e( 'Provincia', 'caniincasa' ); ?></label>
                                <select id="filter-provincia" name="provincia" class="form-control">
                                    <option value=""><?php esc_html_e( 'Tutte le province', 'caniincasa' ); ?></option>
                                    <?php
                                    $selected_provincia = get_query_var( 'provincia' );
                                    foreach ( $province as $provincia ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $provincia->slug ); ?>" <?php selected( $selected_provincia, $provincia->slug ); ?>>
                                            <?php echo esc_html( $provincia->name ); ?> (<?php echo esc_html( $provincia->count ); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Disponibilità -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Disponibilità', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="disponibile_weekend"
                                        value="1"
                                        <?php checked( get_query_var( 'disponibile_weekend' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Disponibile weekend', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="disponibile_notte"
                                        value="1"
                                        <?php checked( get_query_var( 'disponibile_notte' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Disponibile notte', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="disponibile_urgenze"
                                        value="1"
                                        <?php checked( get_query_var( 'disponibile_urgenze' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Urgenze', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Servizi Offerti -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Servizi offerti', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_passeggiata"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_passeggiata' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Passeggiate', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_casa_cliente"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_casa_cliente' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'A casa del cliente', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_casa_sitter"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_casa_sitter' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'A casa del dog sitter', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="servizio_addestramento"
                                        value="1"
                                        <?php checked( get_query_var( 'servizio_addestramento' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Addestramento base', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Esperienza -->
                        <div class="filter-group">
                            <label for="filter-esperienza"><?php esc_html_e( 'Anni esperienza', 'caniincasa' ); ?></label>
                            <select id="filter-esperienza" name="anni_esperienza" class="form-control">
                                <option value=""><?php esc_html_e( 'Qualsiasi', 'caniincasa' ); ?></option>
                                <option value="1" <?php selected( get_query_var( 'anni_esperienza' ), '1' ); ?>>1+ anni</option>
                                <option value="3" <?php selected( get_query_var( 'anni_esperienza' ), '3' ); ?>>3+ anni</option>
                                <option value="5" <?php selected( get_query_var( 'anni_esperienza' ), '5' ); ?>>5+ anni</option>
                                <option value="10" <?php selected( get_query_var( 'anni_esperienza' ), '10' ); ?>>10+ anni</option>
                            </select>
                        </div>

                        <!-- Fascia Prezzo -->
                        <div class="filter-group">
                            <label for="filter-prezzo"><?php esc_html_e( 'Tariffa massima (€/ora)', 'caniincasa' ); ?></label>
                            <input
                                type="number"
                                id="filter-prezzo"
                                name="tariffa_max"
                                class="form-control"
                                min="5"
                                max="50"
                                step="5"
                                placeholder="€"
                                value="<?php echo esc_attr( get_query_var( 'tariffa_max' ) ); ?>"
                            />
                        </div>

                        <!-- Certificazioni -->
                        <div class="filter-group">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="certificato"
                                    value="1"
                                    <?php checked( get_query_var( 'certificato' ), '1' ); ?>
                                />
                                <span><?php esc_html_e( 'Solo certificati', 'caniincasa' ); ?></span>
                            </label>
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

                    <?php
                    // Pre-load caches for better performance
                    global $wp_query;
                    $post_ids = wp_list_pluck( $wp_query->posts, 'ID' );
                    update_post_caches( $wp_query->posts, 'annunci_dogsitter', true, true );
                    update_object_term_cache( $post_ids, 'annunci_dogsitter' );
                    ?>

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            printf(
                                esc_html( _n( '%d dog sitter trovato', '%d dog sitter trovati', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                        <div class="results-sort">
                            <label for="sort-order" class="sr-only"><?php esc_html_e( 'Ordina per', 'caniincasa' ); ?></label>
                            <select id="sort-order" name="orderby" class="form-control form-control-sm">
                                <option value="date" <?php selected( get_query_var( 'orderby' ), 'date' ); ?>>
                                    <?php esc_html_e( 'Più recenti', 'caniincasa' ); ?>
                                </option>
                                <option value="price-low" <?php selected( get_query_var( 'orderby' ), 'price-low' ); ?>>
                                    <?php esc_html_e( 'Prezzo crescente', 'caniincasa' ); ?>
                                </option>
                                <option value="price-high" <?php selected( get_query_var( 'orderby' ), 'price-high' ); ?>>
                                    <?php esc_html_e( 'Prezzo decrescente', 'caniincasa' ); ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="dogsitter-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card dogsitter-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <?php if ( get_field( 'certificato' ) ) : ?>
                                        <span class="badge badge--certified">✓ Certificato</span>
                                    <?php endif; ?>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Location -->
                                    <?php
                                    $citta = get_field( 'citta' );
                                    $provincia_terms = get_the_terms( get_the_ID(), 'provincia' );
                                    if ( $citta || $provincia_terms ) :
                                    ?>
                                        <div class="dogsitter-location">
                                            <span class="icon">📍</span>
                                            <?php
                                            if ( $citta ) {
                                                echo esc_html( $citta );
                                            }
                                            if ( $provincia_terms && ! is_wp_error( $provincia_terms ) ) {
                                                echo ' (' . esc_html( $provincia_terms[0]->name ) . ')';
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Experience & Rate -->
                                    <div class="dogsitter-info">
                                        <?php
                                        $esperienza = get_field( 'anni_esperienza' );
                                        $tariffa = get_field( 'tariffa_oraria' );

                                        if ( $esperienza ) :
                                            echo '<span class="info-item"><strong>Esperienza:</strong> ' . esc_html( $esperienza ) . ' anni</span>';
                                        endif;

                                        if ( $tariffa ) :
                                            echo '<span class="info-item price"><strong>€' . esc_html( number_format( $tariffa, 2 ) ) . '</strong>/ora</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 15 ); ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                            <?php esc_html_e( 'Visualizza Profilo', 'caniincasa' ); ?>
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
                        <div class="no-results__icon">🐕</div>
                        <h2><?php esc_html_e( 'Nessun dog sitter trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare in un\'altra zona.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
