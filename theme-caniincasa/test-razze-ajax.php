<?php
/**
 * Test AJAX Handler per Razze - File di diagnostica
 *
 * Come usare:
 * 1. Carica questo file nella root del tema
 * 2. Visita: http://tuosito.it/wp-content/themes/theme-caniincasa/test-razze-ajax.php
 * 3. Vedrai diagnostica completa
 */

// Carica WordPress (path corretto per Local by Flywheel)
$wp_load_paths = array(
    __DIR__ . '/../../../wp-load.php',  // Standard WordPress in root
    __DIR__ . '/../../../../wp-load.php',  // Bedrock structure
    __DIR__ . '/../../../../../wp-load.php',  // Altri setup
);

$wp_loaded = false;
foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once($path);
        $wp_loaded = true;
        break;
    }
}

if (!$wp_loaded) {
    die('ERRORE: Non riesco a trovare wp-load.php. Path corrente: ' . __DIR__);
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Razze AJAX - Diagnostica</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #f5f5f5; }
        .section { background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #0073aa; }
        .success { border-left-color: #46b450; }
        .error { border-left-color: #dc3232; }
        .warning { border-left-color: #ffb900; }
        h2 { margin-top: 0; }
        pre { background: #f9f9f9; padding: 10px; overflow-x: auto; }
        .count { font-size: 24px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🐕 Diagnostica Template Razze</h1>

    <?php
    // 1. Verifica Custom Post Type
    echo '<div class="section">';
    echo '<h2>1️⃣ Custom Post Type "razze_di_cani"</h2>';

    $cpt_exists = post_type_exists('razze_di_cani');

    if ($cpt_exists) {
        echo '<p class="success">✅ Custom Post Type registrato correttamente</p>';

        $cpt_object = get_post_type_object('razze_di_cani');
        echo '<pre>';
        echo 'Label: ' . $cpt_object->label . "\n";
        echo 'Slug: ' . $cpt_object->name . "\n";
        echo 'Public: ' . ($cpt_object->public ? 'Si' : 'No') . "\n";
        echo 'Has Archive: ' . ($cpt_object->has_archive ? 'Si' : 'No') . "\n";
        echo '</pre>';
    } else {
        echo '<p class="error">❌ Custom Post Type NON trovato!</p>';
        echo '<p>Il tema potrebbe non essere attivo o il file custom-post-types.php non è caricato.</p>';
    }
    echo '</div>';

    // 2. Conta razze pubblicate
    echo '<div class="section">';
    echo '<h2>2️⃣ Razze Pubblicate</h2>';

    $razze_count = wp_count_posts('razze_di_cani');
    $published = $razze_count->publish ?? 0;

    echo '<p class="count">' . $published . ' razze pubblicate</p>';

    if ($published > 0) {
        echo '<p class="success">✅ Ci sono razze da visualizzare</p>';

        // Mostra le prime 5 razze
        $sample_razze = get_posts(array(
            'post_type' => 'razze_di_cani',
            'posts_per_page' => 5,
            'post_status' => 'publish'
        ));

        echo '<h3>Prime 5 razze:</h3>';
        echo '<ul>';
        foreach ($sample_razze as $razza) {
            echo '<li>' . esc_html($razza->post_title) . ' (ID: ' . $razza->ID . ')</li>';
        }
        echo '</ul>';
    } else {
        echo '<p class="error">❌ NESSUNA razza pubblicata!</p>';
        echo '<p><strong>Questo è il problema!</strong> Devi importare le razze prima.</p>';
        echo '<p>Usa uno di questi metodi:</p>';
        echo '<ul>';
        echo '<li>Importa razze di esempio: <code>import-sample-breeds.php</code></li>';
        echo '<li>Importa tutte le razze: vedi <code>WORKFLOW_IMPORTAZIONE_COMPLETA.md</code></li>';
        echo '<li>Crea razze manualmente da WordPress Admin</li>';
        echo '</ul>';
    }

    echo '<pre>';
    echo 'Pubblicato: ' . ($razze_count->publish ?? 0) . "\n";
    echo 'Bozze: ' . ($razze_count->draft ?? 0) . "\n";
    echo 'Privato: ' . ($razze_count->private ?? 0) . "\n";
    echo 'Cestino: ' . ($razze_count->trash ?? 0) . "\n";
    echo '</pre>';
    echo '</div>';

    // 3. Test Query
    echo '<div class="section">';
    echo '<h2>3️⃣ Test WP_Query</h2>';

    $test_query = new WP_Query(array(
        'post_type' => 'razze_di_cani',
        'post_status' => 'publish',
        'posts_per_page' => 3
    ));

    echo '<p>Query trovate: <strong>' . $test_query->found_posts . '</strong></p>';
    echo '<p>Max pages: ' . $test_query->max_num_pages . '</p>';

    if ($test_query->have_posts()) {
        echo '<p class="success">✅ Query funziona correttamente</p>';
        echo '<h3>Risultati:</h3>';
        echo '<ul>';
        while ($test_query->have_posts()) {
            $test_query->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p class="error">❌ Query non restituisce risultati</p>';
    }
    echo '</div>';

    // 4. Test AJAX Handler
    echo '<div class="section">';
    echo '<h2>4️⃣ Test AJAX Handler</h2>';

    // Verifica che la funzione esista
    if (function_exists('caniincasa_filter_razze')) {
        echo '<p class="success">✅ Funzione AJAX handler trovata</p>';
    } else {
        echo '<p class="error">❌ Funzione AJAX handler NON trovata!</p>';
        echo '<p>Verifica che razze-ajax-filters.php sia caricato nel functions.php</p>';
    }

    // Verifica che le action siano registrate
    $ajax_actions = array(
        'wp_ajax_filter_razze',
        'wp_ajax_nopriv_filter_razze'
    );

    global $wp_filter;
    foreach ($ajax_actions as $action) {
        if (isset($wp_filter[$action])) {
            echo '<p class="success">✅ Action "' . $action . '" registrata</p>';
        } else {
            echo '<p class="error">❌ Action "' . $action . '" NON registrata</p>';
        }
    }
    echo '</div>';

    // 5. Verifica ACF
    echo '<div class="section">';
    echo '<h2>5️⃣ Advanced Custom Fields</h2>';

    if (function_exists('get_field')) {
        echo '<p class="success">✅ ACF attivo</p>';

        if ($published > 0) {
            $first_razza = get_posts(array(
                'post_type' => 'razze_di_cani',
                'posts_per_page' => 1,
                'post_status' => 'publish'
            ));

            if (!empty($first_razza)) {
                $razza_id = $first_razza[0]->ID;
                echo '<h3>Campi ACF nella prima razza (ID: ' . $razza_id . '):</h3>';

                $test_fields = array(
                    'energia_e_livelli_di_attivita',
                    'adattabilita_appartamento',
                    'compatibilita_con_i_bambini',
                    'livello_esperienza_richiesto'
                );

                echo '<ul>';
                foreach ($test_fields as $field) {
                    $value = get_field($field, $razza_id);
                    $status = !empty($value) ? '✅' : '⚠️';
                    echo '<li>' . $status . ' ' . $field . ': ' . ($value ?: 'vuoto') . '</li>';
                }
                echo '</ul>';
            }
        }
    } else {
        echo '<p class="warning">⚠️ ACF non attivo</p>';
        echo '<p>I filtri potrebbero non funzionare correttamente senza ACF.</p>';
    }
    echo '</div>';

    // 6. Verifica JavaScript e CSS
    echo '<div class="section">';
    echo '<h2>6️⃣ File JavaScript e CSS</h2>';

    $theme_dir = get_template_directory();

    $files_to_check = array(
        'js/page-razze-filters.js',
        'js/razze-filters.js',
        'css/page-razze-archive.css',
        'css/archive-razze.css',
        'css/page-razze-semplice.css'
    );

    echo '<ul>';
    foreach ($files_to_check as $file) {
        $full_path = $theme_dir . '/' . $file;
        if (file_exists($full_path)) {
            $size = filesize($full_path);
            echo '<li>✅ ' . $file . ' (' . round($size/1024, 2) . ' KB)</li>';
        } else {
            echo '<li>❌ ' . $file . ' - NON TROVATO</li>';
        }
    }
    echo '</ul>';
    echo '</div>';

    // 7. Test Simulato AJAX
    echo '<div class="section">';
    echo '<h2>7️⃣ Simulazione Risposta AJAX</h2>';

    if ($published > 0 && function_exists('caniincasa_get_breed_card_data')) {
        echo '<p>Simulazione di cosa restituirebbe l\'AJAX handler:</p>';

        $sample_razze = get_posts(array(
            'post_type' => 'razze_di_cani',
            'posts_per_page' => 3,
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC'
        ));

        $results = array();
        foreach ($sample_razze as $post) {
            setup_postdata($post);
            $results[] = caniincasa_get_breed_card_data($post->ID);
        }
        wp_reset_postdata();

        echo '<pre>';
        echo json_encode(array(
            'success' => true,
            'data' => array(
                'breeds' => $results,
                'total' => $published,
                'found_posts' => $published,
                'max_pages' => ceil($published / 24),
                'current_page' => 1,
                'has_more' => $published > 24
            )
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        echo '</pre>';
    } else {
        echo '<p class="warning">⚠️ Nessuna razza da mostrare o funzione helper non trovata</p>';
    }
    echo '</div>';

    // 8. Raccomandazioni
    echo '<div class="section">';
    echo '<h2>8️⃣ Raccomandazioni</h2>';

    if ($published == 0) {
        echo '<div class="error">';
        echo '<h3>❌ Problema Principale: Nessuna razza pubblicata</h3>';
        echo '<p><strong>SOLUZIONE:</strong> Importa le razze usando uno di questi metodi:</p>';
        echo '<ol>';
        echo '<li><strong>Razze di esempio</strong>: Carica il file <code>import-sample-breeds.php</code> nella root e visitalo nel browser</li>';
        echo '<li><strong>Tutte le razze</strong>: Segui la guida in <code>WORKFLOW_IMPORTAZIONE_COMPLETA.md</code></li>';
        echo '<li><strong>Manualmente</strong>: Vai in WordPress Admin > Razze di Cani > Aggiungi nuova</li>';
        echo '</ol>';
        echo '</div>';
    } else {
        echo '<div class="success">';
        echo '<h3>✅ Setup sembra corretto!</h3>';
        echo '<p>Se il template ancora non mostra le razze, verifica:</p>';
        echo '<ol>';
        echo '<li>Apri la Console JavaScript del browser (F12) e cerca errori</li>';
        echo '<li>Verifica che stai usando il template corretto ("Archivio Razze con Filtri")</li>';
        echo '<li>Prova a svuotare la cache del browser (Ctrl+Shift+R)</li>';
        echo '<li>Verifica che jQuery sia caricato</li>';
        echo '</ol>';
        echo '</div>';
    }
    echo '</div>';
    ?>

    <div class="section">
        <h2>🔧 Debug Console JavaScript</h2>
        <p>Copia questo codice nella Console del browser (F12) mentre sei sulla pagina delle razze:</p>
        <pre>
// Verifica che le variabili siano definite
console.log('razzeFilters:', typeof razzeFilters !== 'undefined' ? razzeFilters : 'NON DEFINITO');

// Test manuale AJAX
if (typeof razzeFilters !== 'undefined') {
    jQuery.ajax({
        url: razzeFilters.ajaxurl,
        type: 'POST',
        data: {
            action: 'filter_razze',
            nonce: razzeFilters.nonce,
            search: '',
            sizes: [],
            energy: 0,
            apartment: 0,
            kids: 0,
            experience: 5,
            sort_by: 'name-asc',
            paged: 1
        },
        success: function(response) {
            console.log('✅ AJAX Success:', response);
        },
        error: function(xhr, status, error) {
            console.error('❌ AJAX Error:', error);
            console.log('Response:', xhr.responseText);
        }
    });
}
        </pre>
    </div>

</body>
</html>
