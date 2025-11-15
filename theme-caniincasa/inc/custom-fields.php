<?php
/**
 * Custom Fields Configuration (ACF)
 *
 * This file contains ACF field group registrations
 * Requires Advanced Custom Fields PRO plugin
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if ACF is active
 */
if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

/**
 * Razze di Cani - Caratteristiche Aggiuntive (Integrazione con campi esistenti)
 * Aggiunge solo i campi mancanti, usa quelli già presenti dove possibile
 *
 * Campi esistenti riutilizzati:
 * - energia_e_livelli_di_attivita (32)
 * - vocalita_e_predisposizione_ad_abbaiare (30)
 * - cura_e_perdita_pelo_ (31)
 * - facilita_di_addestramento (29)
 * - compatibilita_con_i_bambini (33)
 * - compatibilita_con_altri_animali_domestici (34)
 * - esigenze_di_esercizio (35)
 * - tolleranza_alla_solitudine (37)
 * - adattabilita_clima_freddo (38)
 * - adattabilita_clima_caldo (39)
 * - istinti_di_caccia (40)
 */
acf_add_local_field_group( array(
    'key' => 'group_razze_caratteristiche_aggiuntive',
    'title' => 'Caratteristiche Razza - Campi Aggiuntivi',
    'fields' => array(

        // ========================================
        // TAB 1: Caratteristiche Aggiuntive
        // ========================================
        array(
            'key' => 'field_tab_aggiuntive',
            'label' => 'Caratteristiche Aggiuntive',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_affettuosita',
            'label' => 'Affettuosità',
            'name' => 'affettuosita',
            'type' => 'range',
            'instructions' => '1 = Indipendente | 5 = Molto affettuoso (es. Golden Retriever)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_socievolezza_cani',
            'label' => 'Socievolezza con Altri Cani',
            'name' => 'socievolezza_cani',
            'type' => 'range',
            'instructions' => '1 = Preferisce essere unico | 5 = Ama altri cani',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_adattabilita_appartamento',
            'label' => 'Adattabilità Appartamento',
            'name' => 'adattabilita_appartamento',
            'type' => 'range',
            'instructions' => '1 = Necessita spazio esterno | 5 = Perfetto per appartamento',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_tolleranza_estranei',
            'label' => 'Tolleranza verso Estranei',
            'name' => 'tolleranza_estranei',
            'type' => 'range',
            'instructions' => '1 = Diffidente/protettivo | 5 = Amichevole con tutti',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_intelligenza',
            'label' => 'Intelligenza / Problem Solving',
            'name' => 'intelligenza',
            'type' => 'range',
            'instructions' => '1 = Segue più l\'istinto | 5 = Molto intelligente',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_facilita_toelettatura',
            'label' => 'Facilità Toelettatura',
            'name' => 'facilita_toelettatura',
            'type' => 'range',
            'instructions' => '1 = Richiede toelettatura professionale frequente | 5 = Manutenzione minima',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_livello_esperienza_richiesto',
            'label' => 'Livello Esperienza Richiesto',
            'name' => 'livello_esperienza_richiesto',
            'type' => 'range',
            'instructions' => '1 = Perfetto per principianti | 5 = Solo padroni esperti (es. Akita)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_costo_mantenimento',
            'label' => 'Costo Mantenimento',
            'name' => 'costo_mantenimento',
            'type' => 'range',
            'instructions' => '1 = Economico | 5 = Costoso (cibo, cure, toelettatura)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'razze_di_cani',
            ),
        ),
    ),
    'menu_order' => 10,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'field',
    'active' => true,
) );

/**
 * Razze di Cani - Informazioni Sidebar
 * Campi visualizzati nel box laterale della singola razza
 */
acf_add_local_field_group( array(
    'key' => 'group_razze_info_sidebar',
    'title' => 'Informazioni Razza (Sidebar)',
    'fields' => array(

        array(
            'key' => 'field_nazione_origine',
            'label' => 'Nazione di Origine',
            'name' => 'nazione_origine',
            'type' => 'text',
            'instructions' => 'Es: Italia, Germania, Francia, Stati Uniti, ecc.',
            'required' => 0,
            'placeholder' => 'Es: Italia',
        ),

        array(
            'key' => 'field_colorazioni',
            'label' => 'Colorazioni',
            'name' => 'colorazioni',
            'type' => 'textarea',
            'instructions' => 'Elenca le colorazioni ammesse per questa razza (una per riga o separate da virgole)',
            'required' => 0,
            'rows' => 3,
            'placeholder' => 'Es: Nero, Marrone, Bianco, Fulvo',
        ),

        array(
            'key' => 'field_temperamento_breve',
            'label' => 'Temperamento (breve)',
            'name' => 'temperamento_breve',
            'type' => 'text',
            'instructions' => 'Descrizione breve del temperamento (3-5 parole)',
            'required' => 0,
            'maxlength' => 100,
            'placeholder' => 'Es: Affettuoso, Energico, Protettivo',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'razze_di_cani',
            ),
        ),
    ),
    'menu_order' => 5,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'field',
    'active' => true,
) );

/**
 * Razze di Cani - Sezioni Contenuto
 * Campi WYSIWYG per le diverse sezioni della scheda razza
 */
acf_add_local_field_group( array(
    'key' => 'group_razze_sezioni_contenuto',
    'title' => 'Contenuto Razza - Sezioni',
    'fields' => array(

        // ========================================
        // TAB: Descrizione
        // ========================================
        array(
            'key' => 'field_tab_descrizione',
            'label' => 'Descrizione',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_descrizione_generale',
            'label' => 'Descrizione Generale',
            'name' => 'descrizione_generale',
            'type' => 'wysiwyg',
            'instructions' => 'Breve introduzione alla razza (2-3 paragrafi)',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

        // ========================================
        // TAB: Storia
        // ========================================
        array(
            'key' => 'field_tab_storia',
            'label' => 'Storia',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_origini_storia',
            'label' => 'Origini e Storia',
            'name' => 'origini_storia',
            'type' => 'wysiwyg',
            'instructions' => 'Storia e origini della razza',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

        // ========================================
        // TAB: Aspetto
        // ========================================
        array(
            'key' => 'field_tab_aspetto',
            'label' => 'Aspetto',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_aspetto_fisico',
            'label' => 'Aspetto Fisico',
            'name' => 'aspetto_fisico',
            'type' => 'wysiwyg',
            'instructions' => 'Descrizione fisica della razza (taglia, peso, mantello, colori)',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

        // ========================================
        // TAB: Carattere
        // ========================================
        array(
            'key' => 'field_tab_carattere',
            'label' => 'Carattere',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_carattere_temperamento',
            'label' => 'Carattere e Temperamento',
            'name' => 'carattere_temperamento',
            'type' => 'wysiwyg',
            'instructions' => 'Descrizione del carattere e temperamento',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

        // ========================================
        // TAB: Salute
        // ========================================
        array(
            'key' => 'field_tab_salute',
            'label' => 'Salute',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_salute_cura',
            'label' => 'Salute e Cura',
            'name' => 'salute_cura',
            'type' => 'wysiwyg',
            'instructions' => 'Informazioni su salute, predisposizioni, toelettatura',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

        // ========================================
        // TAB: Addestramento
        // ========================================
        array(
            'key' => 'field_tab_addestramento',
            'label' => 'Addestramento',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_attivita_addestramento',
            'label' => 'Attività e Addestramento',
            'name' => 'attivita_addestramento',
            'type' => 'wysiwyg',
            'instructions' => 'Esigenze di attività fisica e facilità di addestramento',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

        // ========================================
        // TAB: Ideale Per
        // ========================================
        array(
            'key' => 'field_tab_ideale',
            'label' => 'Ideale Per',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_ideale_per',
            'label' => 'Ideale Per',
            'name' => 'ideale_per',
            'type' => 'wysiwyg',
            'instructions' => 'Per chi è adatta questa razza? Chi dovrebbe evitarla?',
            'required' => 0,
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'razze_di_cani',
            ),
        ),
    ),
    'menu_order' => 8,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'field',
    'active' => true,
) );

/**
 * Helper function to get rating label text
 */
function caniincasa_get_rating_label( $field_name, $value ) {
    $labels = array(
        'livello_energia' => array(
            1 => 'Molto basso',
            2 => 'Basso',
            3 => 'Medio',
            4 => 'Alto',
            5 => 'Molto alto',
        ),
        'affettuosita' => array(
            1 => 'Indipendente',
            2 => 'Poco affettuoso',
            3 => 'Moderatamente affettuoso',
            4 => 'Affettuoso',
            5 => 'Molto affettuoso',
        ),
        'adattabilita_appartamento' => array(
            1 => 'Non adatto',
            2 => 'Poco adatto',
            3 => 'Si adatta',
            4 => 'Adatto',
            5 => 'Perfetto',
        ),
        'compatibilita_bambini' => array(
            1 => 'Non adatto',
            2 => 'Con supervisione',
            3 => 'Adatto',
            4 => 'Ottimo',
            5 => 'Eccellente',
        ),
        'facilita_addestramento' => array(
            1 => 'Molto difficile',
            2 => 'Difficile',
            3 => 'Media',
            4 => 'Facile',
            5 => 'Molto facile',
        ),
        'livello_esperienza_richiesto' => array(
            1 => 'Principianti',
            2 => 'Principianti+',
            3 => 'Intermedio',
            4 => 'Avanzato',
            5 => 'Esperti',
        ),
    );

    $rounded = round( $value );

    if ( isset( $labels[ $field_name ][ $rounded ] ) ) {
        return $labels[ $field_name ][ $rounded ];
    }

    return '';
}
