<?php
/**
 * Template Name: Canili - Griglia
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-canili">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Hero Section -->
        <div class="page-hero">
            <h1 class="page-title">
                <?php echo esc_html( get_the_title() ); ?>
            </h1>
            <?php if ( get_the_content() ): ?>
                <div class="page-intro">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Filtri Zona -->
        <div class="filters-wrapper">
            <h3 class="filters-title">Filtra per zona</h3>
            <div class="filters-row">
                <div class="filter-group">
                    <label for="filter-provincia">Provincia:</label>
                    <select id="filter-provincia" class="filter-select" data-post-type="canili">
                        <option value="">Tutte le province</option>
                        <?php
                        $province = get_terms( array(
                            'taxonomy' => 'provincia',
                            'hide_empty' => true,
                            'orderby' => 'name',
                            'order' => 'ASC',
                        ) );
                        foreach ( $province as $provincia ):
                        ?>
                            <option value="<?php echo $provincia->term_id; ?>">
                                <?php echo esc_html( $provincia->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button id="reset-filters" class="btn btn-outline">Ripristina filtri</button>
            </div>
        </div>

        <?php
        // Query per tutti i canili
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        $args = array(
            'post_type' => 'canili',
            'post_status' => 'publish',
            'posts_per_page' => 12,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        $canili_query = new WP_Query( $args );
        ?>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="loading-spinner" style="display:none;">
            <div class="spinner"></div>
            <p>Caricamento...</p>
        </div>

        <!-- Results Count -->
        <div class="results-info">
            <p class="results-count">
                Trovati <strong><?php echo $canili_query->found_posts; ?></strong> canili
                <?php if ( $canili_query->max_num_pages > 1 ): ?>
                    (Pagina <?php echo $paged; ?> di <?php echo $canili_query->max_num_pages; ?>)
                <?php endif; ?>
            </p>
        </div>

        <?php if ( $canili_query->have_posts() ): ?>

            <!-- Canili Grid -->
            <div class="items-grid" id="items-grid">

                <?php while ( $canili_query->have_posts() ): $canili_query->the_post(); ?>

                    <div class="item-card">

                        <!-- Image -->
                        <?php if ( has_post_thumbnail() ): ?>
                            <div class="item-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium_large', array(
                                        'loading' => 'lazy',
                                        'alt' => get_the_title()
                                    ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="item-content">

                            <h3 class="item-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <?php
                            // Provincia
                            $province = wp_get_post_terms( get_the_ID(), 'provincia' );
                            if ( ! empty( $province ) && ! is_wp_error( $province ) ):
                            ?>
                                <div class="item-location">
                                    <span class="icon">📍</span>
                                    <span class="text"><?php echo esc_html( $province[0]->name ); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Indirizzo
                            $indirizzo = get_field( 'indirizzo' );
                            $citta = get_field( 'citta' );
                            if ( $indirizzo || $citta ):
                            ?>
                                <div class="item-address">
                                    <span class="icon">🏠</span>
                                    <span class="text">
                                        <?php
                                        if ( $indirizzo ) {
                                            echo esc_html( $indirizzo );
                                            if ( $citta ) echo ', ';
                                        }
                                        if ( $citta ) echo esc_html( $citta );
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Excerpt
                            if ( has_excerpt() ):
                            ?>
                                <div class="item-excerpt">
                                    <?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
                                </div>
                            <?php endif; ?>

                            <?php
                            // Contatti (protetti - solo per utenti registrati)
                            $telefono = get_field( 'telefono_principale' ) ?: get_field( 'telefono' );
                            $email = get_field( 'email' );
                            $sito_web = get_field( 'sito_web' );

                            if ( $telefono || $email || $sito_web ):
                            ?>
                                <div class="item-contacts">
                                    <?php if ( caniincasa_can_view_contacts() ): ?>
                                        <?php if ( $telefono ): ?>
                                            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $telefono ) ); ?>" class="contact-item" title="Telefono">
                                                <span class="icon">📞</span>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ( $email ): ?>
                                            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-item" title="Email">
                                                <span class="icon">✉️</span>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ( $sito_web ): ?>
                                            <a href="<?php echo esc_url( $sito_web ); ?>" target="_blank" rel="noopener" class="contact-item" title="Sito web">
                                                <span class="icon">🌐</span>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="protected-contact-message">
                                            <span class="icon">🔒</span>
                                            <a href="<?php echo home_url( '/registrati/' ); ?>">Registrati per vedere i contatti</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- View More Button -->
                            <a href="<?php the_permalink(); ?>" class="btn-view-more">
                                Visualizza dettagli
                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

            <!-- Pagination -->
            <?php if ( $canili_query->max_num_pages > 1 ): ?>
                <div class="pagination-wrapper">
                    <?php
                    echo paginate_links( array(
                        'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, $paged ),
                        'total' => $canili_query->max_num_pages,
                        'prev_text' => '&laquo; Precedente',
                        'next_text' => 'Successiva &raquo;',
                        'type' => 'list',
                    ) );
                    ?>
                </div>
            <?php endif; ?>

        <?php else: ?>

            <!-- No Results -->
            <div class="no-items">
                <div class="no-items-icon">🏠</div>
                <h3>Nessun canile trovato</h3>
                <p>Non ci sono canili pubblicati al momento.</p>
            </div>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>

</main>

<?php get_footer(); ?>
