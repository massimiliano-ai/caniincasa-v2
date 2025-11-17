<?php
/**
 * Archive Template for Strutture Veterinarie (Veterinary Clinics)
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
                <?php esc_html_e( 'Veterinari e Strutture Veterinarie', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova veterinari, cliniche e ospedali veterinari nella tua zona. Filtra per servizi, orari e provincia.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Veterinari', 'caniincasa' ); ?></h2>

                    <form id="veterinari-filter-form" class="filter-form" method="get">

                        <!-- Search by Name -->
                        <div class="filter-group">
                            <label for="filter-search"><?php esc_html_e( 'Cerca per nome', 'caniincasa' ); ?></label>
                            <input
                                type="text"
                                id="filter-search"
                                name="search_veterinario"
                                class="form-control"
                                placeholder="<?php esc_attr_e( 'Nome struttura o veterinario...', 'caniincasa' ); ?>"
                                value="<?php echo esc_attr( get_query_var( 'search_veterinario' ) ); ?>"
                            />
                        </div>

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

                        <!-- Servizi Veterinari (Taxonomy) -->
                        <?php
                        $servizi = get_terms( array(
                            'taxonomy' => 'servizi_veterinari',
                            'hide_empty' => true,
                        ) );
                        if ( ! empty( $servizi ) && ! is_wp_error( $servizi ) ) :
                        ?>
                            <div class="filter-group">
                                <label><?php esc_html_e( 'Servizi disponibili', 'caniincasa' ); ?></label>
                                <div class="checkbox-group checkbox-group--scrollable">
                                    <?php
                                    $selected_servizi = (array) get_query_var( 'servizi_veterinari' );
                                    foreach ( $servizi as $servizio ) :
                                    ?>
                                        <label class="checkbox-label">
                                            <input
                                                type="checkbox"
                                                name="servizi_veterinari[]"
                                                value="<?php echo esc_attr( $servizio->slug ); ?>"
                                                <?php checked( in_array( $servizio->slug, $selected_servizi ) ); ?>
                                            />
                                            <span><?php echo esc_html( $servizio->name ); ?> (<?php echo esc_html( $servizio->count ); ?>)</span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Tipologia Struttura -->
                        <div class="filter-group">
                            <label for="filter-tipologia"><?php esc_html_e( 'Tipo struttura', 'caniincasa' ); ?></label>
                            <select id="filter-tipologia" name="tipo_struttura" class="form-control">
                                <option value=""><?php esc_html_e( 'Tutte le tipologie', 'caniincasa' ); ?></option>
                                <?php
                                $tipologie = array(
                                    'ambulatorio' => 'Ambulatorio Veterinario',
                                    'clinica' => 'Clinica Veterinaria',
                                    'ospedale' => 'Ospedale Veterinario',
                                    'veterinario-mobile' => 'Veterinario a Domicilio',
                                );
                                $selected_tipologia = get_query_var( 'tipo_struttura' );
                                foreach ( $tipologie as $value => $label ) :
                                ?>
                                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_tipologia, $value ); ?>>
                                        <?php echo esc_html( $label ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Caratteristiche Speciali -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Caratteristiche', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="pronto_soccorso"
                                        value="1"
                                        <?php checked( get_query_var( 'pronto_soccorso' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Pronto Soccorso 24/7', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="aperto_weekend"
                                        value="1"
                                        <?php checked( get_query_var( 'aperto_weekend' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Aperto nel weekend', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="visite_domicilio"
                                        value="1"
                                        <?php checked( get_query_var( 'visite_domicilio' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Visite a domicilio', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="chirurgia_disponibile"
                                        value="1"
                                        <?php checked( get_query_var( 'chirurgia_disponibile' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Chirurgia disponibile', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="diagnostica_avanzata"
                                        value="1"
                                        <?php checked( get_query_var( 'diagnostica_avanzata' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Diagnostica avanzata', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Pagamento -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Metodi di pagamento', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="accetta_carte"
                                        value="1"
                                        <?php checked( get_query_var( 'accetta_carte' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Accetta carte', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="accetta_ticket"
                                        value="1"
                                        <?php checked( get_query_var( 'accetta_ticket' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Accetta ticket veterinari', 'caniincasa' ); ?></span>
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

                    <?php
                    // Pre-load caches for better performance
                    global $wp_query;
                    $post_ids = wp_list_pluck( $wp_query->posts, 'ID' );
                    update_post_caches( $wp_query->posts, 'struttureveterinarie', true, true );
                    update_object_term_cache( $post_ids, 'struttureveterinarie' );
                    ?>

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            printf(
                                esc_html( _n( '%d struttura veterinaria trovata', '%d strutture veterinarie trovate', $wp_query->found_posts, 'caniincasa' ) ),
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

                    <div class="veterinari-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card veterinario-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <!-- Badges -->
                                    <div class="veterinario-card__badges">
                                        <?php
                                        if ( get_field( 'pronto_soccorso' ) ) :
                                            echo '<span class="badge badge--emergency">Emergenza 24/7</span>';
                                        endif;
                                        $tipo_struttura = get_field( 'tipo_struttura' );
                                        if ( $tipo_struttura ) :
                                            $tipo_label = array(
                                                'ambulatorio' => 'Ambulatorio',
                                                'clinica' => 'Clinica',
                                                'ospedale' => 'Ospedale',
                                                'veterinario-mobile' => 'Domicilio',
                                            );
                                            echo '<span class="badge badge--type">' . esc_html( $tipo_label[ $tipo_struttura ] ?? $tipo_struttura ) . '</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Location -->
                                    <?php
                                    $indirizzo = get_field( 'indirizzo' );
                                    $citta = get_field( 'citta' );
                                    $provincia_terms = get_the_terms( get_the_ID(), 'provincia' );
                                    if ( $indirizzo || $citta || $provincia_terms ) :
                                    ?>
                                        <div class="veterinario-card__location">
                                            <span class="icon">📍</span>
                                            <?php
                                            if ( $indirizzo ) {
                                                echo esc_html( $indirizzo ) . '<br>';
                                            }
                                            if ( $citta ) {
                                                echo esc_html( $citta );
                                            }
                                            if ( $provincia_terms && ! is_wp_error( $provincia_terms ) ) {
                                                echo ' (' . esc_html( $provincia_terms[0]->name ) . ')';
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Servizi -->
                                    <?php
                                    $servizi_terms = get_the_terms( get_the_ID(), 'servizi_veterinari' );
                                    if ( ! empty( $servizi_terms ) && ! is_wp_error( $servizi_terms ) ) :
                                    ?>
                                        <div class="veterinario-card__services">
                                            <strong><?php esc_html_e( 'Servizi:', 'caniincasa' ); ?></strong>
                                            <div class="card-tags">
                                                <?php
                                                $count = 0;
                                                foreach ( $servizi_terms as $servizio_term ) :
                                                    if ( $count < 4 ) :
                                                        echo '<span class="tag">' . esc_html( $servizio_term->name ) . '</span>';
                                                        $count++;
                                                    endif;
                                                endforeach;
                                                if ( count( $servizi_terms ) > 4 ) :
                                                    echo '<span class="tag tag--more">+' . ( count( $servizi_terms ) - 4 ) . '</span>';
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Opening Hours -->
                                    <?php
                                    $orario_apertura = get_field( 'orario_apertura' );
                                    $orario_chiusura = get_field( 'orario_chiusura' );
                                    if ( $orario_apertura && $orario_chiusura ) :
                                    ?>
                                        <div class="veterinario-card__hours">
                                            <span class="icon">🕒</span>
                                            <?php printf( esc_html__( '%s - %s', 'caniincasa' ), esc_html( $orario_apertura ), esc_html( $orario_chiusura ) ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Contact Info -->
                                    <?php
                                    $telefono = get_field( 'telefono' );
                                    if ( $telefono ) :
                                    ?>
                                        <div class="veterinario-card__contact">
                                            <a href="tel:<?php echo esc_attr( $telefono ); ?>" class="contact-link">
                                                <span class="icon">📞</span>
                                                <?php echo esc_html( $telefono ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

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
                        <div class="no-results__icon">🏥</div>
                        <h2><?php esc_html_e( 'Nessuna struttura veterinaria trovata', 'caniincasa' ); ?></h2>
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
