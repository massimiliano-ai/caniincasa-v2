<?php
/**
 * Template Name: Archivio Razze con Filtri
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-razze-archive">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Hero Section -->
        <div class="razze-hero">
            <h1 class="page-title">
                <?php echo esc_html( get_the_title() ); ?>
            </h1>
            <?php if ( get_the_content() ): ?>
                <div class="page-intro">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Filters & Results Layout -->
        <div class="razze-layout">

            <!-- Sidebar Filters -->
            <aside class="razze-filters-sidebar" id="razze-filters">

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
                            step="0.5"
                            value="0"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">Basso</span>
                            <span class="range-value" id="energy-value">Tutti</span>
                            <span class="range-max">Alto</span>
                        </div>
                    </div>
                </div>

                <!-- Apartment Friendly Filter -->
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
                            step="0.5"
                            value="0"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">No</span>
                            <span class="range-value" id="apartment-value">Tutti</span>
                            <span class="range-max">Ideale</span>
                        </div>
                    </div>
                </div>

                <!-- Affettuosità Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">❤️</span>
                        Affettuosità
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-affection"
                            name="affettuosita"
                            min="0"
                            max="5"
                            step="0.5"
                            value="0"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">Basso</span>
                            <span class="range-value" id="affection-value">Tutti</span>
                            <span class="range-max">Alto</span>
                        </div>
                    </div>
                </div>

                <!-- Tolleranza verso Estranei Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">👥</span>
                        Tolleranza verso Estranei
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-strangers"
                            name="tolleranza_estranei"
                            min="0"
                            max="5"
                            step="0.5"
                            value="0"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">Basso</span>
                            <span class="range-value" id="strangers-value">Tutti</span>
                            <span class="range-max">Alto</span>
                        </div>
                    </div>
                </div>

                <!-- Vocalità Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🔊</span>
                        Vocalità
                    </label>
                    <div class="filter-range">
                        <input
                            type="range"
                            id="filter-vocality"
                            name="vocalita"
                            min="0"
                            max="5"
                            step="0.5"
                            value="0"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">Silenzioso</span>
                            <span class="range-value" id="vocality-value">Tutti</span>
                            <span class="range-max">Molto vocale</span>
                        </div>
                    </div>
                </div>

                <!-- Kids Friendly Filter -->
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
                            step="0.5"
                            value="0"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">No</span>
                            <span class="range-value" id="kids-value">Tutti</span>
                            <span class="range-max">Ottimo</span>
                        </div>
                    </div>
                </div>

                <!-- Experience Level Filter -->
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
                            step="0.5"
                            value="5"
                            class="range-slider"
                        >
                        <div class="range-labels">
                            <span class="range-min">Principiante</span>
                            <span class="range-value" id="experience-value">Tutti</span>
                            <span class="range-max">Esperto</span>
                        </div>
                    </div>
                </div>

                <!-- Sort Order -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🔀</span>
                        Ordina per
                    </label>
                    <select id="filter-sort" class="filter-select">
                        <option value="name-asc">Nome A-Z</option>
                        <option value="name-desc">Nome Z-A</option>
                        <option value="popular">Più Popolari</option>
                    </select>
                </div>

            </aside>

            <!-- Main Content Area -->
            <div class="razze-main-content">

                <!-- Results Header -->
                <div class="results-header">
                    <p class="results-count">
                        <span id="razze-count">Caricamento...</span>
                    </p>
                    <div class="view-toggle">
                        <button class="view-btn active" data-view="grid" title="Vista griglia">
                            <span class="icon">▦</span>
                        </button>
                        <button class="view-btn" data-view="list" title="Vista lista">
                            <span class="icon">☰</span>
                        </button>
                    </div>
                </div>

                <!-- Loading State -->
                <div class="razze-loading" id="razze-loading" style="display: none;">
                    <div class="spinner"></div>
                    <p>Caricamento razze...</p>
                </div>

                <!-- Results Grid -->
                <div class="razze-grid" id="razze-results">
                    <!-- Le card razze verranno inserite qui via AJAX -->
                </div>

                <!-- No Results -->
                <div class="no-results" id="no-results" style="display: none;">
                    <div class="no-results-icon">🐕</div>
                    <h3>Nessuna razza trovata</h3>
                    <p>Prova a modificare i filtri o resettali per vedere tutte le razze.</p>
                    <button class="btn btn-primary" onclick="document.getElementById('reset-filters').click()">
                        Mostra tutte le razze
                    </button>
                </div>

                <!-- Load More Button -->
                <div class="load-more-wrapper" id="load-more-wrapper" style="display: none;">
                    <button class="btn-load-more" id="load-more">
                        Carica altre razze
                    </button>
                </div>

            </div>

        </div>

    </div>

</main>

<?php get_footer();
