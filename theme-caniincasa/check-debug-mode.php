<?php
/**
 * Verifica Rapida Debug Mode
 *
 * Visita: http://cani-in-casa.local/wp-content/themes/theme-caniincasa/check-debug-mode.php
 */

// Trova wp-load.php
$wp_load_found = false;
$paths_to_try = [
    __DIR__ . '/../../../wp-load.php',
    __DIR__ . '/../../../../wp-load.php',
];

foreach ($paths_to_try as $path) {
    if (file_exists($path)) {
        require_once $path;
        $wp_load_found = true;
        break;
    }
}

if (!$wp_load_found) {
    die('❌ Non riesco a caricare WordPress');
}

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Check Debug Mode</title>
    <style>
        body { font-family: Arial; padding: 40px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { border-left: 4px solid #46b450; }
        .error { border-left: 4px solid #dc3232; }
        .warning { border-left: 4px solid #ffb900; }
        h1 { color: #333; }
        h2 { color: #666; margin-top: 0; }
        pre { background: #f9f9f9; padding: 10px; border-radius: 4px; overflow-x: auto; }
        .label { font-weight: bold; color: #0073aa; }
    </style>
</head>
<body>
    <h1>🔍 Verifica Debug Mode - Razze Template</h1>

    <div class="box">
        <h2>📋 Informazioni Server</h2>
        <p><span class="label">Host:</span> <?php echo $_SERVER['HTTP_HOST']; ?></p>
        <p><span class="label">Path:</span> <?php echo __DIR__; ?></p>
        <p><span class="label">WordPress Version:</span> <?php echo get_bloginfo('version'); ?></p>
        <p><span class="label">Theme:</span> <?php echo wp_get_theme()->get('Name'); ?></p>
    </div>

    <div class="box <?php echo defined('RAZZE_SKIP_NONCE_CHECK') && RAZZE_SKIP_NONCE_CHECK ? 'success' : 'error'; ?>">
        <h2>⚙️ Debug Mode Status</h2>
        <?php if (defined('RAZZE_SKIP_NONCE_CHECK') && RAZZE_SKIP_NONCE_CHECK): ?>
            <p>✅ <strong>DEBUG MODE ATTIVO</strong></p>
            <p>La verifica nonce è disabilitata per questo ambiente.</p>
            <p>Le razze dovrebbero caricarsi senza errore 403.</p>
        <?php else: ?>
            <p>❌ <strong>DEBUG MODE NON ATTIVO</strong></p>
            <p>La costante RAZZE_SKIP_NONCE_CHECK non è definita.</p>
            <p><strong>Problema:</strong> Il nonce verrà verificato e potrebbe dare errore 403.</p>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>🧪 Test Hostname Detection</h2>
        <p><span class="label">HTTP_HOST:</span> <code><?php echo $_SERVER['HTTP_HOST']; ?></code></p>

        <p><span class="label">Contiene ".local"?</span>
            <?php echo (strpos($_SERVER['HTTP_HOST'], '.local') !== false) ? '✅ SI' : '❌ NO'; ?>
        </p>

        <p><span class="label">Contiene "localhost"?</span>
            <?php echo (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) ? '✅ SI' : '❌ NO'; ?>
        </p>

        <p><span class="label">WP_ENVIRONMENT_TYPE:</span>
            <?php echo defined('WP_ENVIRONMENT_TYPE') ? WP_ENVIRONMENT_TYPE : 'non definito'; ?>
        </p>
    </div>

    <div class="box">
        <h2>📦 Razze Pubblicate</h2>
        <?php
        $razze_count = wp_count_posts('razze_di_cani');
        $published = $razze_count->publish ?? 0;
        ?>
        <p><span class="label">Totale razze pubblicate:</span> <strong style="font-size: 24px; color: <?php echo $published > 0 ? '#46b450' : '#dc3232'; ?>"><?php echo $published; ?></strong></p>

        <?php if ($published == 0): ?>
            <p class="error">⚠️ Nessuna razza pubblicata! Devi importare le razze prima.</p>
            <p><strong>Soluzione:</strong> Esegui <code>php import-sample-breeds.php</code></p>
        <?php else: ?>
            <p class="success">✅ Ci sono razze da visualizzare!</p>
            <?php
            $sample = get_posts(['post_type' => 'razze_di_cani', 'posts_per_page' => 3]);
            echo '<p><strong>Esempi:</strong></p><ul>';
            foreach ($sample as $post) {
                echo '<li>' . esc_html($post->post_title) . '</li>';
            }
            echo '</ul>';
            ?>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>🔧 AJAX Handler</h2>
        <?php if (function_exists('caniincasa_filter_razze')): ?>
            <p>✅ Funzione <code>caniincasa_filter_razze()</code> trovata</p>
        <?php else: ?>
            <p>❌ Funzione <code>caniincasa_filter_razze()</code> NON trovata</p>
        <?php endif; ?>

        <?php
        global $wp_filter;
        $actions = ['wp_ajax_filter_razze', 'wp_ajax_nopriv_filter_razze'];
        foreach ($actions as $action) {
            if (isset($wp_filter[$action])) {
                echo '<p>✅ Action <code>' . $action . '</code> registrata</p>';
            } else {
                echo '<p>❌ Action <code>' . $action . '</code> NON registrata</p>';
            }
        }
        ?>
    </div>

    <div class="box warning">
        <h2>⚠️ Prossimi Passi</h2>
        <?php if (defined('RAZZE_SKIP_NONCE_CHECK') && RAZZE_SKIP_NONCE_CHECK && $published > 0): ?>
            <p><strong>Tutto sembra OK!</strong></p>
            <ol>
                <li>Vai sulla pagina delle razze</li>
                <li>Ricarica con <kbd>Ctrl+Shift+R</kbd> (Windows) o <kbd>Cmd+Shift+R</kbd> (Mac)</li>
                <li>Apri Console (F12)</li>
                <li>Dovresti vedere le razze caricarsi!</li>
            </ol>
            <p><strong>Se ancora non funziona:</strong> Inviami uno screenshot della Console</p>
        <?php elseif (!defined('RAZZE_SKIP_NONCE_CHECK') || !RAZZE_SKIP_NONCE_CHECK): ?>
            <p><strong>Il debug mode non è attivo!</strong></p>
            <p>Verifica che <code>functions.php</code> contenga il codice per definire RAZZE_SKIP_NONCE_CHECK</p>
        <?php elseif ($published == 0): ?>
            <p><strong>Nessuna razza da mostrare!</strong></p>
            <p>Prima importa le razze eseguendo: <code>php import-sample-breeds.php</code></p>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>🎯 Link Utili</h2>
        <ul>
            <li><a href="/razze/">Vai alla pagina Razze</a></li>
            <li><a href="/wp-admin/">WordPress Admin</a></li>
            <li><a href="/wp-admin/edit.php?post_type=razze_di_cani">Gestisci Razze</a></li>
        </ul>
    </div>
</body>
</html>
