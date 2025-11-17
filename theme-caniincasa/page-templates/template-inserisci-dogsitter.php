<?php
/**
 * Template Name: Inserisci Annuncio Dogsitter
 * Template Post Type: page
 *
 * Template standalone per inserimento annunci dogsitter
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Require login
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url( '/login/' ) );
    exit;
}

// Check user capability
if ( ! current_user_can( 'submit_cucciolata' ) ) {
    wp_redirect( home_url( '/dashboard/' ) );
    exit;
}

get_header();

$current_user = wp_get_current_user();
?>

<main id="main-content" class="site-main page-inserisci-dogsitter">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="page-header">
            <h1 class="page-title">Offri il tuo Servizio di Dogsitter</h1>
            <p class="page-subtitle">Compila il form per proporti come dogsitter. Il tuo annuncio sarà visibile dopo la moderazione.</p>
        </div>

        <div class="form-container">

            <form id="dogsitter-form" class="submit-form">
                <?php wp_nonce_field( 'caniincasa_submit_dogsitter', 'dogsitter_nonce' ); ?>

                <div class="form-section">
                    <h2 class="section-title">Informazioni Base</h2>

                    <div class="form-group">
                        <label for="titolo_dogsitter">Titolo Annuncio *</label>
                        <input type="text" id="titolo_dogsitter" name="titolo" required
                               placeholder="Es: Dogsitter esperto con esperienza pluriennale">
                        <small class="form-help">Scegli un titolo accattivante che descriva i tuoi servizi</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="provincia_dogsitter">Provincia *</label>
                            <select id="provincia_dogsitter" name="provincia" required>
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
                            <label for="comune_dogsitter">Comune</label>
                            <input type="text" id="comune_dogsitter" name="comune"
                                   placeholder="Es: Milano">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="zona_disponibilita">Zona Disponibilità</label>
                        <input type="text" id="zona_disponibilita" name="zona_disponibilita"
                               placeholder="Es: Milano centro, Provincia di Roma, ecc.">
                        <small class="form-help">Specifica l'area in cui offri i tuoi servizi</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="esperienza">Anni di Esperienza</label>
                            <select id="esperienza" name="esperienza">
                                <option value="">Seleziona</option>
                                <option value="meno-1">Meno di 1 anno</option>
                                <option value="1-3">1-3 anni</option>
                                <option value="3-5">3-5 anni</option>
                                <option value="5-10">5-10 anni</option>
                                <option value="oltre-10">Oltre 10 anni</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tariffe">Tariffa Oraria (€)</label>
                            <input type="number" id="tariffe" name="tariffe" min="5" max="100" step="1"
                                   placeholder="Es: 15">
                            <small class="form-help">Tariffa oraria indicativa in euro (opzionale)</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Disponibilità e Servizi</h2>

                    <div class="form-group">
                        <label>Disponibilità Oraria</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita[]" value="mattina">
                                <span>🌅 Mattina (08:00-13:00)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita[]" value="pomeriggio">
                                <span>☀️ Pomeriggio (13:00-19:00)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita[]" value="sera">
                                <span>🌆 Sera (19:00-23:00)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita[]" value="weekend">
                                <span>📅 Weekend</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="disponibilita[]" value="notturno">
                                <span>🌙 Notturno</span>
                            </label>
                        </div>
                        <small class="form-help">Seleziona le fasce orarie in cui sei disponibile (opzionale)</small>
                    </div>

                    <div class="form-group">
                        <label>Servizi Offerti</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="servizi[]" value="passeggiate">
                                <span>🚶 Passeggiate</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servizi[]" value="pensione">
                                <span>🏠 Pensione a casa mia</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servizi[]" value="domicilio">
                                <span>🏡 Assistenza a domicilio</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servizi[]" value="toelettatura">
                                <span>✂️ Toelettatura base</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servizi[]" value="trasporto">
                                <span>🚗 Trasporto</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="servizi[]" value="addestramento">
                                <span>🎓 Addestramento base</span>
                            </label>
                        </div>
                        <small class="form-help">Seleziona i servizi che offri (opzionale)</small>
                    </div>

                    <div class="form-group">
                        <label>Taglie Accettate</label>
                        <div class="checkbox-group checkbox-group-inline">
                            <label class="checkbox-label">
                                <input type="checkbox" name="taglie[]" value="piccola">
                                <span>🐕 Piccola (fino a 10kg)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="taglie[]" value="media">
                                <span>🐕 Media (10-25kg)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="taglie[]" value="grande">
                                <span>🐕 Grande (25-45kg)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="taglie[]" value="gigante">
                                <span>🐕 Gigante (oltre 45kg)</span>
                            </label>
                        </div>
                        <small class="form-help">Seleziona le taglie che puoi accettare (opzionale)</small>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Presentazione</h2>

                    <div class="form-group">
                        <label for="descrizione_dogsitter">Descrizione dei Tuoi Servizi</label>
                        <textarea id="descrizione_dogsitter" name="descrizione" rows="10"
                                  placeholder="Descrivi la tua esperienza, le tue competenze, eventuali certificazioni, disponibilità di spazi (giardino, ecc.), e cosa ti rende un buon dogsitter..."></textarea>
                        <small class="form-help">Più dettagliata è la descrizione, più sarà convincente per i proprietari (opzionale).</small>
                        <div id="char-count" class="char-count">0 caratteri</div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Contatti</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="tel" id="telefono" name="contatto_telefono"
                                   placeholder="Es: 333 1234567">
                            <small class="form-help">Numero di telefono per essere contattato (opzionale)</small>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="contatto_email"
                                   placeholder="tua@email.it">
                            <small class="form-help">Email di contatto (opzionale)</small>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Foto</h2>

                    <div class="form-group">
                        <label for="immagini_dogsitter">Foto Profilo e Immagini</label>
                        <input type="file" id="immagini_dogsitter" name="immagini[]" multiple accept="image/*">
                        <small class="form-help">
                            <strong>Importante:</strong> La prima foto sarà la tua foto profilo.
                            Puoi caricare fino a 3 immagini (max 2MB ciascuna).
                            Ti consigliamo di includere una tua foto e foto di eventuali spazi disponibili.
                        </small>
                        <div id="image-preview" class="image-preview-grid"></div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms_dogsitter" id="terms_dogsitter" required>
                            <span>Ho letto e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a> per la pubblicazione di annunci *</span>
                        </label>
                    </div>

                    <div class="form-message info">
                        <strong>ℹ️ Nota Importante:</strong> Il tuo annuncio sarà sottoposto a moderazione prima della pubblicazione.
                        Riceverai una notifica via email quando verrà approvato. Assicurati che tutte le informazioni siano corrette e veritiere.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <span class="btn-text">📤 Invia Annuncio</span>
                        <span class="btn-loading" style="display:none;">
                            <span class="spinner"></span> Invio in corso...
                        </span>
                    </button>
                    <a href="<?php echo home_url( '/dashboard/' ); ?>" class="btn btn-outline">
                        ← Torna alla Dashboard
                    </a>
                </div>

                <div id="form-response" class="form-response"></div>
            </form>

        </div>

    </div>

</main>

<?php get_footer(); ?>
