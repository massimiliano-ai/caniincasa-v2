<?php
/**
 * Archive Template for Centri Cinofili (Dog Training Centers)
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
                <?php esc_html_e( 'Centri Cinofili e Addestramento', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Trova centri cinofili professionali per l\'addestramento e l\'educazione del tuo cane.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Centri', 'caniincasa' ); ?></h2>

                    <form id="centri-filter-form" class="filter-form" method="get">

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

                        <!-- Tipo Corso -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Tipo di corso', 'caniincasa' ); ?></label>
                            <div class="checkbox-group checkbox-group--scrollable">
                                <?php
                                $tipi_corso = array(
                                    'educazione-base' => 'Educazione di Base',
                                    'educazione-cuccioli' => 'Puppy Class',
                                    'obbedienza' => 'Obbedienza',
                                    'agility' => 'Agility',
                                    'disc-dog' => 'Disc Dog',
                                    'nose-work' => 'Nose Work',
                                    'rally-obedience' => 'Rally Obedience',
                                    'comportamento' => 'Problemi Comportamentali',
                                    'clicker-training' => 'Clicker Training',
                                    'preparazione-esami' => 'Preparazione Esami',
                                );
                                $selected_corsi = (array) get_query_var( 'tipo_corso' );
                                foreach ( $tipi_corso as $value => $label ) :
                                ?>
                                    <label class="checkbox-label">
                                        <input
                                            type="checkbox"
                                            name="tipo_corso[]"
                                            value="<?php echo esc_attr( $value ); ?>"
                                            <?php checked( in_array( $value, $selected_corsi ) ); ?>
                                        />
                                        <span><?php echo esc_html( $label ); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Certificazioni -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Certificazioni', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="certificato_enci"
                                        value="1"
                                        <?php checked( get_query_var( 'certificato_enci' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Certificato ENCI', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="istruttore_cinofilo"
                                        value="1"
                                        <?php checked( get_query_var( 'istruttore_cinofilo' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Istruttore Cinofilo', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="educatore_cinofilo"
                                        value="1"
                                        <?php checked( get_query_var( 'educatore_cinofilo' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Educatore Cinofilo', 'caniincasa' ); ?></span>
                                </label>
                            </div>
                        </div>

                        <!-- Servizi -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Servizi disponibili', 'caniincasa' ); ?></label>
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="lezioni_individuali"
                                        value="1"
                                        <?php checked( get_query_var( 'lezioni_individuali' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Lezioni individuali', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="corsi_gruppo"
                                        value="1"
                                        <?php checked( get_query_var( 'corsi_gruppo' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Corsi di gruppo', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="campo_coperto"
                                        value="1"
                                        <?php checked( get_query_var( 'campo_coperto' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Campo coperto', 'caniincasa' ); ?></span>
                                </label>
                                <label class="checkbox-label">
                                    <input
                                        type="checkbox"
                                        name="area_socializzazione"
                                        value="1"
                                        <?php checked( get_query_var( 'area_socializzazione' ), '1' ); ?>
                                    />
                                    <span><?php esc_html_e( 'Area socializzazione', 'caniincasa' ); ?></span>
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
                    update_post_caches( $wp_query->posts, 'centri_cinofili', true, true );
                    update_object_term_cache( $post_ids, 'centri_cinofili' );
                    ?>

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            printf(
                                esc_html( _n( '%d centro cinofilo trovato', '%d centri cinofili trovati', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                    </div>

                    <div class="centri-grid grid grid-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="card centro-card">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" class="card-image-link">
                                        <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image' ) ); ?>
                                    </a>
                                <?php endif; ?>

                                <div class="card-content">
                                    <!-- Badges -->
                                    <div class="centro-badges">
                                        <?php
                                        if ( get_field( 'certificato_enci' ) ) :
                                            echo '<span class="badge badge--enci">ENCI</span>';
                                        endif;
                                        if ( get_field( 'istruttore_cinofilo' ) ) :
                                            echo '<span class="badge badge--instructor">Istruttore</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <h3 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <!-- Location -->
                                    <?php
                                    $citta = get_field( 'citta' );
                                    $provincia_terms = get_the_terms( get_the_ID(), 'provincia' );
                                    if ( $citta || $provincia_terms ) :
                                    ?>
                                        <div class="centro-location">
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

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </div>

                                    <!-- Services Icons -->
                                    <div class="centro-services">
                                        <?php
                                        if ( get_field( 'lezioni_individuali' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Lezioni individuali', 'caniincasa' ) . '">👤</span>';
                                        endif;
                                        if ( get_field( 'corsi_gruppo' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Corsi di gruppo', 'caniincasa' ) . '">👥</span>';
                                        endif;
                                        if ( get_field( 'campo_coperto' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Campo coperto', 'caniincasa' ) . '">🏠</span>';
                                        endif;
                                        if ( get_field( 'area_socializzazione' ) ) :
                                            echo '<span class="service-icon" title="' . esc_attr__( 'Area socializzazione', 'caniincasa' ) . '">🐕</span>';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                            <?php esc_html_e( 'Visualizza Corsi', 'caniincasa' ); ?>
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
                        <div class="no-results__icon">🎓</div>
                        <h2><?php esc_html_e( 'Nessun centro cinofilo trovato', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare in un\'altra provincia.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

    </div>
</main>

<?php get_footer(); ?>
