<?php
/**
 * Populate Italian Provinces
 *
 * This script populates the provincia taxonomy with all Italian provinces
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Populate Italian Provinces Taxonomy
 * This function creates all Italian provinces as terms in the provincia taxonomy
 */
function caniincasa_populate_italian_provinces() {

    // Array of Italian provinces with their codes
    $italian_provinces = array(
        // Abruzzo
        'AQ' => 'L\'Aquila',
        'CH' => 'Chieti',
        'PE' => 'Pescara',
        'TE' => 'Teramo',

        // Basilicata
        'MT' => 'Matera',
        'PZ' => 'Potenza',

        // Calabria
        'CZ' => 'Catanzaro',
        'CS' => 'Cosenza',
        'KR' => 'Crotone',
        'RC' => 'Reggio Calabria',
        'VV' => 'Vibo Valentia',

        // Campania
        'AV' => 'Avellino',
        'BN' => 'Benevento',
        'CE' => 'Caserta',
        'NA' => 'Napoli',
        'SA' => 'Salerno',

        // Emilia-Romagna
        'BO' => 'Bologna',
        'FC' => 'Forlì-Cesena',
        'FE' => 'Ferrara',
        'MO' => 'Modena',
        'PR' => 'Parma',
        'PC' => 'Piacenza',
        'RA' => 'Ravenna',
        'RE' => 'Reggio Emilia',
        'RN' => 'Rimini',

        // Friuli-Venezia Giulia
        'GO' => 'Gorizia',
        'PN' => 'Pordenone',
        'TS' => 'Trieste',
        'UD' => 'Udine',

        // Lazio
        'FR' => 'Frosinone',
        'LT' => 'Latina',
        'RI' => 'Rieti',
        'RM' => 'Roma',
        'VT' => 'Viterbo',

        // Liguria
        'GE' => 'Genova',
        'IM' => 'Imperia',
        'SP' => 'La Spezia',
        'SV' => 'Savona',

        // Lombardia
        'BG' => 'Bergamo',
        'BS' => 'Brescia',
        'CO' => 'Como',
        'CR' => 'Cremona',
        'LC' => 'Lecco',
        'LO' => 'Lodi',
        'MN' => 'Mantova',
        'MI' => 'Milano',
        'MB' => 'Monza e Brianza',
        'PV' => 'Pavia',
        'SO' => 'Sondrio',
        'VA' => 'Varese',

        // Marche
        'AN' => 'Ancona',
        'AP' => 'Ascoli Piceno',
        'FM' => 'Fermo',
        'MC' => 'Macerata',
        'PU' => 'Pesaro e Urbino',

        // Molise
        'CB' => 'Campobasso',
        'IS' => 'Isernia',

        // Piemonte
        'AL' => 'Alessandria',
        'AT' => 'Asti',
        'BI' => 'Biella',
        'CN' => 'Cuneo',
        'NO' => 'Novara',
        'TO' => 'Torino',
        'VB' => 'Verbano-Cusio-Ossola',
        'VC' => 'Vercelli',

        // Puglia
        'BA' => 'Bari',
        'BT' => 'Barletta-Andria-Trani',
        'BR' => 'Brindisi',
        'FG' => 'Foggia',
        'LE' => 'Lecce',
        'TA' => 'Taranto',

        // Sardegna
        'CA' => 'Cagliari',
        'CI' => 'Carbonia-Iglesias',
        'NU' => 'Nuoro',
        'OG' => 'Ogliastra',
        'OR' => 'Oristano',
        'OT' => 'Olbia-Tempio',
        'SS' => 'Sassari',
        'VS' => 'Medio Campidano',
        'SU' => 'Sud Sardegna',

        // Sicilia
        'AG' => 'Agrigento',
        'CL' => 'Caltanissetta',
        'CT' => 'Catania',
        'EN' => 'Enna',
        'ME' => 'Messina',
        'PA' => 'Palermo',
        'RG' => 'Ragusa',
        'SR' => 'Siracusa',
        'TP' => 'Trapani',

        // Toscana
        'AR' => 'Arezzo',
        'FI' => 'Firenze',
        'GR' => 'Grosseto',
        'LI' => 'Livorno',
        'LU' => 'Lucca',
        'MS' => 'Massa-Carrara',
        'PI' => 'Pisa',
        'PT' => 'Pistoia',
        'PO' => 'Prato',
        'SI' => 'Siena',

        // Trentino-Alto Adige
        'BZ' => 'Bolzano',
        'TN' => 'Trento',

        // Umbria
        'PG' => 'Perugia',
        'TR' => 'Terni',

        // Valle d'Aosta
        'AO' => 'Aosta',

        // Veneto
        'BL' => 'Belluno',
        'PD' => 'Padova',
        'RO' => 'Rovigo',
        'TV' => 'Treviso',
        'VE' => 'Venezia',
        'VR' => 'Verona',
        'VI' => 'Vicenza',
    );

    $created = 0;
    $skipped = 0;

    foreach ( $italian_provinces as $code => $name ) {
        // Check if term already exists
        $term = term_exists( $name, 'provincia' );

        if ( ! $term ) {
            // Create the term
            $result = wp_insert_term(
                $name,
                'provincia',
                array(
                    'slug' => sanitize_title( $name ),
                    'description' => sprintf( 'Provincia di %s (%s)', $name, $code ),
                )
            );

            if ( ! is_wp_error( $result ) ) {
                $created++;

                // Store province code as term meta
                add_term_meta( $result['term_id'], 'province_code', $code, true );
            }
        } else {
            $skipped++;
        }
    }

    return array(
        'created' => $created,
        'skipped' => $skipped,
        'total' => count( $italian_provinces ),
    );
}

/**
 * Admin notice to populate provinces
 */
function caniincasa_admin_notice_populate_provinces() {

    // Only show to administrators
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Check if provinces are already populated
    $province_count = wp_count_terms( array(
        'taxonomy' => 'provincia',
        'hide_empty' => false,
    ) );

    // If less than 100 provinces, show notice
    if ( is_numeric( $province_count ) && $province_count < 100 ) {
        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong>CaninCasa:</strong> Le province italiane non sono state ancora popolate.
                <a href="<?php echo admin_url( 'admin.php?page=caniincasa-populate-provinces' ); ?>" class="button button-primary">
                    Popola Province
                </a>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'caniincasa_admin_notice_populate_provinces' );

/**
 * Add admin menu page to populate provinces
 */
function caniincasa_add_populate_provinces_page() {
    add_submenu_page(
        null, // No parent (hidden page)
        'Popola Province',
        'Popola Province',
        'manage_options',
        'caniincasa-populate-provinces',
        'caniincasa_populate_provinces_page'
    );
}
add_action( 'admin_menu', 'caniincasa_add_populate_provinces_page' );

/**
 * Populate provinces page callback
 */
function caniincasa_populate_provinces_page() {

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Non hai i permessi per accedere a questa pagina.' );
    }

    $result = caniincasa_populate_italian_provinces();

    ?>
    <div class="wrap">
        <h1>Popola Province Italiane</h1>

        <div class="notice notice-success">
            <p>
                <strong>Operazione completata!</strong><br>
                Province create: <?php echo $result['created']; ?><br>
                Province già esistenti: <?php echo $result['skipped']; ?><br>
                Totale province: <?php echo $result['total']; ?>
            </p>
        </div>

        <p>
            <a href="<?php echo admin_url( 'edit-tags.php?taxonomy=provincia' ); ?>" class="button button-primary">
                Visualizza Province
            </a>
            <a href="<?php echo admin_url(); ?>" class="button">
                Torna alla Dashboard
            </a>
        </p>
    </div>
    <?php
}
