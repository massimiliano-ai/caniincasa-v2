<?php
/**
 * Search Form Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="search-input" class="sr-only">
        <?php esc_html_e( 'Cerca:', 'caniincasa' ); ?>
    </label>
    <div class="search-form__wrapper">
        <input
            type="search"
            id="search-input"
            class="search-form__input"
            placeholder="<?php esc_attr_e( 'Cerca razze, allevamenti, articoli...', 'caniincasa' ); ?>"
            value="<?php echo get_search_query(); ?>"
            name="s"
            required
        />
        <button type="submit" class="search-form__submit">
            <span class="sr-only"><?php esc_html_e( 'Cerca', 'caniincasa' ); ?></span>
            <span class="search-icon">🔍</span>
        </button>
    </div>
</form>
