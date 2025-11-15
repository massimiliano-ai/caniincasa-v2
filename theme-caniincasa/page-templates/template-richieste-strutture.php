<?php
/**
 * Template Name: Richieste Strutture
 * Template Post Type: page
 *
 * Form per richiedere inserimento/modifica/rimozione di strutture
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Require login
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url( '/login/' ) );
    exit;
}

get_header();

$current_user = wp_get_current_user();
$active_tipo = isset( $_GET['tipo'] ) ? sanitize_text_field( $_GET['tipo'] ) : 'allevamento';
$active_azione = isset( $_GET['azione'] ) ? sanitize_text_field( $_GET['azione'] ) : 'inserimento';
?>

<main id="main-content" class="site-main page-richieste-strutture">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="richieste-header">
            <h1 class="page-title">Richieste Strutture</h1>
            <p class="page-subtitle">Richiedi l'inserimento, la modifica o la rimozione di strutture (allevamenti, veterinari, centri cinofili, canili, pensioni)</p>
        </div>

        <!-- Tabs Tipo Struttura -->
        <div class="richieste-tabs">
            <nav class="tabs-nav tipo-struttura-tabs">
                <a href="?tipo=allevamento&azione=<?php echo $active_azione; ?>" class="tab-link <?php echo $active_tipo === 'allevamento' ? 'active' : ''; ?>">
                    <span class="icon">🏠</span> Allevamento
                </a>
                <a href="?tipo=veterinario&azione=<?php echo $active_azione; ?>" class="tab-link <?php echo $active_tipo === 'veterinario' ? 'active' : ''; ?>">
                    <span class="icon">🏥</span> Veterinario
                </a>
                <a href="?tipo=centro&azione=<?php echo $active_azione; ?>" class="tab-link <?php echo $active_tipo === 'centro' ? 'active' : ''; ?>">
                    <span class="icon">🎓</span> Centro Cinofilo
                </a>
                <a href="?tipo=canile&azione=<?php echo $active_azione; ?>" class="tab-link <?php echo $active_tipo === 'canile' ? 'active' : ''; ?>">
                    <span class="icon">🐾</span> Canile
                </a>
                <a href="?tipo=pensione&azione=<?php echo $active_azione; ?>" class="tab-link <?php echo $active_tipo === 'pensione' ? 'active' : ''; ?>">
                    <span class="icon">🏨</span> Pensione
                </a>
            </nav>

            <!-- Sub-tabs Azione -->
            <nav class="tabs-nav azione-tabs">
                <a href="?tipo=<?php echo $active_tipo; ?>&azione=inserimento" class="tab-link <?php echo $active_azione === 'inserimento' ? 'active' : ''; ?>">
                    <span class="icon">➕</span> Inserimento
                </a>
                <a href="?tipo=<?php echo $active_tipo; ?>&azione=modifica" class="tab-link <?php echo $active_azione === 'modifica' ? 'active' : ''; ?>">
                    <span class="icon">✏️</span> Modifica
                </a>
                <a href="?tipo=<?php echo $active_tipo; ?>&azione=rimozione" class="tab-link <?php echo $active_azione === 'rimozione' ? 'active' : ''; ?>">
                    <span class="icon">🗑️</span> Rimozione
                </a>
            </nav>
        </div>

        <!-- Form Content -->
        <div class="richieste-content">

            <div class="richiesta-box">

                <form id="richiesta-struttura-form" class="richiesta-form" data-tipo="<?php echo esc_attr( $active_tipo ); ?>" data-azione="<?php echo esc_attr( $active_azione ); ?>">

                    <?php wp_nonce_field( 'caniincasa_submit_richiesta', 'richiesta_nonce' ); ?>

                    <input type="hidden" name="tipo_struttura" value="<?php echo esc_attr( $active_tipo ); ?>">
                    <input type="hidden" name="tipo_azione" value="<?php echo esc_attr( $active_azione ); ?>">

                    <?php if ( $active_azione === 'modifica' || $active_azione === 'rimozione' ): ?>

                        <!-- Nome Struttura Esistente -->
                        <div class="form-group">
                            <label for="nome_struttura_esistente">Nome Struttura <?php echo ucfirst( $active_tipo ); ?> *</label>
                            <input type="text" id="nome_struttura_esistente" name="nome_struttura_esistente" required
                                   placeholder="Inserisci il nome della struttura da <?php echo $active_azione === 'modifica' ? 'modificare' : 'rimuovere'; ?>">
                            <small class="form-help">Indica il nome esatto come appare sul sito</small>
                        </div>

                    <?php endif; ?>

                    <?php if ( $active_azione === 'inserimento' || $active_azione === 'modifica' ): ?>

                        <!-- Nome Nuova Struttura -->
                        <div class="form-group">
                            <label for="nome_struttura">Nome <?php echo ucfirst( $active_tipo ); ?> <?php echo $active_azione === 'modifica' ? '(Nuovo)' : ''; ?> *</label>
                            <input type="text" id="nome_struttura" name="nome_struttura" required
                                   placeholder="Es: Allevamento dei Cuccioli Felici">
                        </div>

                        <!-- Indirizzo Completo -->
                        <div class="form-group">
                            <label for="indirizzo">Indirizzo Completo *</label>
                            <input type="text" id="indirizzo" name="indirizzo" required
                                   placeholder="Via, Numero Civico">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="provincia">Provincia *</label>
                                <select id="provincia" name="provincia" required>
                                    <option value="">Seleziona provincia</option>
                                    <?php
                                    $province = get_terms( array(
                                        'taxonomy' => 'provincia',
                                        'hide_empty' => false,
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                    ) );

                                    foreach ( $province as $provincia ):
                                    ?>
                                        <option value="<?php echo $provincia->term_id; ?>">
                                            <?php echo esc_html( $provincia->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="comune">Comune *</label>
                                <input type="text" id="comune" name="comune" required
                                       placeholder="Es: Milano">
                            </div>

                            <div class="form-group">
                                <label for="cap">CAP</label>
                                <input type="text" id="cap" name="cap" pattern="[0-9]{5}"
                                       placeholder="Es: 20121">
                            </div>
                        </div>

                        <!-- Contatti -->
                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefono">Telefono *</label>
                                <input type="tel" id="telefono" name="telefono" required
                                       placeholder="+39 ...">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                       placeholder="info@esempio.it">
                            </div>

                            <div class="form-group">
                                <label for="sito_web">Sito Web</label>
                                <input type="url" id="sito_web" name="sito_web"
                                       placeholder="https://...">
                            </div>
                        </div>

                        <?php if ( $active_tipo === 'allevamento' ): ?>
                            <!-- Razze Allevate -->
                            <div class="form-group">
                                <label for="razze_allevate">Razze Allevate</label>
                                <textarea id="razze_allevate" name="razze_allevate" rows="3"
                                          placeholder="Elenca le razze allevate (una per riga o separate da virgola)"></textarea>
                            </div>

                            <div class="form-group checkbox-group-inline">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="enci_riconosciuto" value="1">
                                    <span>Allevamento riconosciuto ENCI</span>
                                </label>
                            </div>
                        <?php endif; ?>

                        <!-- Descrizione -->
                        <div class="form-group">
                            <label for="descrizione">Descrizione Servizi</label>
                            <textarea id="descrizione" name="descrizione" rows="5"
                                      placeholder="Descrivi i servizi offerti, le specializzazioni, gli orari di apertura..."></textarea>
                        </div>

                    <?php endif; ?>

                    <!-- Motivazione (per modifica/rimozione) -->
                    <?php if ( $active_azione === 'modifica' || $active_azione === 'rimozione' ): ?>
                        <div class="form-group">
                            <label for="motivazione">Motivazione Richiesta *</label>
                            <textarea id="motivazione" name="motivazione" rows="4" required
                                      placeholder="Spiega perché richiedi questa <?php echo $active_azione; ?>..."></textarea>
                            <small class="form-help">Minimo 50 caratteri</small>
                        </div>
                    <?php endif; ?>

                    <!-- Note Aggiuntive -->
                    <div class="form-group">
                        <label for="note">Note Aggiuntive</label>
                        <textarea id="note" name="note" rows="3"
                                  placeholder="Eventuali note o informazioni aggiuntive..."></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <span class="btn-text">Invia Richiesta</span>
                            <span class="btn-loading" style="display:none;">
                                <span class="spinner"></span> Invio...
                            </span>
                        </button>
                        <a href="<?php echo home_url( '/dashboard/' ); ?>" class="btn btn-outline">Annulla</a>
                    </div>

                    <!-- Messages -->
                    <div class="form-message" id="richiesta-message" style="display:none;"></div>

                </form>

            </div>

            <!-- Info Box -->
            <div class="richieste-info">
                <h3>ℹ️ Come funziona</h3>
                <p><strong>Tempi di Risposta:</strong> Le richieste vengono elaborate entro 2-3 giorni lavorativi.</p>
                <p><strong>Verifica:</strong> Tutte le richieste vengono verificate dal nostro staff prima dell'approvazione.</p>
                <p><strong>Notifiche:</strong> Riceverai un'email quando la tua richiesta sarà stata elaborata.</p>

                <div class="tips-box">
                    <h4>💡 Suggerimenti</h4>
                    <ul>
                        <li>Fornisci informazioni complete e accurate</li>
                        <li>Verifica che i dati di contatto siano corretti</li>
                        <li>Per le modifiche, specifica chiaramente cosa va cambiato</li>
                        <li>Allega documentazione se disponibile (ENCI, licenze, ecc.)</li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</main>

<?php get_footer(); ?>
