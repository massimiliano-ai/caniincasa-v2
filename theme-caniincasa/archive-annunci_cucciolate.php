<?php
/**
 * Archive Template for Annunci Cucciolate (Litter Announcements)
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
                <?php esc_html_e( 'Annunci', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova cuccioli disponibili da allevamenti certificati. Scegli la razza e la zona che preferisci.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Annunci', 'caniincasa' ); ?></h2>

                    <form id="cucciolate-filter-form" class="filter-form" method="get">

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

                        <!-- Razza -->
                        <?php
                        $razze = get_terms( array(
                            'taxonomy' => 'razze_allevamenti',
                            'hide_empty' => true,
                            'number' => 100,
                        ) );
                        if ( ! empty( $razze ) && ! is_wp_error( $razze ) ) :
                        ?>
                            <div class="filter-group">
                                <label for="filter-razza"><?php esc_html_e( 'Razza', 'caniincasa' ); ?></label>
                                <select id="filter-razza" name="razze_allevamenti" class="form-control">
                                    <option value=""><?php esc_html_e( 'Tutte le razze', 'caniincasa' ); ?></option>
                                    <?php
                                    $selected_razza = get_query_var( 'razze_allevamenti' );
                                    foreach ( $razze as $razza ) :
                                    ?>
                                        <option value="<?php echo esc_attr( $razza->slug ); ?>" <?php selected( $selected_razza, $razza->slug ); ?>>
                                            <?php echo esc_html( $razza->name ); ?> (<?php echo esc_html( $razza->count ); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <!-- Tipo Annuncio -->
                        <div class="filter-group">
                            <label for="filter-tipo"><?php esc_html_e( 'Tipo Annuncio', 'caniincasa' ); ?></label>
                            <select id="filter-tipo" name="ricerca_offerta" class="form-control">
                                <option value=""><?php esc_html_e( 'Tutti i tipi', 'caniincasa' ); ?></option>
                                <option value="offerta" <?php selected( get_query_var( 'ricerca_offerta' ), 'offerta' ); ?>>
                                    <?php esc_html_e( 'Offro cuccioli', 'caniincasa' ); ?>
                                </option>
                                <option value="ricerca" <?php selected( get_query_var( 'ricerca_offerta' ), 'ricerca' ); ?>>
                                    <?php esc_html_e( 'Cerco cucciolo', 'caniincasa' ); ?>
                                </option>
                            </select>
                        </div>

                        <!-- Disponibilità -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Disponibilità cuccioli', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="cuccioli_disponibili"
                                        value="1"
                                        <?php checked( get_query_var( 'cuccioli_disponibili' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Cuccioli disponibili ora', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="prenotazione_disponibile"
                                        value="1"
                                        <?php checked( get_query_var( 'prenotazione_disponibile' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Prenotazione possibile', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Sesso -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Sesso', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="disponibili_maschi"
                                        value="1"
                                        <?php checked( get_query_var( 'disponibili_maschi' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Maschi', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="disponibili_femmine"
                                        value="1"
                                        <?php checked( get_query_var( 'disponibili_femmine' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Femmine', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Fascia Prezzo -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Fascia di prezzo (€)', 'caniincasa' ); ?></label>
                            <div class="price-range">
                                <input
                                    type="number"
                                    name="prezzo_min"
                                    class="form-control form-control-sm"
                                    placeholder="Min"
                                    value="<?php echo esc_attr( get_query_var( 'prezzo_min' ) ); ?>"
                                />
                                <span>-</span>
                                <input
                                    type="number"
                                    name="prezzo_max"
                                    class="form-control form-control-sm"
                                    placeholder="Max"
                                    value="<?php echo esc_attr( get_query_var( 'prezzo_max' ) ); ?>"
                                />
                            </div>
                        </div>

                        <!-- Documenti -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Documenti inclusi', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="pedigree_disponibile"
                                        value="1"
                                        <?php checked( get_query_var( 'pedigree_disponibile' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Pedigree', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="microchip_incluso"
                                        value="1"
                                        <?php checked( get_query_var( 'microchip_incluso' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Microchip', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="vaccini_inclusi"
                                        value="1"
                                        <?php checked( get_query_var( 'vaccini_inclusi' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Vaccinazioni', 'caniincasa' ); ?></span>
                                </label>
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
                                esc_html( _n( '%d annuncio trovato', '%d annunci trovati', $wp_query->found_posts, 'caniincasa' ) ),
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

                    <div class="cucciolate-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card cucciolata-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <div class="card-badges">
                                        <?php
                                        $ricerca_offerta = get_field( 'ricerca_offerta' );
                                        if ( $ricerca_offerta === 'offerta' ) :
                                        ?>
                                            <span class="badge badge--offerta">Offerta</span>
                                        <?php elseif ( $ricerca_offerta === 'ricerca' ) : ?>
                                            <span class="badge badge--ricerca">Ricerca</span>
                                        <?php endif; ?>

                                        <?php if ( get_field( 'cuccioli_disponibili' ) ) : ?>
                                            <span class="badge badge--available">✓ Disponibili</span>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Razza -->
                                    <?php
                                    $razze_terms = get_the_terms( get_the_ID(), 'razze_allevamenti' );
                                    if ( ! empty( $razze_terms ) && ! is_wp_error( $razze_terms ) ) :
                                    ?>
                                        <div class="cucciolata-breed">
                                            <strong><?php esc_html_e( 'Razza:', 'caniincasa' ); ?></strong>
                                            <?php echo esc_html( $razze_terms[0]->name ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Info Cards -->
                                    <div class="cucciolata-info-grid">
                                        <?php
                                        $data_nascita = get_field( 'data_nascita' );
                                        $cuccioli_disponibili_num = get_field( 'numero_cuccioli_disponibili' );
                                        $prezzo = get_field( 'prezzo' );

                                        if ( $data_nascita ) :
                                        ?>
                                            <div class="info-card">
                                                <span class="icon">📅</span>
                                                <span class="label"><?php esc_html_e( 'Nascita', 'caniincasa' ); ?></span>
                                                <span class="value"><?php echo esc_html( date_i18n( 'd/m/Y', strtotime( $data_nascita ) ) ); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ( $cuccioli_disponibili_num ) : ?>
                                            <div class="info-card">
                                                <span class="icon">🐕</span>
                                                <span class="label"><?php esc_html_e( 'Disponibili', 'caniincasa' ); ?></span>
                                                <span class="value"><?php echo esc_html( $cuccioli_disponibili_num ); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ( $prezzo ) : ?>
                                            <div class="info-card price-card">
                                                <span class="icon">💰</span>
                                                <span class="label"><?php esc_html_e( 'Prezzo', 'caniincasa' ); ?></span>
                                                <span class="value">€<?php echo esc_html( number_format( $prezzo, 0, ',', '.' ) ); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Location -->
                                    <?php
                                    $citta = get_field( 'citta' );
                                    $provincia_terms = get_the_terms( get_the_ID(), 'provincia' );
                                    if ( $citta || $provincia_terms ) :
                                    ?>
                                        <div class="cucciolata-location">
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

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-block">
                                            <?php esc_html_e( 'Vedi Dettagli', 'caniincasa' ); ?>
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
                        <div class="no-results__icon">🐶</div>
                        <h2><?php esc_html_e( 'Nessun annuncio trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare un\'altra razza o zona.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
