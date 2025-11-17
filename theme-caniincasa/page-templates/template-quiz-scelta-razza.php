<?php
/**
 * Template Name: Quiz - Ti Aiutiamo a Scegliere
 * Template Post Type: page
 *
 * Quiz interattivo per aiutare gli utenti a scegliere la razza giusta
 *
 * @package CaninCasa
 * @since 2.0.0
 */

get_header();
?>

<main id="main-content" class="site-main page-quiz-razza">

    <div class="container">

        <div class="quiz-wrapper">

            <!-- Quiz Header -->
            <div class="quiz-header">
                <h1 class="quiz-title">🐕 Ti aiutiamo a scegliere!</h1>
                <p class="quiz-subtitle">Rispondi a 9 semplici domande e ti suggeriremo le razze più adatte a te</p>
            </div>

            <!-- Progress Bar -->
            <div class="quiz-progress">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 0%"></div>
                </div>
                <p class="progress-text">Domanda <span class="current">1</span> di <span class="total">9</span></p>
            </div>

            <!-- Quiz Form -->
            <form id="quiz-form" class="quiz-form">

                <!-- Domanda 1: Esperienza -->
                <div class="quiz-step active" data-step="1">
                    <h2 class="question-title">1. È la tua prima volta con un cane?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="esperienza" value="si" required>
                            <div class="answer-content">
                                <span class="answer-icon">🆕</span>
                                <span class="answer-text">Sì, è la prima volta</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="esperienza" value="poca">
                            <div class="answer-content">
                                <span class="answer-icon">📚</span>
                                <span class="answer-text">Ho poca esperienza</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="esperienza" value="no">
                            <div class="answer-content">
                                <span class="answer-icon">🎓</span>
                                <span class="answer-text">No, ho esperienza</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 2: Spazio Abitativo -->
                <div class="quiz-step" data-step="2">
                    <h2 class="question-title">2. Dove vivi?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="spazio" value="appartamento-piccolo" required>
                            <div class="answer-content">
                                <span class="answer-icon">🏢</span>
                                <span class="answer-text">Appartamento piccolo</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="spazio" value="appartamento-grande">
                            <div class="answer-content">
                                <span class="answer-icon">🏠</span>
                                <span class="answer-text">Appartamento grande</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="spazio" value="casa-giardino">
                            <div class="answer-content">
                                <span class="answer-icon">🏡</span>
                                <span class="answer-text">Casa con giardino</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="spazio" value="campagna">
                            <div class="answer-content">
                                <span class="answer-icon">🌳</span>
                                <span class="answer-text">Campagna/Spazio aperto</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 3: Bambini -->
                <div class="quiz-step" data-step="3">
                    <h2 class="question-title">3. Hai bambini piccoli in casa?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="bambini" value="si" required>
                            <div class="answer-content">
                                <span class="answer-icon">👶</span>
                                <span class="answer-text">Sì, bambini piccoli</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="bambini" value="adolescenti">
                            <div class="answer-content">
                                <span class="answer-icon">👦</span>
                                <span class="answer-text">Sì, adolescenti</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="bambini" value="no">
                            <div class="answer-content">
                                <span class="answer-icon">👨</span>
                                <span class="answer-text">No</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 4: Tempo per Esercizio -->
                <div class="quiz-step" data-step="4">
                    <h2 class="question-title">4. Quanto tempo puoi dedicare all'esercizio fisico del cane?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="esercizio" value="poco" required>
                            <div class="answer-content">
                                <span class="answer-icon">🚶</span>
                                <span class="answer-text">Poco (30 min/giorno)</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="esercizio" value="medio">
                            <div class="answer-content">
                                <span class="answer-icon">🏃</span>
                                <span class="answer-text">Medio (1-2 ore/giorno)</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="esercizio" value="molto">
                            <div class="answer-content">
                                <span class="answer-icon">🏋️</span>
                                <span class="answer-text">Molto (2+ ore/giorno)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 5: Addestramento -->
                <div class="quiz-step" data-step="5">
                    <h2 class="question-title">5. Hai esperienza con l'addestramento di cani?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="addestramento" value="no" required>
                            <div class="answer-content">
                                <span class="answer-icon">❌</span>
                                <span class="answer-text">Nessuna esperienza</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="addestramento" value="base">
                            <div class="answer-content">
                                <span class="answer-icon">📖</span>
                                <span class="answer-text">Base</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="addestramento" value="esperto">
                            <div class="answer-content">
                                <span class="answer-icon">🎖️</span>
                                <span class="answer-text">Esperto</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 6: Pelo (Taglia question removed - field doesn't exist in ACF) -->
                <div class="quiz-step" data-step="6">
                    <h2 class="question-title">6. Hai allergie o preferenze sul tipo di pelo?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="pelo" value="corto" required>
                            <div class="answer-content">
                                <span class="answer-icon">✂️</span>
                                <span class="answer-text">Corto (facile manutenzione)</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="pelo" value="lungo">
                            <div class="answer-content">
                                <span class="answer-icon">💇</span>
                                <span class="answer-text">Lungo (più cure)</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="pelo" value="allergie">
                            <div class="answer-content">
                                <span class="answer-icon">🤧</span>
                                <span class="answer-text">Ho allergie</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="pelo" value="qualsiasi">
                            <div class="answer-content">
                                <span class="answer-icon">👍</span>
                                <span class="answer-text">Qualsiasi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 7: Carattere -->
                <div class="quiz-step" data-step="7">
                    <h2 class="question-title">7. Che carattere preferisci?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="carattere" value="calmo" required>
                            <div class="answer-content">
                                <span class="answer-icon">😌</span>
                                <span class="answer-text">Calmo e tranquillo</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="carattere" value="vivace">
                            <div class="answer-content">
                                <span class="answer-icon">⚡</span>
                                <span class="answer-text">Vivace ed energico</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="carattere" value="guardiano">
                            <div class="answer-content">
                                <span class="answer-icon">🛡️</span>
                                <span class="answer-text">Guardiano e protettivo</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="carattere" value="affettuoso">
                            <div class="answer-content">
                                <span class="answer-icon">❤️</span>
                                <span class="answer-text">Affettuoso e socievole</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 8: Latrato -->
                <div class="quiz-step" data-step="8">
                    <h2 class="question-title">8. Quanto puoi tollerare l'abbaio?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="latrato" value="poco" required>
                            <div class="answer-content">
                                <span class="answer-icon">🔇</span>
                                <span class="answer-text">Poco (silenzioso)</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="latrato" value="medio">
                            <div class="answer-content">
                                <span class="answer-icon">🔉</span>
                                <span class="answer-text">Medio</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="latrato" value="qualsiasi">
                            <div class="answer-content">
                                <span class="answer-icon">🔊</span>
                                <span class="answer-text">Qualsiasi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Domanda 9: Budget -->
                <div class="quiz-step" data-step="9">
                    <h2 class="question-title">9. Quanto puoi investire in spese veterinarie e cure?</h2>
                    <div class="answers-grid">
                        <label class="answer-card">
                            <input type="radio" name="budget" value="basso" required>
                            <div class="answer-content">
                                <span class="answer-icon">💰</span>
                                <span class="answer-text">Budget limitato</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="budget" value="medio">
                            <div class="answer-content">
                                <span class="answer-icon">💵</span>
                                <span class="answer-text">Budget medio</span>
                            </div>
                        </label>
                        <label class="answer-card">
                            <input type="radio" name="budget" value="alto">
                            <div class="answer-content">
                                <span class="answer-icon">💎</span>
                                <span class="answer-text">Budget ampio</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="quiz-navigation">
                    <button type="button" class="btn btn-outline btn-prev" style="display: none;">
                        ← Indietro
                    </button>
                    <button type="button" class="btn btn-primary btn-next">
                        Avanti →
                    </button>
                    <button type="submit" class="btn btn-primary btn-submit" style="display: none;">
                        🎯 Scopri le razze per te!
                    </button>
                </div>

            </form>

            <!-- Results (hidden initially) -->
            <div id="quiz-results" class="quiz-results" style="display: none;">

                <div class="results-header">
                    <h2 class="results-title">🎉 Ecco le razze più adatte a te!</h2>
                    <p class="results-subtitle">In base alle tue risposte, abbiamo calcolato il match perfetto</p>
                </div>

                <div id="results-content" class="results-content">
                    <!-- Results will be inserted here via JavaScript -->
                </div>

                <?php if ( is_user_logged_in() ) : ?>
                    <div class="quiz-export-actions">
                        <p class="export-intro">Salva i tuoi risultati:</p>
                        <div class="export-buttons">
                            <button type="button" class="btn btn-secondary" id="email-results-btn">
                                📧 Invia via Email
                            </button>
                            <button type="button" class="btn btn-secondary" id="download-pdf-btn">
                                📄 Scarica PDF
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="quiz-actions">
                    <button type="button" class="btn btn-primary" id="restart-quiz">
                        🔄 Rifai il quiz
                    </button>
                    <a href="<?php echo home_url( '/razze/' ); ?>" class="btn btn-outline">
                        📚 Esplora tutte le razze
                    </a>
                </div>

            </div>

        </div>

    </div>

</main>

<?php get_footer(); ?>
