<?php
/**
 * File di Configurazione Debug per Template Razze
 *
 * PROBLEMA: Local by Flywheel a volte ha problemi con le sessioni/nonce
 *
 * SOLUZIONE TEMPORANEA:
 * 1. Includi questo file nel functions.php
 * 2. Testa se le razze si caricano
 * 3. Una volta verificato che tutto funziona, rimuovi questo file
 *
 * ISTRUZIONI:
 * Aggiungi questa riga alla fine del functions.php del tema:
 * require_once CANIINCASA_THEME_DIR . '/razze-debug-config.php';
 */

// ⚠️ ATTENZIONE: Questo disabilita la verifica nonce!
// Usa SOLO in ambiente di sviluppo locale (Local by Flywheel)
// NON usare in produzione!

if (
    defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE === 'local' ||
    strpos($_SERVER['HTTP_HOST'], '.local') !== false ||
    strpos($_SERVER['HTTP_HOST'], 'localhost') !== false
) {
    // Abilita solo su localhost/local
    define('RAZZE_SKIP_NONCE_CHECK', true);

    error_log('⚠️ RAZZE DEBUG: Nonce check disabilitato per ambiente locale');
}

/**
 * DEBUG INFO
 *
 * Questo file temporaneamente bypassa la verifica nonce per permetterti
 * di testare se il resto del sistema funziona.
 *
 * Se con questo file attivo le razze si caricano, allora il problema
 * è specificamente con la generazione/verifica dei nonce in Local.
 *
 * SOLUZIONI PERMANENTI:
 * 1. Aggiungi define('COOKIE_DOMAIN', false); in wp-config.php
 * 2. Usa un plugin: https://wordpress.org/plugins/fix-my-wordpress-cookies/
 * 3. Verifica che non ci siano redirect da www a non-www o HTTP a HTTPS
 */
