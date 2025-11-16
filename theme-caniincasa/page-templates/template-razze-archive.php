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
                    <select id="filter-energy" name="energia" class="filter-select">
                        <option value="0">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="5">Ottimo</option>
                    </select>
                </div>

                <!-- Apartment Friendly Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🏠</span>
                        Adatto ad Appartamento
                    </label>
                    <select id="filter-apartment" name="appartamento" class="filter-select">
                        <option value="0">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="5">Ottimo</option>
                    </select>
                </div>

                <!-- Affettuosità Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">❤️</span>
                        Affettuosità
                    </label>
                    <select id="filter-affection" name="affettuosita" class="filter-select">
                        <option value="0">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="5">Ottimo</option>
                    </select>
                </div>

                <!-- Tolleranza verso Estranei Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">👥</span>
                        Tolleranza verso Estranei
                    </label>
                    <select id="filter-strangers" name="tolleranza_estranei" class="filter-select">
                        <option value="0">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="5">Ottimo</option>
                    </select>
                </div>

                <!-- Vocalità Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🔊</span>
                        Vocalità
                    </label>
                    <select id="filter-vocality" name="vocalita" class="filter-select">
                        <option value="0">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="5">Ottimo</option>
                    </select>
                </div>

                <!-- Kids Friendly Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">👶</span>
                        Compatibile con Bambini
                    </label>
                    <select id="filter-kids" name="bambini" class="filter-select">
                        <option value="0">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="5">Ottimo</option>
                    </select>
                </div>

                <!-- Experience Level Filter -->
                <div class="filter-group">
                    <label class="filter-label">
                        <span class="label-icon">🎓</span>
                        Esperienza Richiesta
                    </label>
                    <select id="filter-experience" name="esperienza" class="filter-select">
                        <option value="5">Tutti</option>
                        <option value="1">Basso</option>
                        <option value="2">Scarso</option>
                        <option value="3">Medio</option>
                        <option value="4">Buono</option>
                        <option value="0">Ottimo</option>
                    </select>
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
