<?php
/**
 * Archive Template: Razze di Cani con Filtri AJAX
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main archive-razze">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Hero Section -->
        <div class="archive-hero">
            <h1 class="archive-title">
                <span class="title-icon">🐕</span>
                Esplora tutte le Razze Canine
            </h1>
            <p class="archive-description">
                Scopri oltre 320 razze di cani con informazioni dettagliate su caratteristiche, temperamento,
                origini e consigli per la cura. Usa i filtri per trovare il tuo compagno ideale.
            </p>
        </div>

        <!-- Filters & Results Layout -->
        <div class="razze-archive-layout">

            <!-- Sidebar Filters -->
            <aside class="razze-filters" id="razze-filters">

                <div class="filters-header">
                    <h2 class="filters-title">🔍 Filtra Razze</h2>
                    <button class="btn-reset-filters" id="reset-filters" type="button">
                        <span class="icon">↺</span> Reset
                    </button>
                </div>

                <!-- Search Box -->
                <div class="filter-group">
                    <label for="search-breed" class="filter-label">
                        <span class="label-icon">🔎</span>
                        Cerca per nome
                    </label>
                    <input
                        type="text"
                        id="search-breed"
                        class="filter-search"
                        placeholder="Es: Labrador, Pastore..."
                        autocomplete="off"
                    >
                </div>

                <!-- Size Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">📏</span>
                        Dimensione
                    </label>
                    <div class="filter-options">
                        <label class="filter-checkbox">
                            <input type="checkbox" name="size" value="piccola" class="filter-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Piccola (fino 10kg)</span>
                        </label>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="size" value="media" class="filter-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Media (10-25kg)</span>
                        </label>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="size" value="grande" class="filter-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Grande (25-45kg)</span>
                        </label>
                        <label class="filter-checkbox">
                            <input type="checkbox" name="size" value="gigante" class="filter-input">
                            <span class="checkbox-custom"></span>
                            <span class="checkbox-label">Gigante (oltre 45kg)</span>
                        </label>
                    </div>
                </div>

                <!-- Energy Level Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">⚡</span>
                        Livello di Energia
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-energy"
                            name="energia"
                            min="0"
                            max="5"
                            value="0"
                            step="0.5"
                            class="filter-slider"
                        >
                        <div class="range-labels">
                            <span>Basso</span>
                            <span id="energy-value" class="range-value">Tutti</span>
                            <span>Alto</span>
                        </div>
                    </div>
                </div>

                <!-- Apartment Adaptability -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🏠</span>
                        Adatto ad Appartamento
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-apartment"
                            name="appartamento"
                            min="0"
                            max="5"
                            value="0"
                            step="0.5"
                            class="filter-slider"
                        >
                        <div class="range-labels">
                            <span>No</span>
                            <span id="apartment-value" class="range-value">Tutti</span>
                            <span>Ideale</span>
                        </div>
                    </div>
                </div>

                <!-- Kids Friendly -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">👶</span>
                        Compatibile con Bambini
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-kids"
                            name="bambini"
                            min="0"
                            max="5"
                            value="0"
                            step="0.5"
                            class="filter-slider"
                        >
                        <div class="range-labels">
                            <span>No</span>
                            <span id="kids-value" class="range-value">Tutti</span>
                            <span>Ottimo</span>
                        </div>
                    </div>
                </div>

                <!-- Experience Level -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🎓</span>
                        Esperienza Richiesta
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-experience"
                            name="esperienza"
                            min="0"
                            max="5"
                            value="0"
                            step="0.5"
                            class="filter-slider"
                        >
                        <div class="range-labels">
                            <span>Principiante</span>
                            <span id="experience-value" class="range-value">Tutti</span>
                            <span>Esperto</span>
                        </div>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="filter-group">
                    <label for="sort-by" class="filter-label">
                        <span class="label-icon">⇅</span>
                        Ordinamento
                    </label>
                    <select id="sort-by" class="filter-select">
                        <option value="name-asc">Nome A-Z</option>
                        <option value="name-desc">Nome Z-A</option>
                        <option value="popular">Più Popolari</option>
                    </select>
                </div>

            </aside>

            <!-- Results Area -->
            <div class="razze-results">

                <!-- Results Header -->
                <div class="results-header">
                    <div class="results-count">
                        Trovate <strong id="results-total">0</strong> razze
                    </div>
                    <button class="btn-toggle-filters" id="toggle-filters" type="button">
                        <span class="icon">☰</span> Filtri
                    </button>
                </div>

                <!-- Loading Indicator -->
                <div class="loading-indicator" id="loading-indicator" style="display: none;">
                    <div class="spinner"></div>
                    <p>Caricamento razze...</p>
                </div>

                <!-- No Results Message -->
                <div class="no-results" id="no-results" style="display: none;">
                    <div class="no-results-icon">😕</div>
                    <h3>Nessuna razza trovata</h3>
                    <p>Prova a modificare i filtri o resettali per vedere tutti i risultati.</p>
                    <button class="btn btn-primary" type="button" onclick="document.getElementById('reset-filters').click()">
                        Reset Filtri
                    </button>
                </div>

                <!-- Breeds Grid -->
                <div class="razze-grid" id="razze-grid">
                    <!-- Populated via AJAX -->
                </div>

                <!-- Load More Button -->
                <div class="load-more-container" id="load-more-container" style="display: none;">
                    <button class="btn btn-outline" id="load-more-btn" type="button">
                        Carica Altre Razze
                    </button>
                </div>

            </div>

        </div>

    </div>

</main>

<script>
// Passa dati WordPress a JavaScript
var razzeArchive = {
    ajaxUrl: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
    nonce: '<?php echo wp_create_nonce( 'razze_filters_nonce' ); ?>',
    postsPerPage: 24
};
</script>

<?php get_footer(); ?>
