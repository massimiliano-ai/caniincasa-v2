<?php
/**
 * Archive Template for Patologie Canine (Dog Diseases)
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
                <?php esc_html_e( 'Patologie Canine', 'caniincasa' ); ?>
            </h1>
            <p class="archive-description">
                <?php esc_html_e( 'Informazioni complete sulle patologie canine, sintomi, cure e prevenzione. Consulta sempre un veterinario per diagnosi e trattamento.', 'caniincasa' ); ?>
            </p>
        </header>

        <div class="archive-layout archive-layout--with-filters">
            <!-- Filters Sidebar -->
            <aside class="archive-filters">
                <div class="filters-sticky">
                    <h2 class="filters-title"><?php esc_html_e( 'Filtra Patologie', 'caniincasa' ); ?></h2>

                    <form id="patologie-filter-form" class="filter-form" method="get">

                        <!-- Search by Name -->
                        <div class="filter-group">
                            <label for="filter-search"><?php esc_html_e( 'Cerca patologia', 'caniincasa' ); ?></label>
                            <input
                                type="text"
                                id="filter-search"
                                name="search_patologia"
                                class="form-control"
                                placeholder="<?php esc_attr_e( 'Nome patologia...', 'caniincasa' ); ?>"
                                value="<?php echo esc_attr( get_query_var( 'search_patologia' ) ); ?>"
                            />
                        </div>

                        <!-- Gravità -->
                        <div class="filter-group">
                            <label for="filter-gravita"><?php esc_html_e( 'Gravità', 'caniincasa' ); ?></label>
                            <select id="filter-gravita" name="gravita" class="form-control">
                                <option value=""><?php esc_html_e( 'Tutte', 'caniincasa' ); ?></option>
                                <?php
                                $gravita_levels = array(
                                    'lieve' => 'Lieve',
                                    'moderata' => 'Moderata',
                                    'grave' => 'Grave',
                                    'critica' => 'Critica',
                                );
                                $selected_gravita = get_query_var( 'gravita' );
                                foreach ( $gravita_levels as $value => $label ) :
                                ?>
                                    <option value="<?php echo esc_attr( $value ); ?>" <?php selected( $selected_gravita, $value ); ?>>
                                        <?php echo esc_html( $label ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Categoria -->
                        <div class="filter-group">
                            <label><?php esc_html_e( 'Categoria', 'caniincasa' ); ?></label>
                            <div class="checkbox-group checkbox-group--scrollable">
                                <?php
                                $categorie = array(
                                    'infettive' => 'Malattie Infettive',
                                    'parassitarie' => 'Malattie Parassitarie',
                                    'genetiche' => 'Malattie Genetiche',
                                    'ortopediche' => 'Problemi Ortopedici',
                                    'dermatologiche' => 'Problemi Dermatologici',
                                    'gastrointestinali' => 'Problemi Gastrointestinali',
                                    'respiratorie' => 'Problemi Respiratori',
                                    'cardiache' => 'Problemi Cardiaci',
                                    'neurologiche' => 'Problemi Neurologici',
                                    'endocrine' => 'Problemi Endocrini',
                                );
                                $selected_categorie = (array) get_query_var( 'categoria_patologia' );
                                foreach ( $categorie as $value => $label ) :
                                ?>
                                    <label class="checkbox-label">
                                        <input
                                            type="checkbox"
                                            name="categoria_patologia[]"
                                            value="<?php echo esc_attr( $value ); ?>"
                                            <?php checked( in_array( $value, $selected_categorie ) ); ?>
                                        />
                                        <span><?php echo esc_html( $label ); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Razze Predisposte -->
                        <div class="filter-group">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="predisposizione_razza"
                                    value="1"
                                    <?php checked( get_query_var( 'predisposizione_razza' ), '1' ); ?>
                                />
                                <span><?php esc_html_e( 'Solo con predisposizione di razza', 'caniincasa' ); ?></span>
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

                    <div class="archive-results-header">
                        <p class="results-count">
                            <?php
                            global $wp_query;
                            printf(
                                esc_html( _n( '%d patologia trovata', '%d patologie trovate', $wp_query->found_posts, 'caniincasa' ) ),
                                number_format_i18n( $wp_query->found_posts )
                            );
                            ?>
                        </p>
                    </div>

                    <div class="patologie-list">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article class="patologia-card card">
                                <div class="card-content">
                                    <?php
                                    $gravita = get_field( 'gravita' );
                                    if ( $gravita ) :
                                        $gravita_class = 'gravita-' . $gravita;
                                    ?>
                                        <span class="badge badge--<?php echo esc_attr( $gravita_class ); ?>">
                                            <?php echo esc_html( ucfirst( $gravita ) ); ?>
                                        </span>
                                    <?php endif; ?>

                                    <h2 class="card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>

                                    <div class="card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                                    </div>

                                    <?php
                                    $sintomi = get_field( 'sintomi_principali' );
                                    if ( $sintomi ) :
                                    ?>
                                        <div class="patologia-symptoms">
                                            <strong><?php esc_html_e( 'Sintomi principali:', 'caniincasa' ); ?></strong>
                                            <p><?php echo esc_html( wp_trim_words( $sintomi, 15 ) ); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <div class="card-footer">
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                            <?php esc_html_e( 'Scopri di più', 'caniincasa' ); ?>
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
                        <div class="no-results__icon">🔍</div>
                        <h2><?php esc_html_e( 'Nessuna patologia trovata', 'caniincasa' ); ?></h2>
                        <p><?php esc_html_e( 'Prova a modificare i filtri o a cercare con criteri diversi.', 'caniincasa' ); ?></p>
                    </div>

                <?php endif; ?>
            </div>

        </div>

        <!-- Medical Disclaimer -->
        <div class="medical-disclaimer">
            <div class="alert alert--warning">
                <strong>⚠️ <?php esc_html_e( 'Disclaimer Medico', 'caniincasa' ); ?></strong>
                <p><?php esc_html_e( 'Le informazioni fornite hanno solo scopo educativo. Non sostituiscono in alcun modo la consulenza, diagnosi o trattamento di un veterinario qualificato. In caso di sintomi o dubbi sulla salute del tuo cane, contatta immediatamente un veterinario.', 'caniincasa' ); ?></p>
            </div>
        </div>

    </div>
</main>

<?php get_footer(); ?>
