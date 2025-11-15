<?php
/**
 * Template part for displaying razza card
 *
 * @package CaninCasa
 * @since 1.0.0
 */
?>

<div class="card razza-card">
    <?php if ( has_post_thumbnail() ) : ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail( 'caniincasa-card', array( 'class' => 'card-image', 'alt' => get_the_title() ) ); ?>
        </a>
    <?php endif; ?>

    <div class="card-content">
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if ( has_excerpt() ) : ?>
            <div class="card-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <!-- Quick Characteristics -->
        <div class="razza-card__characteristics">
            <?php
            $energia = get_post_meta( get_the_ID(), 'livello_di_energia', true );
            if ( $energia ) :
            ?>
                <div class="razza-card__char">
                    <span class="razza-card__char-label">Energia</span>
                    <span class="razza-card__char-value">
                        <?php
                        for ( $i = 0; $i < absint( $energia ); $i++ ) {
                            echo '★';
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php
            $bambini = get_post_meta( get_the_ID(), 'compatibilita_con_i_bambini', true );
            if ( $bambini ) :
            ?>
                <div class="razza-card__char">
                    <span class="razza-card__char-label">Con Bambini</span>
                    <span class="razza-card__char-value">
                        <?php
                        for ( $i = 0; $i < absint( $bambini ); $i++ ) {
                            echo '★';
                        }
                        ?>
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Taxonomies -->
        <?php
        $terms = get_the_terms( get_the_ID(), 'tipologia_di_cani' );
        if ( $terms && ! is_wp_error( $terms ) ) :
        ?>
            <div class="card-meta">
                <?php foreach ( $terms as $term ) : ?>
                    <span class="badge"><?php echo esc_html( $term->name ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="card-footer">
            <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-block">
                <?php esc_html_e( 'Scopri di più', 'caniincasa' ); ?>
            </a>
        </div>
    </div>
</div>
