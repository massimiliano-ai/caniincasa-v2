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
 * Annunci Cucciolate - Campi Custom
 */
acf_add_local_field_group( array(
    'key' => 'group_annunci_cucciolate',
    'title' => 'Dettagli Annuncio Cucciolata',
    'fields' => array(

        array(
            'key' => 'field_ricerca_offerta',
            'label' => 'Tipo Annuncio',
            'name' => 'ricerca_offerta',
            'type' => 'select',
            'required' => 1,
            'choices' => array(
                'offerta' => 'Offro Cuccioli',
                'ricerca' => 'Cerco Cucciolo',
            ),
            'default_value' => 'offerta',
        ),

        array(
            'key' => 'field_eta_cane',
            'label' => 'Età Cane',
            'name' => 'eta_cane',
            'type' => 'select',
            'required' => 0,
            'choices' => array(
                'cucciolo' => 'Cucciolo',
                'adulto' => 'Adulto',
            ),
            'default_value' => 'cucciolo',
            'allow_null' => 1,
        ),

        array(
            'key' => 'field_razza',
            'label' => 'Razza',
            'name' => 'razza',
            'type' => 'relationship',
            'required' => 1,
            'post_type' => array( 'razze_di_cani' ),
            'max' => 1,
            'return_format' => 'object',
        ),

        array(
            'key' => 'field_data_nascita',
            'label' => 'Data di Nascita Cuccioli',
            'name' => 'data_nascita',
            'type' => 'date_picker',
            'display_format' => 'd/m/Y',
            'return_format' => 'Y-m-d',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_ricerca_offerta',
                        'operator' => '==',
                        'value' => 'offerta',
                    ),
                ),
            ),
        ),

        array(
            'key' => 'field_numero_maschi',
            'label' => 'Numero Maschi',
            'name' => 'numero_maschi',
            'type' => 'number',
            'min' => 0,
            'default_value' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_ricerca_offerta',
                        'operator' => '==',
                        'value' => 'offerta',
                    ),
                ),
            ),
        ),

        array(
            'key' => 'field_numero_femmine',
            'label' => 'Numero Femmine',
            'name' => 'numero_femmine',
            'type' => 'number',
            'min' => 0,
            'default_value' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_ricerca_offerta',
                        'operator' => '==',
                        'value' => 'offerta',
                    ),
                ),
            ),
        ),

        array(
            'key' => 'field_prezzo',
            'label' => 'Prezzo (€)',
            'name' => 'prezzo',
            'type' => 'number',
            'min' => 0,
            'instructions' => 'Prezzo per cucciolo (opzionale)',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_ricerca_offerta',
                        'operator' => '==',
                        'value' => 'offerta',
                    ),
                ),
            ),
        ),

        array(
            'key' => 'field_pedigree',
            'label' => 'Pedigree',
            'name' => 'pedigree',
            'type' => 'select',
            'choices' => array(
                'si' => 'Sì',
                'no' => 'No',
            ),
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_ricerca_offerta',
                        'operator' => '==',
                        'value' => 'offerta',
                    ),
                ),
            ),
        ),

        array(
            'key' => 'field_foto_genitori',
            'label' => 'Foto dei Genitori',
            'name' => 'foto_genitori',
            'type' => 'gallery',
            'return_format' => 'array',
            'library' => 'all',
            'min' => 0,
            'max' => 5,
        ),

        array(
            'key' => 'field_documenti_disponibili',
            'label' => 'Documenti Disponibili',
            'name' => 'documenti_disponibili',
            'type' => 'checkbox',
            'choices' => array(
                'pedigree' => 'Pedigree',
                'vaccinazioni' => 'Libretto Vaccinazioni',
                'microchip' => 'Microchip',
                'certificato_salute' => 'Certificato di Salute',
                'esami_genitori' => 'Esami Genitori',
            ),
        ),

        array(
            'key' => 'field_allevamento_riferimento',
            'label' => 'Allevamento di Riferimento',
            'name' => 'allevamento_riferimento',
            'type' => 'relationship',
            'post_type' => array( 'allevamenti' ),
            'max' => 1,
            'return_format' => 'object',
        ),

        array(
            'key' => 'field_contatto',
            'label' => 'Informazioni di Contatto',
            'name' => 'contatto',
            'type' => 'textarea',
            'rows' => 3,
        ),

        array(
            'key' => 'field_data_scadenza',
            'label' => 'Data Scadenza Annuncio',
            'name' => 'data_scadenza',
            'type' => 'date_picker',
            'display_format' => 'd/m/Y',
            'return_format' => 'Y-m-d',
            'instructions' => 'Data dopo la quale l\'annuncio non sarà più visibile',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'annunci_cucciolate',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
) );

/**
 * Annunci Dogsitter - Campi Custom
 */
acf_add_local_field_group( array(
    'key' => 'group_annunci_dogsitter',
    'title' => 'Dettagli Annuncio Dogsitter',
    'fields' => array(

        array(
            'key' => 'field_comune',
            'label' => 'Comune',
            'name' => 'comune',
            'type' => 'text',
            'required' => 1,
        ),

        array(
            'key' => 'field_zona_disponibilita',
            'label' => 'Zona Disponibilità',
            'name' => 'zona_disponibilita',
            'type' => 'text',
            'instructions' => 'Es: Milano centro, Provincia di Roma, ecc.',
        ),

        array(
            'key' => 'field_esperienza_anni',
            'label' => 'Anni di Esperienza',
            'name' => 'esperienza',
            'type' => 'select',
            'required' => 1,
            'choices' => array(
                'meno-1' => 'Meno di 1 anno',
                '1-3' => '1-3 anni',
                '3-5' => '3-5 anni',
                '5-10' => '5-10 anni',
                'oltre-10' => 'Oltre 10 anni',
            ),
        ),

        array(
            'key' => 'field_tariffa_oraria',
            'label' => 'Tariffa Oraria (€)',
            'name' => 'tariffe',
            'type' => 'number',
            'required' => 1,
            'min' => 5,
            'max' => 100,
            'step' => 1,
        ),

        array(
            'key' => 'field_disponibilita_oraria',
            'label' => 'Disponibilità Oraria',
            'name' => 'disponibilita',
            'type' => 'checkbox',
            'required' => 1,
            'choices' => array(
                'mattina' => 'Mattina (08:00-13:00)',
                'pomeriggio' => 'Pomeriggio (13:00-19:00)',
                'sera' => 'Sera (19:00-23:00)',
                'weekend' => 'Weekend',
                'notturno' => 'Notturno',
            ),
        ),

        array(
            'key' => 'field_servizi_offerti',
            'label' => 'Servizi Offerti',
            'name' => 'servizi',
            'type' => 'checkbox',
            'required' => 1,
            'choices' => array(
                'passeggiate' => 'Passeggiate',
                'pensione' => 'Pensione a casa mia',
                'domicilio' => 'Assistenza a domicilio',
                'toelettatura' => 'Toelettatura base',
                'trasporto' => 'Trasporto',
                'addestramento' => 'Addestramento base',
            ),
        ),

        array(
            'key' => 'field_taglie_accettate',
            'label' => 'Taglie Accettate',
            'name' => 'taglie',
            'type' => 'checkbox',
            'required' => 1,
            'choices' => array(
                'piccola' => 'Piccola (fino a 10kg)',
                'media' => 'Media (10-25kg)',
                'grande' => 'Grande (25-45kg)',
                'gigante' => 'Gigante (oltre 45kg)',
            ),
        ),

        array(
            'key' => 'field_contatto_telefono',
            'label' => 'Telefono',
            'name' => 'contatto_telefono',
            'type' => 'text',
        ),

        array(
            'key' => 'field_contatto_email',
            'label' => 'Email',
            'name' => 'contatto_email',
            'type' => 'email',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'annunci_dogsitter',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
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

/**
 * Page Hero Settings
 * Campi per configurare la barra del titolo delle pagine
 */
acf_add_local_field_group( array(
    'key' => 'group_page_hero_settings',
    'title' => 'Impostazioni Barra Titolo',
    'fields' => array(
        array(
            'key' => 'field_hero_disable',
            'label' => 'Disabilita Barra Titolo',
            'name' => 'hero_disable',
            'type' => 'true_false',
            'instructions' => 'Attiva per nascondere completamente la barra del titolo in questa pagina.',
            'default_value' => 0,
            'ui' => 1,
        ),
        array(
            'key' => 'field_page_subtitle',
            'label' => 'Sottotitolo (H2)',
            'name' => 'page_subtitle',
            'type' => 'text',
            'instructions' => 'Sottotitolo da visualizzare sotto il titolo principale nella barra hero. Lascia vuoto per usare il valore predefinito.',
            'placeholder' => 'Es: Veterinari - Cliniche e Ambulatori',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_hero_disable',
                        'operator' => '!=',
                        'value' => '1',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_hero_background_image',
            'label' => 'Immagine di Sfondo Barra Titolo',
            'name' => 'hero_background_image',
            'type' => 'image',
            'instructions' => 'Immagine di sfondo per la barra del titolo. Lascia vuoto per usare il gradiente predefinito o l\'immagine configurata nelle impostazioni tema.',
            'return_format' => 'id',
            'preview_size' => 'medium',
            'library' => 'all',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_hero_disable',
                        'operator' => '!=',
                        'value' => '1',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_hero_overlay_color',
            'label' => 'Colore Overlay',
            'name' => 'hero_overlay_color',
            'type' => 'color_picker',
            'instructions' => 'Colore dell\'overlay scuro sopra l\'immagine di sfondo. Lascia vuoto per usare il nero predefinito (rgba(0,0,0,0.5)).',
            'default_value' => '',
            'enable_opacity' => 1,
            'return_format' => 'string',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_hero_disable',
                        'operator' => '!=',
                        'value' => '1',
                    ),
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'razze_di_cani',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'allevamenti',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'struttureveterinarie',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'canili',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'centri_cinofili',
            ),
        ),
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'pensioni_per_cani',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
) );

/**
 * Messaggi Annunci - Campi Custom
 */
acf_add_local_field_group( array(
    'key' => 'group_messaggi_annunci',
    'title' => 'Dettagli Messaggio',
    'fields' => array(

        array(
            'key' => 'field_messaggio_mittente',
            'label' => 'ID Mittente',
            'name' => 'mittente_id',
            'type' => 'number',
            'required' => 1,
            'readonly' => 1,
        ),

        array(
            'key' => 'field_messaggio_destinatario',
            'label' => 'ID Destinatario',
            'name' => 'destinatario_id',
            'type' => 'number',
            'required' => 1,
            'readonly' => 1,
        ),

        array(
            'key' => 'field_messaggio_annuncio',
            'label' => 'ID Annuncio',
            'name' => 'annuncio_id',
            'type' => 'number',
            'required' => 1,
            'readonly' => 1,
        ),

        array(
            'key' => 'field_messaggio_tipo_annuncio',
            'label' => 'Tipo Annuncio',
            'name' => 'tipo_annuncio',
            'type' => 'text',
            'required' => 1,
            'readonly' => 1,
            'instructions' => 'annunci_cucciolate o annunci_dogsitter',
        ),

        array(
            'key' => 'field_messaggio_email_mittente',
            'label' => 'Email Mittente',
            'name' => 'email_mittente',
            'type' => 'email',
            'required' => 1,
            'readonly' => 1,
        ),

        array(
            'key' => 'field_messaggio_telefono_mittente',
            'label' => 'Telefono Mittente',
            'name' => 'telefono_mittente',
            'type' => 'text',
            'required' => 0,
            'readonly' => 1,
        ),

        array(
            'key' => 'field_messaggio_stato',
            'label' => 'Stato Messaggio',
            'name' => 'stato_messaggio',
            'type' => 'select',
            'choices' => array(
                'non_letto' => 'Non letto',
                'letto' => 'Letto',
                'archiviato' => 'Archiviato',
            ),
            'default_value' => 'non_letto',
        ),

        array(
            'key' => 'field_messaggio_data_invio',
            'label' => 'Data Invio',
            'name' => 'data_invio',
            'type' => 'date_time_picker',
            'display_format' => 'd/m/Y H:i',
            'return_format' => 'Y-m-d H:i:s',
            'readonly' => 1,
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'messaggi_annunci',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
) );
