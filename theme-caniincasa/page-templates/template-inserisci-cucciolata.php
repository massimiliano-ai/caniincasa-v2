<?php
/**
 * Template Name: Inserisci Cucciolata
 * Template Post Type: page
 *
 * Template standalone per inserimento annunci cucciolate
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

<main id="main-content" class="site-main page-inserisci-cucciolata">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="page-header">
            <h1 class="page-title">Pubblica Annuncio</h1>
            <p class="page-subtitle">Compila il form per pubblicare il tuo annuncio</p>
        </div>

        <div class="form-container">

            <form id="cucciolata-form" class="submit-form">
                <?php wp_nonce_field( 'caniincasa_submit_cucciolata', 'cucciolata_nonce' ); ?>

                <div class="form-section">
                    <h2 class="section-title">Tipo di Annuncio</h2>

                    <div class="form-group">
                        <label for="ricerca_offerta">Cosa vuoi fare? *</label>
                        <select id="ricerca_offerta" name="ricerca_offerta" required>
                            <option value="">Seleziona tipo</option>
                            <option value="offerta">Offro cuccioli</option>
                            <option value="ricerca">Cerco cucciolo</option>
                        </select>
                        <small class="form-help">Scegli se stai offrendo cuccioli o cercando un cucciolo da adottare</small>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Informazioni Base</h2>

                    <div class="form-group">
                        <label for="titolo">Titolo Annuncio *</label>
                        <input type="text" id="titolo" name="titolo" required
                               placeholder="Es: Cuccioli di Labrador Retriever disponibili">
                        <small class="form-help">Scegli un titolo chiaro e descrittivo</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="razza">Razza *</label>
                            <select id="razza" name="razza" required>
                                <option value="">Seleziona una razza</option>
                                <?php
                                $razze = get_posts( array(
                                    'post_type' => 'razze_di_cani',
                                    'posts_per_page' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                ) );

                                foreach ( $razze as $razza ):
                                ?>
                                    <option value="<?php echo $razza->ID; ?>">
                                        <?php echo esc_html( $razza->post_title ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group field-offerta-only">
                            <label for="data_nascita">Data di Nascita Cuccioli <span class="required-offerta">*</span></label>
                            <input type="date" id="data_nascita" name="data_nascita" data-required-for="offerta">
                        </div>
                    </div>

                    <div class="form-row field-offerta-only">
                        <div class="form-group">
                            <label for="numero_maschi">Numero Maschi</label>
                            <input type="number" id="numero_maschi" name="numero_maschi" min="0" value="0">
                        </div>

                        <div class="form-group">
                            <label for="numero_femmine">Numero Femmine</label>
                            <input type="number" id="numero_femmine" name="numero_femmine" min="0" value="0">
                        </div>
                    </div>

                    <div class="form-row field-offerta-only">
                        <div class="form-group">
                            <label for="prezzo">Prezzo (€)</label>
                            <input type="number" id="prezzo" name="prezzo" min="0" step="50"
                                   placeholder="Lascia vuoto se non specificato">
                            <small class="form-help">Prezzo per cucciolo (opzionale)</small>
                        </div>

                        <div class="form-group">
                            <label for="pedigree">Pedigree</label>
                            <select id="pedigree" name="pedigree">
                                <option value="">Seleziona</option>
                                <option value="si">Sì</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Posizione</h2>

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
                </div>

                <div class="form-section">
                    <h2 class="section-title">Descrizione</h2>

                    <div class="form-group">
                        <label for="descrizione">Descrizione *</label>
                        <textarea id="descrizione" name="descrizione" rows="8" required
                                  placeholder="Descrivi l'annuncio, i cuccioli, i genitori, eventuali caratteristiche, temperamento..."></textarea>
                        <small class="form-help">Minimo 100 caratteri. Descrivi dettagliatamente l'annuncio.</small>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">Immagini</h2>

                    <div class="form-group">
                        <label for="immagini">Foto dei Cuccioli</label>
                        <input type="file" id="immagini" name="immagini[]" multiple accept="image/*">
                        <small class="form-help">Puoi caricare fino a 5 immagini (max 2MB ciascuna). La prima immagine sarà quella di copertina.</small>
                        <div id="image-preview" class="image-preview-grid"></div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms" id="terms" required>
                            <span>Ho letto e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a> per la pubblicazione di annunci *</span>
                        </label>
                    </div>

                    <div class="form-message info">
                        <strong>ℹ️ Nota:</strong> Il tuo annuncio sarà sottoposto a moderazione prima della pubblicazione.
                        Riceverai una notifica via email quando verrà approvato.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        📤 Pubblica Annuncio
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
