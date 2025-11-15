<?php
/**
 * Template Name: Dashboard Utente
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url( '/login/' ) );
    exit;
}

get_header();

$current_user = wp_get_current_user();
$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'profilo';
?>

<main id="main-content" class="site-main page-dashboard">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="user-welcome">
                <h1 class="dashboard-title">
                    Ciao, <?php echo esc_html( $current_user->first_name ?: $current_user->display_name ); ?>!
                </h1>
                <p class="dashboard-subtitle">Benvenuto nella tua area personale</p>
            </div>
            <div class="user-actions">
                <a href="<?php echo wp_logout_url( home_url() ); ?>" class="btn btn-outline">
                    Logout
                </a>
            </div>
        </div>

        <!-- Dashboard Tabs -->
        <div class="dashboard-tabs">
            <nav class="tabs-nav">
                <a href="?tab=profilo" class="tab-link <?php echo $active_tab === 'profilo' ? 'active' : ''; ?>">
                    <span class="icon">👤</span> Profilo
                </a>
                <a href="?tab=annunci" class="tab-link <?php echo $active_tab === 'annunci' ? 'active' : ''; ?>">
                    <span class="icon">📋</span> I miei annunci
                </a>
                <?php if ( current_user_can( 'submit_cucciolata' ) ): ?>
                    <a href="?tab=aggiungi-cucciolata" class="tab-link <?php echo $active_tab === 'aggiungi-cucciolata' ? 'active' : ''; ?>">
                        <span class="icon">➕</span> Nuova cucciolata
                    </a>
                    <a href="?tab=aggiungi-dogsitter" class="tab-link <?php echo $active_tab === 'aggiungi-dogsitter' ? 'active' : ''; ?>">
                        <span class="icon">🐕</span> Offri servizio dogsitter
                    </a>
                <?php endif; ?>
                <?php if ( current_user_can( 'suggest_edits' ) ): ?>
                    <a href="?tab=segnalazioni" class="tab-link <?php echo $active_tab === 'segnalazioni' ? 'active' : ''; ?>">
                        <span class="icon">✏️</span> Le mie segnalazioni
                    </a>
                <?php endif; ?>
                <?php if ( current_user_can( 'moderate_content' ) ): ?>
                    <a href="?tab=moderation" class="tab-link <?php echo $active_tab === 'moderation' ? 'active' : ''; ?>">
                        <span class="icon">⚙️</span> Moderazione
                    </a>
                <?php endif; ?>
            </nav>

            <!-- Tab Content -->
            <div class="tab-content">

                <?php if ( $active_tab === 'profilo' ): ?>
                    <!-- PROFILO TAB -->
                    <div class="tab-pane active" id="profilo">
                        <h2 class="tab-title">Il tuo profilo</h2>

                        <form id="profile-form" class="dashboard-form">
                            <?php wp_nonce_field( 'caniincasa_update_profile', 'profile_nonce' ); ?>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">Nome</label>
                                    <input type="text" id="first_name" name="first_name"
                                           value="<?php echo esc_attr( $current_user->first_name ); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Cognome</label>
                                    <input type="text" id="last_name" name="last_name"
                                           value="<?php echo esc_attr( $current_user->last_name ); ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email"
                                       value="<?php echo esc_attr( $current_user->user_email ); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="tel" id="telefono" name="telefono"
                                       value="<?php echo esc_attr( get_user_meta( $current_user->ID, 'telefono', true ) ); ?>">
                            </div>

                            <div class="form-group">
                                <label for="bio">Biografia</label>
                                <textarea id="bio" name="bio" rows="4"><?php echo esc_textarea( get_user_meta( $current_user->ID, 'description', true ) ); ?></textarea>
                            </div>

                            <h3 class="section-title">Cambia Password</h3>

                            <div class="form-group">
                                <label for="current_password">Password Attuale</label>
                                <input type="password" id="current_password" name="current_password">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="new_password">Nuova Password</label>
                                    <input type="password" id="new_password" name="new_password">
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">Conferma Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password">
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <span class="btn-text">Aggiorna Profilo</span>
                                    <span class="btn-loading" style="display:none;">
                                        <span class="spinner"></span> Salvataggio...
                                    </span>
                                </button>
                            </div>

                            <div class="form-message" id="profile-message" style="display:none;"></div>
                        </form>
                    </div>

                <?php elseif ( $active_tab === 'annunci' ): ?>
                    <!-- ANNUNCI TAB -->
                    <div class="tab-pane active" id="annunci">
                        <h2 class="tab-title">I miei annunci</h2>

                        <?php
                        // Query per annunci dell'utente
                        $user_annunci = new WP_Query( array(
                            'post_type' => 'cucciolate',
                            'author' => $current_user->ID,
                            'posts_per_page' => 20,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ) );

                        if ( $user_annunci->have_posts() ):
                        ?>
                            <div class="annunci-list">
                                <?php while ( $user_annunci->have_posts() ): $user_annunci->the_post(); ?>
                                    <div class="annuncio-card">
                                        <div class="annuncio-header">
                                            <h3 class="annuncio-title"><?php the_title(); ?></h3>
                                            <span class="annuncio-status status-<?php echo get_post_status(); ?>">
                                                <?php
                                                $status_labels = array(
                                                    'publish' => 'Pubblicato',
                                                    'pending' => 'In Revisione',
                                                    'draft' => 'Bozza',
                                                );
                                                echo $status_labels[ get_post_status() ] ?? get_post_status();
                                                ?>
                                            </span>
                                        </div>

                                        <div class="annuncio-meta">
                                            <span class="meta-item">
                                                <span class="icon">📅</span>
                                                Pubblicato il <?php echo get_the_date(); ?>
                                            </span>
                                            <?php
                                            $razza = get_field( 'razza' );
                                            if ( $razza ):
                                            ?>
                                                <span class="meta-item">
                                                    <span class="icon">🐕</span>
                                                    <?php echo esc_html( $razza ); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="annuncio-actions">
                                            <?php if ( get_post_status() === 'publish' ): ?>
                                                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline" target="_blank">
                                                    Visualizza
                                                </a>
                                            <?php endif; ?>
                                            <a href="?tab=modifica-annuncio&id=<?php echo get_the_ID(); ?>" class="btn btn-sm btn-outline">
                                                Modifica
                                            </a>
                                            <button class="btn btn-sm btn-danger delete-annuncio" data-id="<?php echo get_the_ID(); ?>">
                                                Elimina
                                            </button>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <h3>Nessun annuncio</h3>
                                <p>Non hai ancora pubblicato annunci.</p>
                                <?php if ( current_user_can( 'submit_cucciolata' ) ): ?>
                                    <a href="?tab=aggiungi-cucciolata" class="btn btn-primary">
                                        Pubblica la tua prima cucciolata
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>

                <?php elseif ( $active_tab === 'aggiungi-cucciolata' && current_user_can( 'submit_cucciolata' ) ): ?>
                    <!-- AGGIUNGI CUCCIOLATA TAB -->
                    <div class="tab-pane active" id="aggiungi-cucciolata">
                        <h2 class="tab-title">Pubblica una nuova cucciolata</h2>

                        <form id="cucciolata-form" class="dashboard-form">
                            <?php wp_nonce_field( 'caniincasa_submit_cucciolata', 'cucciolata_nonce' ); ?>

                            <div class="form-group">
                                <label for="tipo_cucciolata">Tipo Annuncio *</label>
                                <select id="tipo_cucciolata" name="tipo_cucciolata" required>
                                    <option value="">Seleziona il tipo di annuncio</option>
                                    <?php
                                    $tipi_cucciolata = get_terms( array(
                                        'taxonomy' => 'tipo_cucciolata',
                                        'hide_empty' => false,
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                    ) );

                                    foreach ( $tipi_cucciolata as $tipo ):
                                    ?>
                                        <option value="<?php echo $tipo->term_id; ?>" title="<?php echo esc_attr( $tipo->description ); ?>">
                                            <?php echo esc_html( $tipo->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-help" id="tipo-help"></small>
                            </div>

                            <div class="form-group">
                                <label for="titolo">Titolo Annuncio *</label>
                                <input type="text" id="titolo" name="titolo" required
                                       placeholder="Es: Cuccioli di Labrador Retriever disponibili">
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

                                <div class="form-group">
                                    <label for="data_nascita">Data di Nascita Cuccioli *</label>
                                    <input type="date" id="data_nascita" name="data_nascita" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="numero_maschi">Numero Maschi</label>
                                    <input type="number" id="numero_maschi" name="numero_maschi" min="0" value="0">
                                </div>

                                <div class="form-group">
                                    <label for="numero_femmine">Numero Femmine</label>
                                    <input type="number" id="numero_femmine" name="numero_femmine" min="0" value="0">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="prezzo">Prezzo (€)</label>
                                    <input type="number" id="prezzo" name="prezzo" min="0" step="50"
                                           placeholder="Lascia vuoto se non specificato">
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
                                <label for="descrizione">Descrizione *</label>
                                <textarea id="descrizione" name="descrizione" rows="6" required
                                          placeholder="Descrivi la cucciolata, i genitori, eventuali caratteristiche..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="immagini">Immagini</label>
                                <input type="file" id="immagini" name="immagini[]" multiple accept="image/*">
                                <small class="form-help">Puoi caricare fino a 5 immagini (max 2MB ciascuna)</small>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms" id="terms" required>
                                    <span>Ho letto e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a> per la pubblicazione di annunci</span>
                                </label>
                            </div>

                            <div class="form-message info" style="margin-bottom: 1.5rem;">
                                <strong>Nota:</strong> Il tuo annuncio sarà sottoposto a moderazione prima della pubblicazione.
                                Riceverai una notifica via email quando verrà approvato.
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <span class="btn-text">Invia Annuncio</span>
                                    <span class="btn-loading" style="display:none;">
                                        <span class="spinner"></span> Invio...
                                    </span>
                                </button>
                                <a href="?tab=annunci" class="btn btn-outline">Annulla</a>
                            </div>

                            <div class="form-message" id="cucciolata-message" style="display:none;"></div>
                        </form>
                    </div>

                <?php elseif ( $active_tab === 'aggiungi-dogsitter' && current_user_can( 'submit_cucciolata' ) ): ?>
                    <!-- AGGIUNGI DOGSITTER TAB -->
                    <div class="tab-pane active" id="aggiungi-dogsitter">
                        <h2 class="tab-title">Offri il tuo servizio di dogsitter</h2>
                        <p class="tab-description">Compila il form per proporti come dogsitter. Il tuo annuncio sarà visibile dopo la moderazione.</p>

                        <form id="dogsitter-form" class="dashboard-form">
                            <?php wp_nonce_field( 'caniincasa_submit_dogsitter', 'dogsitter_nonce' ); ?>

                            <div class="form-group">
                                <label for="titolo_dogsitter">Titolo Annuncio *</label>
                                <input type="text" id="titolo_dogsitter" name="titolo" required
                                       placeholder="Es: Dogsitter esperto con esperienza pluriennale">
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
                                    <label for="comune_dogsitter">Comune *</label>
                                    <input type="text" id="comune_dogsitter" name="comune" required
                                           placeholder="Es: Milano">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="esperienza">Anni di Esperienza *</label>
                                    <select id="esperienza" name="esperienza" required>
                                        <option value="">Seleziona</option>
                                        <option value="meno-1">Meno di 1 anno</option>
                                        <option value="1-3">1-3 anni</option>
                                        <option value="3-5">3-5 anni</option>
                                        <option value="5-10">5-10 anni</option>
                                        <option value="oltre-10">Oltre 10 anni</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tariffe">Tariffa Oraria (€) *</label>
                                    <input type="number" id="tariffe" name="tariffe" min="5" max="100" step="1" required
                                           placeholder="Es: 15">
                                    <small class="form-help">Tariffa oraria indicativa in euro</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Disponibilità *</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="disponibilita[]" value="mattina">
                                        <span>Mattina (08:00-13:00)</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="disponibilita[]" value="pomeriggio">
                                        <span>Pomeriggio (13:00-19:00)</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="disponibilita[]" value="sera">
                                        <span>Sera (19:00-23:00)</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="disponibilita[]" value="weekend">
                                        <span>Weekend</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="disponibilita[]" value="notturno">
                                        <span>Notturno</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Servizi Offerti *</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="servizi[]" value="passeggiate">
                                        <span>Passeggiate</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="servizi[]" value="pensione">
                                        <span>Pensione a casa mia</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="servizi[]" value="domicilio">
                                        <span>Assistenza a domicilio</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="servizi[]" value="toelettatura">
                                        <span>Toelettatura base</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="servizi[]" value="trasporto">
                                        <span>Trasporto</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="servizi[]" value="addestramento">
                                        <span>Addestramento base</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Taglie Accettate *</label>
                                <div class="checkbox-group">
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="taglie[]" value="piccola">
                                        <span>Piccola (fino a 10kg)</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="taglie[]" value="media">
                                        <span>Media (10-25kg)</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="taglie[]" value="grande">
                                        <span>Grande (25-45kg)</span>
                                    </label>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="taglie[]" value="gigante">
                                        <span>Gigante (oltre 45kg)</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descrizione_dogsitter">Presentazione e Descrizione Servizi *</label>
                                <textarea id="descrizione_dogsitter" name="descrizione" rows="8" required
                                          placeholder="Descrivi la tua esperienza, le tue competenze, eventuali certificazioni, disponibilità di spazi (giardino, ecc.), e cosa ti rende un buon dogsitter..."></textarea>
                                <small class="form-help">Minimo 100 caratteri</small>
                            </div>

                            <div class="form-group">
                                <label for="immagini_dogsitter">Foto Profilo e Immagini</label>
                                <input type="file" id="immagini_dogsitter" name="immagini[]" multiple accept="image/*">
                                <small class="form-help">Prima foto = foto profilo. Puoi caricare fino a 3 immagini (max 2MB ciascuna)</small>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms_dogsitter" id="terms_dogsitter" required>
                                    <span>Ho letto e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a> per la pubblicazione di annunci</span>
                                </label>
                            </div>

                            <div class="form-message info" style="margin-bottom: 1.5rem;">
                                <strong>Nota:</strong> Il tuo annuncio sarà sottoposto a moderazione prima della pubblicazione.
                                Riceverai una notifica via email quando verrà approvato.
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <span class="btn-text">Invia Annuncio</span>
                                    <span class="btn-loading" style="display:none;">
                                        <span class="spinner"></span> Invio...
                                    </span>
                                </button>
                                <a href="?tab=annunci" class="btn btn-outline">Annulla</a>
                            </div>

                            <div class="form-message" id="dogsitter-message" style="display:none;"></div>
                        </form>
                    </div>

                <?php elseif ( $active_tab === 'segnalazioni' && current_user_can( 'suggest_edits' ) ): ?>
                    <!-- SEGNALAZIONI TAB -->
                    <div class="tab-pane active" id="segnalazioni">
                        <h2 class="tab-title">Le mie segnalazioni</h2>

                        <div class="segnalazioni-intro">
                            <p>Hai notato informazioni non corrette o mancanti? Segnalale qui e aiutaci a migliorare il sito!</p>
                            <button class="btn btn-primary" id="btn-nuova-segnalazione">
                                ➕ Nuova Segnalazione
                            </button>
                        </div>

                        <?php
                        // Query per segnalazioni dell'utente
                        $user_segnalazioni = get_comments( array(
                            'user_id' => $current_user->ID,
                            'type' => 'segnalazione',
                            'status' => 'all',
                            'number' => 20,
                        ) );

                        if ( $user_segnalazioni ):
                        ?>
                            <div class="segnalazioni-list">
                                <?php foreach ( $user_segnalazioni as $segnalazione ): ?>
                                    <div class="segnalazione-card">
                                        <div class="segnalazione-header">
                                            <span class="segnalazione-type">
                                                <?php echo esc_html( get_comment_meta( $segnalazione->comment_ID, 'tipo_segnalazione', true ) ); ?>
                                            </span>
                                            <span class="segnalazione-status status-<?php echo $segnalazione->comment_approved; ?>">
                                                <?php
                                                $status = $segnalazione->comment_approved;
                                                if ( $status === '1' ) echo 'Approvata';
                                                elseif ( $status === '0' ) echo 'In Revisione';
                                                else echo 'In Attesa';
                                                ?>
                                            </span>
                                        </div>
                                        <p class="segnalazione-content"><?php echo esc_html( $segnalazione->comment_content ); ?></p>
                                        <div class="segnalazione-meta">
                                            <span class="meta-item">
                                                <span class="icon">📅</span>
                                                <?php echo get_comment_date( 'd/m/Y', $segnalazione->comment_ID ); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <div class="empty-icon">📝</div>
                                <h3>Nessuna segnalazione</h3>
                                <p>Non hai ancora inviato segnalazioni.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php elseif ( $active_tab === 'moderation' && current_user_can( 'moderate_content' ) ): ?>
                    <!-- MODERAZIONE TAB -->
                    <div class="tab-pane active" id="moderation">
                        <h2 class="tab-title">Pannello di Moderazione</h2>

                        <?php
                        // Query per annunci pending
                        $pending_annunci = new WP_Query( array(
                            'post_type' => 'cucciolate',
                            'post_status' => 'pending',
                            'posts_per_page' => 20,
                            'orderby' => 'date',
                            'order' => 'DESC',
                        ) );

                        if ( $pending_annunci->have_posts() ):
                        ?>
                            <h3 class="section-title">Annunci in attesa di approvazione</h3>
                            <div class="moderation-list">
                                <?php while ( $pending_annunci->have_posts() ): $pending_annunci->the_post(); ?>
                                    <div class="moderation-card">
                                        <div class="moderation-header">
                                            <h4><?php the_title(); ?></h4>
                                            <span class="author-info">
                                                Da: <?php the_author(); ?> - <?php echo get_the_date(); ?>
                                            </span>
                                        </div>

                                        <div class="moderation-content">
                                            <?php the_excerpt(); ?>
                                        </div>

                                        <div class="moderation-actions">
                                            <button class="btn btn-success approve-post" data-id="<?php echo get_the_ID(); ?>">
                                                ✓ Approva
                                            </button>
                                            <button class="btn btn-danger reject-post" data-id="<?php echo get_the_ID(); ?>">
                                                ✗ Rifiuta
                                            </button>
                                            <a href="<?php echo get_edit_post_link(); ?>" class="btn btn-outline">
                                                Modifica
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <div class="empty-icon">✅</div>
                                <h3>Tutto approvato!</h3>
                                <p>Non ci sono annunci in attesa di moderazione.</p>
                            </div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</main>

<?php get_footer(); ?>
