# Documentazione Progetto CaninCasa

**Versione**: 2.0
**Data**: 17 Novembre 2025
**Tema WordPress**: CaninCasa Theme
**Autore**: Massimiliano

---

## Indice

1. [Panoramica Progetto](#panoramica-progetto)
2. [Custom Post Types](#custom-post-types)
3. [Tassonomie Custom](#tassonomie-custom)
4. [Template di Pagina](#template-di-pagina)
5. [Sistema Annunci](#sistema-annunci)
6. [Sistema Utenti](#sistema-utenti)
7. [Funzionalità Quiz](#funzionalità-quiz)
8. [Archivi e Filtri AJAX](#archivi-e-filtri-ajax)
9. [Campi ACF](#campi-acf)
10. [File JavaScript](#file-javascript)
11. [File CSS](#file-css)
12. [Sicurezza](#sicurezza)
13. [Come Usare](#come-usare)

---

## Panoramica Progetto

CaninCasa è un portale completo dedicato al mondo canino italiano. Il sito offre:

- **Database razze canine** con schede dettagliate
- **Directory strutture** (allevamenti, veterinari, canili, pensioni, centri cinofili)
- **Sistema annunci** per cucciolate e dogsitter
- **Quiz interattivo** per aiutare a scegliere la razza giusta
- **Sistema utenti** con dashboard personale e gestione annunci
- **Filtri avanzati** con AJAX per tutti gli archivi

---

## Custom Post Types

Il tema registra **11 Custom Post Types** (`theme-caniincasa/inc/custom-post-types.php`):

### 1. Razze di Cani (`razze_di_cani`)
- **URL**: `/razze_di_cani/{slug}/`
- **Icona**: dashicons-pets
- **Features**: title, editor, thumbnail, page-attributes, excerpt, revisions
- **Has Archive**: Sì
- **Hierarchical**: Sì
- **Uso**: Database completo delle razze canine con caratteristiche dettagliate

### 2. Allevamenti (`allevamenti`)
- **URL**: `/allevamenti/{slug}/`
- **Icona**: dashicons-building
- **Features**: title, editor, thumbnail, page-attributes, excerpt
- **Has Archive**: Sì
- **Uso**: Directory allevamenti certificati

### 3. Strutture Veterinarie (`struttureveterinarie`)
- **URL**: `/struttureveterinarie/{slug}/`
- **Icona**: dashicons-welcome-learn-more
- **Features**: title, editor, thumbnail, excerpt, revisions, page-attributes
- **Has Archive**: Sì
- **Uso**: Directory cliniche e ambulatori veterinari

### 4. Patologie Canine (`patologie_canine`)
- **URL**: `/patologie_canine/{slug}/`
- **Icona**: dashicons-heart
- **Features**: title, editor, thumbnail, excerpt
- **Has Archive**: Sì
- **Uso**: Enciclopedia malattie e patologie dei cani

### 5. FAQ (`faq`)
- **URL**: `/faq/{slug}/`
- **Icona**: dashicons-editor-help
- **Features**: title, editor, thumbnail, revisions, page-attributes
- **Has Archive**: Sì
- **Hierarchical**: Sì
- **Uso**: Domande frequenti organizzate per categorie

### 6. Annunci Dogsitter (`annunci_dogsitter`)
- **URL**: `/annunci_dogsitter/{slug}/`
- **Icona**: dashicons-groups
- **Features**: title, editor, thumbnail, page-attributes
- **Has Archive**: Sì
- **Uso**: Annunci di persone che offrono servizi di dogsitting

### 7. Annunci Cucciolate (`annunci_cucciolate`)
- **URL**: `/annunci_cucciolate/{slug}/`
- **Icona**: dashicons-admin-post
- **Features**: title, editor, thumbnail, page-attributes
- **Has Archive**: Sì
- **Uso**: Annunci "Amici a 4 Zampe" - Offerte e ricerche di cuccioli

### 8. Canili (`canili`)
- **URL**: `/canili/{slug}/`
- **Icona**: dashicons-admin-home
- **Features**: title, editor, thumbnail, page-attributes
- **Has Archive**: Sì
- **Uso**: Directory rifugi e canili

### 9. Centri Cinofili (`centri_cinofili`)
- **URL**: `/centri_cinofili/{slug}/`
- **Icona**: dashicons-awards
- **Features**: title, editor, thumbnail, page-attributes
- **Has Archive**: Sì
- **Uso**: Directory centri di addestramento ed educazione cinofila

### 10. Pensioni per Cani (`pensioni_per_cani`)
- **URL**: `/pensioni_per_cani/{slug}/`
- **Icona**: dashicons-admin-multisite
- **Features**: title, editor, thumbnail, page-attributes
- **Has Archive**: Sì
- **Uso**: Directory strutture di pensionamento per cani

### 11. Colori Mantello (`colore`)
- **URL**: `/colore/{slug}/`
- **Icona**: dashicons-art
- **Features**: title, editor, thumbnail, page-attributes
- **Has Archive**: Sì
- **Uso**: Database colori del mantello canino

---

## Tassonomie Custom

Il tema registra **5 tassonomie custom** (`theme-caniincasa/inc/taxonomies.php`):

### 1. Provincia (`provincia`)
- **Tipo**: Non gerarchica (tag-like)
- **Applicata a**: allevamenti, struttureveterinarie, canili, centri_cinofili, pensioni_per_cani, annunci_cucciolate, annunci_dogsitter
- **Uso**: Filtro geografico per province italiane
- **Popolamento**: Automatico tramite `inc/populate-provinces.php` (107 province)

### 2. Razze Allevamenti (`razze_allevamenti`)
- **Tipo**: Gerarchica
- **Applicata a**: allevamenti, razze_di_cani
- **Uso**: Collegamento tra allevamenti e razze allevate

### 3. Tipologia di Cani (`tipologia_di_cani`)
- **Tipo**: Gerarchica
- **Applicata a**: razze_di_cani
- **Uso**: Categorizzazione razze (es: Cani da Pastore, Terrier, Molossoidi, ecc.)

### 4. Categoria FAQ (`categoria_faq`)
- **Tipo**: Gerarchica
- **Applicata a**: faq
- **Uso**: Organizzazione FAQ per argomenti

### 5. Servizi Veterinari (`servizi_veterinari`)
- **Tipo**: Non gerarchica
- **Applicata a**: struttureveterinarie
- **Uso**: Tag servizi offerti (vaccinazioni, sterilizzazione, ortopedia, ecc.)

---

## Template di Pagina

Il tema include **19 page templates** (`theme-caniincasa/page-templates/`):

### Template Autenticazione
1. **template-login.php** - Pagina login con form AJAX
2. **template-registrazione.php** - Pagina registrazione con validazione real-time

### Template Dashboard
3. **template-dashboard.php** - Area personale utente
   - Visualizza annunci dell'utente
   - Gestione annunci (edit/delete)
   - Statistiche quiz completati
   - Informazioni profilo

### Template Archivi con Filtri
4. **template-razze-archive.php** - Archivio razze con filtri AJAX avanzati
   - Filtri per caratteristiche (energia, affettuosità, ecc.)
   - Ricerca testuale
   - Paginazione AJAX

5. **template-razze-semplice.php** - Griglia razze semplice senza filtri

6. **template-allevamenti.php** - Archivio allevamenti filtrabili
   - Filtro per provincia
   - Filtro per razza allevata
   - Ricerca testuale

7. **template-veterinari.php** - Archivio veterinari filtrabili
   - Filtro per provincia
   - Filtro per servizi offerti
   - Ricerca testuale

8. **template-canili.php** - Archivio canili filtrabili

9. **template-centri-cinofili.php** - Archivio centri cinofili filtrabili

10. **template-pensioni.php** - Archivio pensioni filtrabili

### Template Inserimento Annunci
11. **template-inserisci-cucciolata.php** - Form inserimento annuncio "Amici a 4 Zampe"
    - Solo utenti registrati
    - Upload fino a 5 immagini
    - Validazione client + server side
    - Status: pending → publish (dopo moderazione)

12. **template-inserisci-dogsitter.php** - Form inserimento annuncio dogsitter
    - Solo utenti registrati
    - Upload fino a 3 immagini
    - Campi: esperienza, tariffe, disponibilità, servizi, taglie accettate

13. **template-inserisci-annuncio.php** - Form generico inserimento annuncio

### Template Utilità
14. **template-quiz-scelta-razza.php** - Quiz interattivo scelta razza
    - 9 step di domande
    - Algoritmo scoring
    - Email risultati
    - Download PDF

15. **template-richieste-strutture.php** - Form contatti per strutture

16. **template-annunci.php** - Pagina archivio annunci generica

17. **chi-siamo.php** - Pagina chi siamo

18. **contatti.php** - Pagina contatti

19. **full-width.php** - Layout full width senza sidebar

---

## Sistema Annunci

Il sistema annunci è composto da **2 tipologie principali**.

### 1. Annunci Cucciolate ("Amici a 4 Zampe")

**CPT**: `annunci_cucciolate`
**Template Form**: `template-inserisci-cucciolata.php`
**Template Single**: `single-annunci_cucciolate.php`
**Template Archive**: `archive-annunci_cucciolate.php`

#### Campi ACF (group_annunci_cucciolate)
- **ricerca_offerta** (select) - "Offro Cuccioli" / "Cerco Cucciolo"
- **razza** (relationship → razze_di_cani) - Razza collegata
- **data_nascita** (date_picker) - Data nascita cuccioli (solo per "Offerta")
- **numero_maschi** (number) - Numero maschi disponibili
- **numero_femmine** (number) - Numero femmine disponibili
- **prezzo** (number) - Prezzo in € (opzionale)
- **pedigree** (select) - Sì/No
- **foto_genitori** (gallery) - Max 5 immagini genitori
- **documenti_disponibili** (checkbox) - Pedigree, vaccinazioni, microchip, ecc.
- **allevamento_riferimento** (relationship → allevamenti) - Allevamento collegato
- **contatto** (textarea) - Info di contatto
- **data_scadenza** (date_picker) - Scadenza annuncio

#### Workflow
1. Utente compila form su `/inserisci-cucciolata/`
2. AJAX handler: `caniincasa_ajax_submit_cucciolata` (`inc/user-system.php:379`)
3. Post creato con status: **pending**
4. Email notifica inviata ai moderatori
5. Moderatore approva/rifiuta da dashboard
6. Email conferma inviata all'utente
7. Se approvato, status → **publish** e visibile pubblicamente

#### AJAX Handler
```php
// File: theme-caniincasa/inc/user-system.php:379-501
add_action('wp_ajax_caniincasa_submit_cucciolata', 'caniincasa_ajax_submit_cucciolata');

Validazioni:
- Campi obbligatori: titolo, razza, ricerca_offerta, descrizione, provincia
- Se offerta: data_nascita obbligatoria
- Upload max 5 immagini (2MB ciascuna)
- Prima immagine = featured image
```

### 2. Annunci Dogsitter

**CPT**: `annunci_dogsitter`
**Template Form**: `template-inserisci-dogsitter.php`
**Template Single**: `single-annunci_dogsitter.php`
**Template Archive**: `archive-annunci_dogsitter.php`

#### Campi ACF (group_annunci_dogsitter)
- **comune** (text) - Comune di residenza
- **zona_disponibilita** (text) - Zona servizio (es: "Milano centro")
- **esperienza** (select) - Anni esperienza (meno-1, 1-3, 3-5, 5-10, oltre-10)
- **tariffe** (number) - Tariffa oraria in € (5-100)
- **disponibilita** (checkbox) - Mattina, Pomeriggio, Sera, Weekend, Notturno
- **servizi** (checkbox) - Passeggiate, Pensione, Domicilio, Toelettatura, Trasporto, Addestramento
- **taglie** (checkbox) - Piccola, Media, Grande, Gigante
- **contatto_telefono** (text) - Telefono
- **contatto_email** (email) - Email

#### AJAX Handler
```php
// File: theme-caniincasa/inc/user-system.php:503-628
add_action('wp_ajax_caniincasa_submit_dogsitter', 'caniincasa_ajax_submit_dogsitter');

Validazioni:
- Campi obbligatori: titolo, provincia, comune, esperienza, tariffe, descrizione
- Almeno 1 opzione selezionata per: disponibilità, servizi, taglie
- Upload max 3 immagini
- Prima immagine = foto profilo
```

### Visualizzazione Annunci

#### Archive Layout
- **Layout**: Card orizzontali con immagine a sinistra
- **Info mostrate**: Titolo, data, provincia, descrizione (30 parole), badge tipo
- **Paginazione**: WordPress standard con prev/next

#### Single Layout
- **Layout**: 2 colonne (content + sidebar)
- **Content**: Hero con breadcrumbs, info cards, descrizione, gallery
- **Sidebar**: Info contatto, CTA pubblica annuncio, validità annuncio
- **Related**: "Altri annunci" simili (3 card)

---

## Sistema Utenti

**File principale**: `theme-caniincasa/inc/user-system.php`

### Ruoli Custom

#### 1. Utente Registrato (`utente_registrato`)
Capabilities:
- `read` - Lettura contenuti
- `submit_cucciolata` - Invio annunci cucciolate
- `submit_annuncio` - Invio annunci generici
- `view_contacts` - Visualizzazione contatti strutture
- `suggest_edits` - Suggerimento modifiche
- `upload_files` - Caricamento file

Workflow pubblicazione: **Pending** (richiede approvazione)

#### 2. Moderatore Annunci (`moderatore_annunci`)
Capabilities:
- Tutte le cap di Utente Registrato +
- `approve_cucciolate` - Approvazione annunci cucciolate
- `approve_annunci` - Approvazione annunci generici
- `moderate_content` - Moderazione contenuti
- `edit_published_posts` - Modifica post pubblicati
- `delete_published_posts` - Eliminazione post pubblicati
- `publish_posts` - Pubblicazione immediata

### Autenticazione AJAX

#### Registrazione
**Endpoint**: `wp_ajax_nopriv_caniincasa_register`
**Handler**: `caniincasa_ajax_register()` (user-system.php:64-162)

Form fields:
- Username (min 4 caratteri, alfanumerico)
- Email (validazione email)
- Password (min 8 caratteri)
- Conferma password
- Privacy policy (checkbox obbligatorio)

Validazioni:
- Username univoco (check live AJAX)
- Email univoca (check live AJAX)
- Password match
- Sanitizzazione input

Post-registrazione:
- Creazione utente con ruolo `utente_registrato`
- Auto-login
- Redirect a `/dashboard/`
- Email di benvenuto

#### Login
**Endpoint**: `wp_ajax_nopriv_caniincasa_login`
**Handler**: `caniincasa_ajax_login()` (user-system.php:164-200)

Form fields:
- Username o Email
- Password
- Remember me (checkbox)

Post-login:
- Redirect a `/dashboard/` o pagina precedente
- Cookie persistente se "Ricordami"

#### Verifica Disponibilità
**Endpoints**:
- `wp_ajax_nopriv_check_username` - Check username
- `wp_ajax_nopriv_check_email` - Check email

Response:
```json
{
  "available": true/false
}
```

### User Meta
```php
first_name               string  Nome
last_name                string  Cognome
telefono                 string  Telefono contatto
data_registrazione       string  Data iscrizione (Y-m-d)
privacy_accettata        bool    Consenso privacy
quiz_completion_count    int     Numero quiz completati
quiz_last_completion_date string Data ultimo quiz
```

### Dashboard Utente
**Template**: `page-templates/template-dashboard.php`

Sezioni:
1. **Header utente** - Saluto personalizzato, avatar
2. **I miei annunci** - Lista annunci con status (pending/publish)
3. **Azioni annuncio** - Edit, Delete
4. **Statistiche** - Quiz completati, data iscrizione
5. **Profilo** - Modifica dati anagrafici, email, password

### Protezione Contatti
Implementazione: `caniincasa_can_view_contacts()` (template-functions.php)

Logica:
- Contatti visibili SOLO a utenti loggati con `view_contacts` capability
- Non loggati vedono CTA registrazione
- Protezione email e telefono su archivi e single

---

## Funzionalità Quiz

**Template**: `page-templates/template-quiz-scelta-razza.php`
**JavaScript**: `js/quiz-scelta-razza.js`

### Struttura Quiz

#### 9 Step di Domande

1. **Esperienza con cani** (principiante / intermedia / esperto)
2. **Tipo abitazione** (appartamento / casa giardino / fattoria)
3. **Tempo disponibile** (poco / medio / molto)
4. **Livello attività** (sedentario / moderato / molto attivo)
5. **Bambini in casa** (no / sì piccoli / sì grandi)
6. **Altri animali** (no / gatti / cani)
7. **Clima** (freddo / temperato / caldo)
8. **Manutenzione pelo** (bassa / media / alta tolleranza)
9. **Scopo adozione** (compagnia / guardia / sport / famiglia)

### Algoritmo Scoring

Per ogni razza, il quiz calcola un **punteggio 0-100%** basato su:

```javascript
// Pesi caratteristiche (totale: 100)
const weights = {
  livello_esperienza: 15,      // 15%
  adattabilita_appartamento: 12, // 12%
  energia: 15,                 // 15%
  tolleranza_solitudine: 10,   // 10%
  compatibilita_bambini: 12,   // 12%
  compatibilita_animali: 10,   // 10%
  clima: 8,                    // 8%
  perdita_pelo: 8,             // 8%
  scopo: 10                    // 10%
};

// Calcolo score singola caratteristica
charScore = 5 - Math.abs(userValue - breedValue);
weightedScore = (charScore / 5) * weight;

// Score totale razza
totalScore = sum(weightedScore per ogni caratteristica);
percentageMatch = (totalScore / 100) * 100;
```

### Risultati Quiz

Output:
- **Top 10 razze** ordinate per match %
- **Card razza** con:
  - Immagine
  - Nome
  - Percentuale match (barra progressiva)
  - Breve descrizione temperamento
  - Link "Scopri di più"

Azioni:
- **Email risultati** (utenti loggati) - Invia top 10 via email
- **Download PDF** - Genera PDF con risultati
- **Ricomincia quiz** - Reset e riavvio

Tracking:
- Incrementa `quiz_completion_count` user meta
- Salva `quiz_last_completion_date`

---

## Archivi e Filtri AJAX

Tutti gli archivi di strutture implementano **filtri AJAX in real-time**.

### Template con Filtri

1. **template-allevamenti.php**
2. **template-veterinari.php**
3. **template-canili.php**
4. **template-centri-cinofili.php**
5. **template-pensioni.php**
6. **template-razze-archive.php**

### Filtri Comuni

**JavaScript**: `js/archivi-filtri.js`
**AJAX Handler**: `inc/ajax-handlers.php`

#### Parametri Filtro Standard
```javascript
{
  action: 'filter_allevamenti', // CPT-specific
  search: '',                   // Ricerca testuale
  provincia: '',                // Dropdown province
  razza: '',                    // Dropdown razze (solo allevamenti)
  servizi: [],                  // Checkbox servizi (solo veterinari)
  paged: 1                      // Paginazione
}
```

#### Filtri Razze Avanzati

**Template**: `template-razze-archive.php`
**JavaScript**: `js/page-razze-filters.js`

Filtri disponibili:
- **Livello Energia** (1-5 slider)
- **Adattabilità Appartamento** (1-5 slider)
- **Affettuosità** (1-5 slider)
- **Tolleranza Estranei** (1-5 slider)
- **Compatibilità Bambini** (1-5 slider)
- **Facilità Addestramento** (1-5 slider)
- **Perdita Pelo** (1-5 slider)
- **Livello Esperienza** (1-5 slider)
- **Ricerca Testo** (nome razza)
- **Tipologia** (dropdown tassonomia)

Query:
```php
// Esempio meta_query per filtro energia
'meta_query' => array(
  array(
    'key' => 'energia_e_livelli_di_attivita',
    'value' => array($min_energia, $max_energia),
    'type' => 'NUMERIC',
    'compare' => 'BETWEEN'
  )
)
```

### Performance

Ottimizzazioni:
- **Debouncing** ricerca testo (500ms)
- **Caching ACF** fields in loop
- **Pre-load caches** con `update_post_caches()`
- **Lazy loading** immagini
- **Paginazione** 24 risultati per pagina

---

## Campi ACF

Il tema utilizza **Advanced Custom Fields PRO** con field groups registrati programmaticamente.

**File**: `theme-caniincasa/inc/custom-fields.php`

### Field Groups Principali

#### 1. Razze di Cani - Caratteristiche Aggiuntive
**Group Key**: `group_razze_caratteristiche_aggiuntive`
**Location**: razze_di_cani CPT

Campi (tutti range 1-5):
- affettuosita
- socievolezza_cani
- adattabilita_appartamento
- tolleranza_estranei
- intelligenza
- facilita_toelettatura
- livello_esperienza_richiesto
- costo_mantenimento

#### 2. Razze di Cani - Info Sidebar
**Group Key**: `group_razze_info_sidebar`
**Location**: razze_di_cani CPT
**Position**: side

Campi:
- nazione_origine (text)
- colorazioni (textarea)
- temperamento_breve (text, max 100 char)

#### 3. Razze di Cani - Sezioni Contenuto
**Group Key**: `group_razze_sezioni_contenuto`
**Location**: razze_di_cani CPT

Tabs WYSIWYG:
- descrizione_generale
- origini_storia
- aspetto_fisico
- carattere_temperamento
- salute_cura
- attivita_addestramento
- ideale_per

#### 4. Annunci Cucciolate
**Group Key**: `group_annunci_cucciolate`
**Location**: annunci_cucciolate CPT

Vedi [Sistema Annunci](#sistema-annunci) per dettagli completi.

#### 5. Annunci Dogsitter
**Group Key**: `group_annunci_dogsitter`
**Location**: annunci_dogsitter CPT

Vedi [Sistema Annunci](#sistema-annunci) per dettagli completi.

#### 6. Page Hero Settings
**Group Key**: `group_page_hero_settings`
**Location**: page, post, tutti i CPT
**Position**: side

Campi:
- hero_disable (true/false) - Disabilita barra titolo
- page_subtitle (text) - Sottotitolo H2
- hero_background_image (image) - Background custom
- hero_overlay_color (color_picker con opacity) - Colore overlay

### Helper Functions

```php
// Ottieni etichetta rating
caniincasa_get_rating_label($field_name, $value);

// Esempio:
caniincasa_get_rating_label('livello_energia', 4.5);
// Returns: "Alto"
```

---

## File JavaScript

**Directory**: `theme-caniincasa/js/`

### 1. main.js (15KB)
Core JavaScript del tema.

Funzionalità:
- **Menu mobile** - Toggle hamburger, close on outside click
- **Smooth scroll** - Scroll to anchors con offset
- **Back to top** - Bottone scroll top progressivo
- **Lazy loading** - Immagini con Intersection Observer
- **Accessible menus** - Navigazione da tastiera (Arrow keys, Esc, Tab)
- **Form validation** - Validazione HTML5 custom
- **External links** - Apertura link esterni in _blank con rel="noopener"

### 2. auth-forms.js (12KB)
Gestione autenticazione AJAX.

Features:
- **Registrazione AJAX** con validazione live
- **Login AJAX** con remember me
- **Check username** disponibilità real-time
- **Check email** disponibilità real-time
- **Password strength** indicator
- **Form error** display con accessibilità

### 3. quiz-scelta-razza.js (25KB)
Quiz interattivo scelta razza.

Features:
- **9 step** wizard con navigazione prev/next
- **Progress bar** step completion
- **Scoring algorithm** match razze
- **Risultati animati** con percentuale match
- **Email risultati** (utenti loggati)
- **Download PDF** risultati
- **Local storage** save progress
- **Responsive** mobile-friendly

### 4. archivi-filtri.js (8KB)
Filtri AJAX per archivi strutture.

Features:
- **Filtri dinamici** provincia, razza, servizi
- **Ricerca testuale** debounced
- **Paginazione AJAX** infinita o numbered
- **Loading states** spinner durante caricamento
- **URL update** con History API (SEO-friendly)
- **No results** message

### 5. page-razze-filters.js (10KB)
Filtri avanzati archivio razze.

Features:
- **8 slider** range caratteristiche
- **Ricerca testo** nome razza
- **Dropdown tipologia** tassonomia
- **Reset filters** button
- **Active filters** count badge
- **Results count** update real-time

### 6. dashboard.js (18KB)
Dashboard utente.

Features:
- **Gestione annunci** edit/delete AJAX
- **Upload immagini** drag & drop
- **Form submission** cucciolate/dogsitter
- **Image preview** prima upload
- **Validation** client-side
- **Modals** conferma eliminazione

### 7. quiz-scelta-razza.js
Vedi [Funzionalità Quiz](#funzionalità-quiz).

### 8. richieste-strutture.js (5KB)
Form contatti strutture.

Features:
- **Invio AJAX** modulo contatti
- **Validazione** campi obbligatori
- **Success/error** messages
- **reCAPTCHA** integration ready

### Altri File JS
- **rating-display.js** - Visualizzazione stelline rating
- **search-filter.js** - Ricerca avanzata globale
- **customizer.js** - Theme customizer live preview

---

## File CSS

**Directory**: `theme-caniincasa/css/`

### CSS Principali

#### 1. main.css (15KB)
Stili globali e layout base.

Componenti:
- Reset CSS normalize
- Layout grid system
- Typography scale
- Spacing utilities
- Color variables
- Responsive breakpoints
- Utility classes

#### 2. dashboard.css (15KB)
Stili dashboard utente.

Componenti:
- Dashboard layout (sidebar + content)
- Annunci cards management
- Form upload immagini
- Stats widgets
- Profile edit form
- Buttons azioni annuncio

#### 3. page-templates-grid.css (16KB)
Layout archivi strutture.

Componenti:
- Grid responsive (1-2-3-4 colonne)
- Card struttura (image + content + footer)
- Filtri sidebar sticky
- Results header con count
- Pagination styled
- No results state

#### 4. veterinari.css (19KB)
Stili pagina veterinari.

Componenti:
- Hero section custom
- Filtri servizi checkbox-group
- Card veterinari con servizi tags
- Map integration styles
- Contact CTA

#### 5. single-razza.css (14KB)
Layout singola razza.

Componenti:
- Hero con breadcrumbs
- Sidebar info box (origine, colori, temperamento)
- Caratteristiche slider (1-5 visual)
- Tabs contenuto (descrizione, storia, carattere, ecc.)
- Related razze carousel

#### 6. archive-razze.css (11KB)
Archivio razze standard.

Componenti:
- Grid razze responsive
- Card razza (image + nome + meta)
- Filtri caratteristiche
- Active filters tags

#### 7. page-razze-archive.css (13KB)
Template razze con filtri avanzati.

Componenti:
- Sidebar filtri sticky
- 8 range sliders styled
- Reset filters button
- Results count animation

#### 8. auth-pages.css (12KB)
Pagine login/registrazione.

Componenti:
- Form centrato card-style
- Input field states (focus, error, success)
- Password strength meter
- Checkbox custom styled
- Social login buttons ready

#### 9. archivi-filtri.css (3.4KB)
Stili filtri AJAX.

Componenti:
- Filtri sidebar
- Select custom styled
- Checkbox gruppi
- Active filters tags
- Clear all button

#### 10. quiz.css (6KB)
Stili quiz scelta razza.

Componenti:
- Wizard step navigation
- Progress bar
- Question cards
- Risultati cards con % match
- CTA buttons email/PDF

### CSS Componenti (css/components/)

#### cards.css
- Card base styles
- Card variants (horizontal, vertical, highlight)
- Card hover effects
- Card badge/tags

#### forms.css
- Input fields styled
- Select custom arrow
- Checkbox/radio custom
- Textarea auto-resize
- Form validation states
- Error messages

#### blog.css
- Post card
- Post single layout
- Post meta (author, date, categories)
- Social share buttons
- Comments section

#### pages.css
- Page hero
- Page breadcrumbs
- Page sidebar
- Page footer CTA

#### homepage.css
- Hero section homepage
- Features grid
- CTA sections
- Testimonials carousel

#### rating.css
- Star rating display
- Rating input
- Rating aggregate

#### breed-characteristics.css
- Caratteristiche slider (1-5)
- Tooltip labels
- Responsive grid

---

## Sicurezza

**File**: `theme-caniincasa/functions.php`

### Security Headers
Implementati in `caniincasa_security_headers()` (functions.php:1100-1107):

```php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
```

### WordPress Hardening

```php
// Rimozione versione WP (wp_generator)
remove_action('wp_head', 'wp_generator');

// Disabilitazione XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Rimozione emoji scripts (performance)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
```

### AJAX Security

Tutti gli endpoint AJAX implementano:

1. **Nonce Check**
```php
check_ajax_referer('caniincasa_submit_cucciolata', 'nonce');
```

2. **Capability Check**
```php
if (!current_user_can('submit_cucciolata')) {
    wp_send_json_error(['message' => 'Non autorizzato']);
}
```

3. **Input Sanitization**
```php
$titolo = sanitize_text_field($_POST['titolo']);
$email = sanitize_email($_POST['email']);
$descrizione = wp_kses_post($_POST['descrizione']);
```

4. **Output Escaping**
```php
echo esc_html($value);
echo esc_attr($attribute);
echo esc_url($url);
```

### File Upload Security

```php
// Validazione MIME type
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

// Validazione dimensione (2MB max)
$max_size = 2 * 1024 * 1024;

// WordPress media_handle_upload() con validazioni integrate
```

### SQL Injection Prevention

- Uso **$wpdb->prepare()** per query custom
- Uso **WP_Query** con parametri validated
- Intval/floatval per ID numerici

### Development Mode

**Local Development** (functions.php:1133-1142):

```php
if (in_array($_SERVER['HTTP_HOST'], ['localhost', 'caniincasa.local'])) {
    define('RAZZE_SKIP_NONCE_CHECK', true);
    error_log('WARNING: Nonce check skipped for local development');
}
```

⚠️ **Disabilitato in produzione**

---

## Come Usare

### Requisiti Sistema

- **WordPress**: 5.8+
- **PHP**: 7.4+
- **MySQL**: 5.7+
- **Plugins richiesti**:
  - Advanced Custom Fields PRO
  - (Opzionale) WP Mail SMTP per email transazionali

### Installazione

1. **Carica tema**
```bash
wp-content/themes/theme-caniincasa/
```

2. **Attiva tema** da Aspetto → Temi

3. **Installa ACF PRO** (licenza richiesta)

4. **Importa ACF fields** (se necessario)
   - Strumenti → Importa → Custom Fields
   - Seleziona: `acf-export-2025-11-17.json`

5. **Popola province**
   - Le 107 province italiane vengono popolate automaticamente
   - Verificare in: Annunci → Province

6. **Configura permalink**
   - Impostazioni → Permalink
   - Struttura: "Nome articolo" (consigliato)
   - Salva (flush rewrite rules)

### Configurazione Iniziale

#### 1. Crea Pagine Necessarie

Crea pagine con questi **slug esatti**:

| Titolo | Slug | Template |
|--------|------|----------|
| Home | `home` | Front Page |
| Login | `login` | Template: Login |
| Registrazione | `registrazione` | Template: Registrazione |
| Dashboard | `dashboard` | Template: Dashboard Utente |
| Razze | `razze` | Template: Archivio Razze (filtri) |
| Allevamenti | `allevamenti` | Template: Allevamenti |
| Veterinari | `veterinari` | Template: Veterinari |
| Canili | `canili` | Template: Canili |
| Pensioni | `pensioni` | Template: Pensioni |
| Centri Cinofili | `centri-cinofili` | Template: Centri Cinofili |
| Quiz | `quiz-scelta-razza` | Template: Quiz Scelta Razza |
| Inserisci Cucciolata | `inserisci-cucciolata` | Template: Inserisci Cucciolata |
| Inserisci Dogsitter | `inserisci-dogsitter` | Template: Inserisci Dogsitter |

#### 2. Configura Menu

**Aspetto → Menu**

Crea menu "Menu Principale" con voci:
- Home
- Razze
- Allevamenti
- Veterinari
- Canili
- Quiz
- Inserisci Annuncio

Assegna a location: "Primary Menu"

#### 3. Configura Customizer

**Aspetto → Personalizza**

Opzioni disponibili:
- **Google Analytics** - Inserisci GA4 Measurement ID
- **Colori Tema** - Primary, Secondary, Accent
- **Logo** - Upload logo sito
- **Footer** - Testo copyright, social links

#### 4. Crea Utente Moderatore

```bash
# Da WP CLI
wp user create moderatore mod@caniincasa.it --role=moderatore_annunci
```

Oppure da admin:
- Utenti → Aggiungi nuovo
- Ruolo: Moderatore Annunci

### Workflow Pubblicazione Annunci

#### Per Utenti Finali

1. **Registrazione**
   - Vai su `/registrazione/`
   - Compila form con username, email, password
   - Accetta privacy policy
   - Invia → Auto-login → Redirect dashboard

2. **Inserimento Annuncio Cucciolata**
   - Vai su `/inserisci-cucciolata/`
   - Compila tutti i campi obbligatori
   - Upload fino a 5 immagini
   - Invia → Status: **Pending**
   - Attendi email approvazione

3. **Inserimento Annuncio Dogsitter**
   - Vai su `/inserisci-dogsitter/`
   - Compila tutti i campi obbligatori
   - Upload fino a 3 immagini
   - Invia → Status: **Pending**
   - Attendi email approvazione

4. **Gestione Annunci**
   - Vai su `/dashboard/`
   - Visualizza tutti i tuoi annunci
   - Modifica o elimina annunci

#### Per Moderatori

1. **Ricevi Notifica Email**
   - Email automatica per ogni nuovo annuncio pending
   - Link diretto modifica post

2. **Modera Annuncio**
   - Vai su Annunci → Tutti gli annunci
   - Oppure Dashboard widget "Annunci in Attesa"
   - Verifica contenuto e immagini

3. **Approva**
   - Cambia status da "Bozza" a "Pubblicato"
   - Salva
   - Utente riceve email conferma approvazione
   - Annuncio visibile pubblicamente

4. **Rifiuta**
   - Sposta in Cestino
   - Utente riceve email rifiuto (con motivazione opzionale)

### Personalizzazione Tema

#### Aggiungere un Nuovo Campo ACF

```php
// File: theme-caniincasa/inc/custom-fields.php

acf_add_local_field_group(array(
    'key' => 'group_custom',
    'title' => 'Mio Campo Custom',
    'fields' => array(
        array(
            'key' => 'field_mio_campo',
            'label' => 'Etichetta Campo',
            'name' => 'mio_campo',
            'type' => 'text',
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
));
```

#### Aggiungere un Nuovo Ruolo Utente

```php
// File: theme-caniincasa/inc/user-system.php

add_role('nome_ruolo', 'Etichetta Ruolo', array(
    'read' => true,
    'custom_capability' => true,
));
```

#### Aggiungere un Filtro Custom

```php
// File: theme-caniincasa/inc/ajax-handlers.php

add_action('wp_ajax_filter_mio_cpt', 'handle_filter_mio_cpt');
add_action('wp_ajax_nopriv_filter_mio_cpt', 'handle_filter_mio_cpt');

function handle_filter_mio_cpt() {
    $search = sanitize_text_field($_POST['search']);

    $args = array(
        'post_type' => 'mio_cpt',
        's' => $search,
        'posts_per_page' => 24,
    );

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Template card
        }
    }
    $html = ob_get_clean();

    wp_send_json_success(array(
        'html' => $html,
        'found' => $query->found_posts,
    ));
}
```

### Debugging

#### Enable WP_DEBUG

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Log location: `wp-content/debug.log`

#### AJAX Debug

```javascript
// Console log AJAX responses
jQuery(document).ajaxComplete(function(event, xhr, settings) {
    console.log('AJAX:', settings.url, xhr.responseJSON);
});
```

#### ACF Debug

```php
// Visualizza tutti i campi ACF di un post
$fields = get_fields($post_id);
error_log(print_r($fields, true));
```

---

## Pagine da Creare per Inserimento Annunci

### 1. Inserisci Annuncio Amici a 4 Zampe (Cucciolate)
**URL suggerito**: `/inserisci-annuncio-cucciolata/`
**Template**: Inserisci Cucciolata
**Slug**: `inserisci-annuncio-cucciolata`

**Come trovarla nel backend**:
- Vai in Pagine → Tutte le pagine
- Cerca pagina con template "Inserisci Cucciolata"
- Oppure crea nuova pagina e assegna template

### 2. Inserisci Annuncio Dogsitter
**URL suggerito**: `/inserisci-annuncio-dogsitter/`
**Template**: Inserisci Annuncio Dogsitter
**Slug**: `inserisci-annuncio-dogsitter`

**Come trovarla nel backend**:
- Vai in Pagine → Tutte le pagine
- Cerca pagina con template "Inserisci Annuncio Dogsitter"
- Oppure crea nuova pagina e assegna template

---

## Lista Annunci

### Archivi Pubblici

#### Annunci Amici a 4 Zampe (Cucciolate)
**URL archivio**: `/annunci_cucciolate/`
**Template**: `archive-annunci_cucciolate.php`
**Funzionalità**:
- Lista card orizzontali
- Badge tipo (Offerta/Ricerca)
- Info: razza, provincia, data
- Paginazione

#### Annunci Dogsitter
**URL archivio**: `/annunci_dogsitter/`
**Template**: `archive-annunci_dogsitter.php`
**Funzionalità**:
- Lista card orizzontali
- Badge "Dogsitter"
- Info: zona, provincia
- Paginazione

### Singoli Annunci

#### Single Annuncio Cucciolata
**URL**: `/annunci_cucciolate/{slug}/`
**Template**: `single-annunci_cucciolate.php`
**Layout**:
- Hero con breadcrumbs + titolo
- Info cards (data nascita, numero cuccioli, prezzo, pedigree)
- Descrizione completa
- Sidebar con contatti + allevamento collegato
- Galleria foto genitori
- Related annunci (3)

#### Single Annuncio Dogsitter
**URL**: `/annunci_dogsitter/{slug}/`
**Template**: `single-annunci_dogsitter.php`
**Layout**:
- Hero con breadcrumbs + titolo
- Info cards (tariffa, disponibilità)
- Esperienza
- Descrizione servizi
- Servizi offerti (lista checkbox)
- Sidebar contatti

---

## Note Finali

### Versioning
- Versione attuale: **2.0**
- Branch GitHub: `claude/fix-announcement-system-01RzEnqT1m7hYPabdn8aeYs9`

### File Modificati in Questa Sessione
1. `theme-caniincasa/inc/custom-fields.php` - Aggiunti ACF groups per annunci
2. `theme-caniincasa/inc/user-system.php` - Corretti handler AJAX annunci
3. `theme-caniincasa/inc/custom-post-types.php` - Fix post_type annunci_cucciolate

### TODO Future Implementazioni
- [ ] Filtri avanzati per archivi annunci
- [ ] Sistema recensioni strutture
- [ ] Integrazione mappa Google Maps
- [ ] Sistema messaggistica utenti
- [ ] Export annunci in PDF
- [ ] Social login (Facebook, Google)
- [ ] Multi-language (WPML ready)

### Contatti Supporto
**Developer**: Massimiliano
**Email**: [inserire email]
**GitHub**: [inserire repo]

---

**Fine Documentazione**
Ultimo aggiornamento: 17 Novembre 2025
