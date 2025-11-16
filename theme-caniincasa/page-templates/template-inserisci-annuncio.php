<?php
/**
 * Template Name: Inserisci Annuncio
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url( '/login/?redirect_to=' . urlencode( get_permalink() ) ) );
    exit;
}

get_header();
?>

<main id="main-content" class="site-main page-inserisci-annuncio">

    <?php
    // Hero Section
    caniincasa_page_hero( array(
        'subtitle' => 'Inserisci Annuncio',
    ) );
    ?>

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <div class="inserisci-annuncio-layout">

            <!-- Info Sidebar -->
            <aside class="inserisci-annuncio-sidebar">
                <div class="info-box">
                    <h3>ℹ️ Come funziona</h3>
                    <ol>
                        <li>Scegli il tipo di annuncio</li>
                        <li>Compila tutti i campi richiesti</li>
                        <li>Aggiungi foto di qualità</li>
                        <li>Invia per la revisione</li>
                    </ol>
                    <p class="info-note">
                        <strong>Nota:</strong> Il tuo annuncio sarà visibile dopo l'approvazione da parte del team.
                    </p>
                </div>

                <div class="info-box">
                    <h3>📋 Linee guida</h3>
                    <ul>
                        <li>Scrivi descrizioni chiare e dettagliate</li>
                        <li>Usa foto nitide e rappresentative</li>
                        <li>Inserisci informazioni veritiere</li>
                        <li>Rispetta le norme sulla compravendita</li>
                    </ul>
                </div>
            </aside>

            <!-- Main Form -->
            <div class="inserisci-annuncio-content">

                <!-- Selezione Tipo Annuncio -->
                <div class="tipo-annuncio-selector">
                    <h2>Che tipo di annuncio vuoi pubblicare?</h2>
                    <div class="tipo-cards">
                        <div class="tipo-card" data-tipo="cucciolata">
                            <div class="tipo-icon">🐶</div>
                            <h3>Cucciolata</h3>
                            <p>Pubblica un annuncio per cuccioli disponibili</p>
                            <button type="button" class="btn btn-primary select-tipo" data-tipo="cucciolata">
                                Seleziona
                            </button>
                        </div>

                        <div class="tipo-card" data-tipo="dogsitter">
                            <div class="tipo-icon">🦴</div>
                            <h3>Dogsitter</h3>
                            <p>Offri o cerca servizi di dog sitting</p>
                            <button type="button" class="btn btn-primary select-tipo" data-tipo="dogsitter">
                                Seleziona
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Cucciolata -->
                <div id="form-cucciolata" class="annuncio-form" style="display: none;">
                    <h2>📝 Inserisci Annuncio Cucciolata</h2>

                    <form id="inserisci-cucciolata-form" class="annuncio-form-content" enctype="multipart/form-data">

                        <input type="hidden" name="action" value="submit_annuncio_cucciolata">
                        <input type="hidden" name="nonce" id="nonce-cucciolata" value="<?php echo wp_create_nonce( 'submit_annuncio_cucciolata' ); ?>">

                        <!-- Titolo -->
                        <div class="form-group">
                            <label for="titolo-cucciolata">
                                Titolo Annuncio <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                id="titolo-cucciolata"
                                name="titolo"
                                class="form-control"
                                placeholder="Es: Cuccioli di Labrador Retriever disponibili"
                                required
                            >
                        </div>

                        <!-- Tipo (Offerta/Ricerca) -->
                        <div class="form-group">
                            <label for="ricerca-offerta">
                                Tipo Annuncio <span class="required">*</span>
                            </label>
                            <select id="ricerca-offerta" name="ricerca_offerta" class="form-control" required>
                                <option value="">Seleziona...</option>
                                <option value="offerta">Offro cuccioli</option>
                                <option value="ricerca">Cerco cucciolo</option>
                            </select>
                        </div>

                        <!-- Razza -->
                        <div class="form-group">
                            <label for="razza-cucciolata">
                                Razza <span class="required">*</span>
                            </label>
                            <select id="razza-cucciolata" name="razza" class="form-control" required>
                                <option value="">Seleziona razza...</option>
                                <?php
                                // Get all razze
                                $razze = get_posts( array(
                                    'post_type' => 'razze_di_cani',
                                    'posts_per_page' => -1,
                                    'orderby' => 'title',
                                    'order' => 'ASC',
                                ) );

                                foreach ( $razze as $razza ):
                                ?>
                                    <option value="<?php echo esc_attr( $razza->ID ); ?>">
                                        <?php echo esc_html( $razza->post_title ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Provincia -->
                        <div class="form-group">
                            <label for="provincia-cucciolata">
                                Provincia <span class="required">*</span>
                            </label>
                            <select id="provincia-cucciolata" name="provincia" class="form-control" required>
                                <option value="">Seleziona provincia...</option>
                                <?php
                                // Get all province terms
                                $province_terms = get_terms( array(
                                    'taxonomy' => 'provincia',
                                    'hide_empty' => false,
                                    'orderby' => 'name',
                                    'order' => 'ASC',
                                ) );

                                if ( ! empty( $province_terms ) && ! is_wp_error( $province_terms ) ):
                                    foreach ( $province_terms as $provincia ):
                                ?>
                                    <option value="<?php echo esc_attr( $provincia->term_id ); ?>">
                                        <?php echo esc_html( $provincia->name ); ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <!-- Descrizione -->
                        <div class="form-group">
                            <label for="descrizione-cucciolata">
                                Descrizione <span class="required">*</span>
                            </label>
                            <textarea
                                id="descrizione-cucciolata"
                                name="descrizione"
                                class="form-control"
                                rows="8"
                                placeholder="Descrivi i cuccioli, le caratteristiche, i genitori, eventuali certificazioni, ecc."
                                required
                            ></textarea>
                        </div>

                        <!-- Prezzo -->
                        <div class="form-group">
                            <label for="prezzo-cucciolata">
                                Prezzo (€)
                            </label>
                            <input
                                type="number"
                                id="prezzo-cucciolata"
                                name="prezzo"
                                class="form-control"
                                min="0"
                                step="10"
                                placeholder="Es: 800"
                            >
                            <small class="form-text">Lascia vuoto se da concordare</small>
                        </div>

                        <!-- Immagine -->
                        <div class="form-group">
                            <label for="immagine-cucciolata">
                                Foto Principale <span class="required">*</span>
                            </label>
                            <input
                                type="file"
                                id="immagine-cucciolata"
                                name="immagine"
                                class="form-control"
                                accept="image/*"
                                required
                            >
                            <small class="form-text">Formati accettati: JPG, PNG. Max 5MB</small>
                        </div>

                        <!-- Contatti -->
                        <div class="form-group">
                            <label for="telefono-cucciolata">
                                Telefono <span class="required">*</span>
                            </label>
                            <input
                                type="tel"
                                id="telefono-cucciolata"
                                name="telefono"
                                class="form-control"
                                placeholder="Es: 333 1234567"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email-cucciolata">
                                Email <span class="required">*</span>
                            </label>
                            <input
                                type="email"
                                id="email-cucciolata"
                                name="email"
                                class="form-control"
                                value="<?php echo esc_attr( wp_get_current_user()->user_email ); ?>"
                                required
                            >
                        </div>

                        <!-- Privacy -->
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="privacy" required>
                                Accetto i <a href="<?php echo home_url( '/privacy-policy/' ); ?>" target="_blank">termini e condizioni</a> <span class="required">*</span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline back-to-selection">
                                ← Indietro
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Pubblica Annuncio
                            </button>
                        </div>

                        <!-- Messages -->
                        <div id="form-message-cucciolata" class="form-message" style="display: none;"></div>

                    </form>
                </div>

                <!-- Form Dogsitter -->
                <div id="form-dogsitter" class="annuncio-form" style="display: none;">
                    <h2>📝 Inserisci Annuncio Dogsitter</h2>

                    <form id="inserisci-dogsitter-form" class="annuncio-form-content" enctype="multipart/form-data">

                        <input type="hidden" name="action" value="submit_annuncio_dogsitter">
                        <input type="hidden" name="nonce" id="nonce-dogsitter" value="<?php echo wp_create_nonce( 'submit_annuncio_dogsitter' ); ?>">

                        <!-- Titolo -->
                        <div class="form-group">
                            <label for="titolo-dogsitter">
                                Titolo Annuncio <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                id="titolo-dogsitter"
                                name="titolo"
                                class="form-control"
                                placeholder="Es: Dog sitter disponibile per passeggiate"
                                required
                            >
                        </div>

                        <!-- Provincia -->
                        <div class="form-group">
                            <label for="provincia-dogsitter">
                                Provincia <span class="required">*</span>
                            </label>
                            <select id="provincia-dogsitter" name="provincia" class="form-control" required>
                                <option value="">Seleziona provincia...</option>
                                <?php
                                if ( ! empty( $province_terms ) && ! is_wp_error( $province_terms ) ):
                                    foreach ( $province_terms as $provincia ):
                                ?>
                                    <option value="<?php echo esc_attr( $provincia->term_id ); ?>">
                                        <?php echo esc_html( $provincia->name ); ?>
                                    </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <!-- Zona Disponibilità -->
                        <div class="form-group">
                            <label for="zona-disponibilita">
                                Zona Disponibilità
                            </label>
                            <input
                                type="text"
                                id="zona-disponibilita"
                                name="zona_disponibilita"
                                class="form-control"
                                placeholder="Es: Centro città, zona nord"
                            >
                        </div>

                        <!-- Descrizione -->
                        <div class="form-group">
                            <label for="descrizione-dogsitter">
                                Descrizione <span class="required">*</span>
                            </label>
                            <textarea
                                id="descrizione-dogsitter"
                                name="descrizione"
                                class="form-control"
                                rows="8"
                                placeholder="Descrivi i tuoi servizi, esperienza, disponibilità, tariffe, ecc."
                                required
                            ></textarea>
                        </div>

                        <!-- Foto -->
                        <div class="form-group">
                            <label for="immagine-dogsitter">
                                Foto
                            </label>
                            <input
                                type="file"
                                id="immagine-dogsitter"
                                name="immagine"
                                class="form-control"
                                accept="image/*"
                            >
                            <small class="form-text">Formati accettati: JPG, PNG. Max 5MB</small>
                        </div>

                        <!-- Contatti -->
                        <div class="form-group">
                            <label for="telefono-dogsitter">
                                Telefono <span class="required">*</span>
                            </label>
                            <input
                                type="tel"
                                id="telefono-dogsitter"
                                name="telefono"
                                class="form-control"
                                placeholder="Es: 333 1234567"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="email-dogsitter">
                                Email <span class="required">*</span>
                            </label>
                            <input
                                type="email"
                                id="email-dogsitter"
                                name="email"
                                class="form-control"
                                value="<?php echo esc_attr( wp_get_current_user()->user_email ); ?>"
                                required
                            >
                        </div>

                        <!-- Privacy -->
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="privacy" required>
                                Accetto i <a href="<?php echo home_url( '/privacy-policy/' ); ?>" target="_blank">termini e condizioni</a> <span class="required">*</span>
                            </label>
                        </div>

                        <!-- Submit -->
                        <div class="form-actions">
                            <button type="button" class="btn btn-outline back-to-selection">
                                ← Indietro
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Pubblica Annuncio
                            </button>
                        </div>

                        <!-- Messages -->
                        <div id="form-message-dogsitter" class="form-message" style="display: none;"></div>

                    </form>
                </div>

            </div>

        </div>

    </div>

</main>

<script>
jQuery(document).ready(function($) {
    // Selezione tipo annuncio
    $('.select-tipo').on('click', function() {
        var tipo = $(this).data('tipo');
        $('.tipo-annuncio-selector').fadeOut(300, function() {
            if (tipo === 'cucciolata') {
                $('#form-cucciolata').fadeIn(300);
            } else {
                $('#form-dogsitter').fadeIn(300);
            }
        });
    });

    // Back to selection
    $('.back-to-selection').on('click', function() {
        $('.annuncio-form').fadeOut(300, function() {
            $('.tipo-annuncio-selector').fadeIn(300);
        });
    });

    // Submit Cucciolata
    $('#inserisci-cucciolata-form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var $button = $(this).find('button[type="submit"]');
        var $message = $('#form-message-cucciolata');

        $button.prop('disabled', true).text('Invio in corso...');
        $message.hide();

        $.ajax({
            url: canincasaAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $message.removeClass('error').addClass('success')
                        .html('<strong>✓ Successo!</strong> ' + response.data.message)
                        .fadeIn();

                    $('#inserisci-cucciolata-form')[0].reset();

                    setTimeout(function() {
                        window.location.href = canincasaAjax.homeurl + '/dashboard/';
                    }, 2000);
                } else {
                    $message.removeClass('success').addClass('error')
                        .html('<strong>✗ Errore:</strong> ' + response.data.message)
                        .fadeIn();
                }
            },
            error: function() {
                $message.removeClass('success').addClass('error')
                    .html('<strong>✗ Errore:</strong> Si è verificato un errore. Riprova.')
                    .fadeIn();
            },
            complete: function() {
                $button.prop('disabled', false).text('Pubblica Annuncio');
            }
        });
    });

    // Submit Dogsitter
    $('#inserisci-dogsitter-form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var $button = $(this).find('button[type="submit"]');
        var $message = $('#form-message-dogsitter');

        $button.prop('disabled', true).text('Invio in corso...');
        $message.hide();

        $.ajax({
            url: canincasaAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $message.removeClass('error').addClass('success')
                        .html('<strong>✓ Successo!</strong> ' + response.data.message)
                        .fadeIn();

                    $('#inserisci-dogsitter-form')[0].reset();

                    setTimeout(function() {
                        window.location.href = canincasaAjax.homeurl + '/dashboard/';
                    }, 2000);
                } else {
                    $message.removeClass('success').addClass('error')
                        .html('<strong>✗ Errore:</strong> ' + response.data.message)
                        .fadeIn();
                }
            },
            error: function() {
                $message.removeClass('success').addClass('error')
                    .html('<strong>✗ Errore:</strong> Si è verificato un errore. Riprova.')
                    .fadeIn();
            },
            complete: function() {
                $button.prop('disabled', false).text('Pubblica Annuncio');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
