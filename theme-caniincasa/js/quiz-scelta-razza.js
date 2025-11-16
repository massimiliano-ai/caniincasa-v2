/**
 * Quiz Scelta Razza JavaScript
 * Handles quiz logic and scoring algorithm
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    let currentStep = 1;
    const totalSteps = 9; // Reduced from 10 - removed taglia question
    const answers = {};

    /**
     * Initialize Quiz
     */
    function initQuiz() {
        updateProgress();
        bindEvents();
    }

    /**
     * Bind Events
     */
    function bindEvents() {
        // Next button
        $('.btn-next').on('click', function(e) {
            e.preventDefault();
            const $currentStep = $('.quiz-step[data-step="' + currentStep + '"]');
            const $radio = $currentStep.find('input[type="radio"]:checked');

            if ($radio.length === 0) {
                alert('Per favore seleziona una risposta');
                return;
            }

            // Save answer
            const name = $radio.attr('name');
            const value = $radio.val();
            answers[name] = value;

            // Move to next step
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
                updateProgress();
            }
        });

        // Prev button
        $('.btn-prev').on('click', function(e) {
            e.preventDefault();

            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                updateProgress();
            }
        });

        // Submit button
        $('.btn-submit').on('click', function(e) {
            e.preventDefault();

            const $currentStep = $('.quiz-step[data-step="' + currentStep + '"]');
            const $radio = $currentStep.find('input[type="radio"]:checked');

            if ($radio.length === 0) {
                alert('Per favore seleziona una risposta');
                return;
            }

            // Save last answer
            const name = $radio.attr('name');
            const value = $radio.val();
            answers[name] = value;

            // Calculate results
            calculateResults();
        });

        // Restart quiz
        $('#restart-quiz').on('click', function() {
            currentStep = 1;
            Object.keys(answers).forEach(key => delete answers[key]);
            $('input[type="radio"]').prop('checked', false);
            $('#quiz-results').hide();
            $('#quiz-form').show();
            showStep(1);
            updateProgress();
        });

        // Answer card selection visual feedback
        $('.answer-card input').on('change', function() {
            $(this).closest('.answers-grid').find('.answer-card').removeClass('selected');
            $(this).closest('.answer-card').addClass('selected');
        });
    }

    /**
     * Show Step
     */
    function showStep(step) {
        $('.quiz-step').removeClass('active').hide();
        $('.quiz-step[data-step="' + step + '"]').addClass('active').fadeIn(300);

        // Update buttons
        if (step === 1) {
            $('.btn-prev').hide();
        } else {
            $('.btn-prev').show();
        }

        if (step === totalSteps) {
            $('.btn-next').hide();
            $('.btn-submit').show();
        } else {
            $('.btn-next').show();
            $('.btn-submit').hide();
        }
    }

    /**
     * Update Progress
     */
    function updateProgress() {
        const percent = (currentStep / totalSteps) * 100;
        $('.progress-fill').css('width', percent + '%');
        $('.progress-text .current').text(currentStep);
    }

    /**
     * Calculate Results - SCORING ALGORITHM
     */
    function calculateResults() {
        // Show loading
        $('#quiz-form').hide();
        $('#quiz-results').show();
        $('#results-content').html('<p class="loading">⏳ Calcolando i risultati...</p>');

        // AJAX request to get breeds data
        $.ajax({
            url: canincasaAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_breeds_for_quiz',
                nonce: canincasaAjax.nonce,
                answers: answers
            },
            success: function(response) {
                if (response.success) {
                    const breeds = response.data.breeds;
                    const scoredBreeds = scoreBreeds(breeds);
                    displayResults(scoredBreeds);
                } else {
                    $('#results-content').html('<p class="error">Si è verificato un errore. Riprova.</p>');
                }
            },
            error: function() {
                $('#results-content').html('<p class="error">Si è verificato un errore. Riprova.</p>');
            }
        });
    }

    /**
     * Score Breeds Algorithm
     * Returns top breeds based on user answers
     */
    function scoreBreeds(breeds) {
        const scored = [];

        breeds.forEach(function(breed) {
            let score = 0;
            let maxScore = 100;

            // Normalize breed data for comparison
            const normalize = (val) => val ? String(val).toLowerCase() : '';

            // 1. Esperienza (peso: 15)
            // livello_esperienza: 1-5 scale (1=beginner friendly, 5=requires expert)
            if (answers.esperienza === 'si') {
                // First-time owner needs beginner-friendly breeds
                if (breed.livello_esperienza <= 2) score += 15;
                else if (breed.livello_esperienza <= 3) score += 8;
                else score += 2; // Give some points anyway
            } else if (answers.esperienza === 'poca') {
                // Some experience - can handle medium difficulty
                if (breed.livello_esperienza <= 2) score += 12;
                else if (breed.livello_esperienza <= 3) score += 15;
                else score += 7;
            } else {
                score += 15; // Esperti possono gestire qualsiasi razza
            }

            // 2. Spazio (peso: 15)
            // adattabilita_appartamento: 1-5 scale (1=needs outdoor space, 5=perfect for apartment)
            if (answers.spazio === 'appartamento-piccolo') {
                if (breed.adattabilita_appartamento >= 4) score += 15;
                else if (breed.adattabilita_appartamento >= 3) score += 8;
                else score += 0;
            } else if (answers.spazio === 'appartamento-grande') {
                if (breed.adattabilita_appartamento >= 3) score += 15;
                else score += 8;
            } else {
                score += 15; // Casa/campagna ok per tutte
            }

            // 3. Bambini (peso: 15)
            // compatibilita_bambini: 1-5 scale (1=not suitable, 5=excellent with kids)
            if (answers.bambini === 'si') {
                if (breed.compatibilita_bambini >= 4) score += 15;
                else if (breed.compatibilita_bambini >= 3) score += 8;
                else score += 0;
            } else if (answers.bambini === 'adolescenti') {
                if (breed.compatibilita_bambini >= 3) score += 15;
                else score += 10;
            } else {
                score += 15;
            }

            // 4. Esercizio (peso: 10)
            // livello_energia: 1-5 scale (1=very low, 5=very high)
            if (answers.esercizio === 'poco') {
                if (breed.livello_energia <= 2) score += 10;
                else if (breed.livello_energia <= 3) score += 5;
                else score += 0;
            } else if (answers.esercizio === 'medio') {
                if (breed.livello_energia >= 2 && breed.livello_energia <= 4) score += 10;
                else score += 7;
            } else {
                if (breed.livello_energia >= 4) score += 10;
                else score += 5;
            }

            // 5. Addestramento (peso: 10)
            // facilita_addestramento: 1-5 scale (1=difficult, 5=very easy)
            if (answers.addestramento === 'no') {
                if (breed.facilita_addestramento >= 4) score += 10;
                else if (breed.facilita_addestramento >= 3) score += 5;
                else score += 0;
            } else if (answers.addestramento === 'base') {
                if (breed.facilita_addestramento >= 3) score += 10;
                else score += 5;
            } else {
                score += 10;
            }

            // 6. Taglia - REMOVED (field doesn't exist in ACF)
            // Skipping this criterion as 'taglia' field is not available

            // 7. Pelo (peso: 10)
            // perdita_pelo: 1-5 scale (1=very low shedding, 5=heavy shedding)
            if (answers.pelo === 'allergie') {
                // Low shedding better for allergies
                if (breed.perdita_pelo <= 2) score += 10;
                else if (breed.perdita_pelo <= 3) score += 5;
                else score += 0;
            } else if (answers.pelo === 'corto') {
                // Prefer low-medium shedding for short coat preference
                if (breed.perdita_pelo <= 3) score += 10;
                else score += 5;
            } else if (answers.pelo === 'lungo') {
                // Any shedding level OK for long coat preference
                score += 10;
            } else {
                score += 10;
            }

            // 8. Carattere (peso: 10)
            if (answers.carattere === 'calmo' && breed.temperamento && breed.temperamento.includes('calmo')) {
                score += 10;
            } else if (answers.carattere === 'vivace' && breed.temperamento && breed.temperamento.includes('vivace')) {
                score += 10;
            } else if (answers.carattere === 'guardiano' && breed.temperamento && breed.temperamento.includes('guardiano')) {
                score += 10;
            } else if (answers.carattere === 'affettuoso' && breed.temperamento && breed.temperamento.includes('affettuoso')) {
                score += 10;
            } else {
                score += 5;
            }

            // 9. Latrato (peso: 5)
            // vocalita: 1-5 scale (1=quiet, 5=very vocal)
            if (answers.latrato === 'poco') {
                if (breed.vocalita <= 2) score += 5;
                else if (breed.vocalita <= 3) score += 3;
                else score += 0;
            } else if (answers.latrato === 'medio') {
                if (breed.vocalita <= 4) score += 5;
                else score += 3;
            } else {
                score += 5;
            }

            // 10. Budget (peso: 0 - informativo)
            // Not scored, just informative

            // Add small random variance (±3 points) to avoid all breeds having same score
            // This helps differentiate breeds when ACF data is sparse
            const variance = (Math.random() * 6) - 3; // Random between -3 and +3
            const finalScore = Math.max(0, Math.min(maxScore, score + variance));

            // Calculate percentage
            const percentage = Math.round((finalScore / maxScore) * 100);

            scored.push({
                breed: breed,
                score: finalScore,
                percentage: percentage
            });
        });

        // Sort by score descending WITH randomization for equal scores
        scored.sort((a, b) => {
            // If scores are equal, randomize order
            if (b.score === a.score) {
                return Math.random() - 0.5;
            }
            return b.score - a.score;
        });

        // Return top 5
        return scored.slice(0, 5);
    }

    /**
     * Display Results
     * ALWAYS includes "Meticcio" option
     */
    function displayResults(scoredBreeds) {
        let html = '<div class="results-grid">';

        // Display top breeds
        scoredBreeds.forEach(function(item, index) {
            const breed = item.breed;
            const percentage = item.percentage;

            let matchClass = 'match-good';
            if (percentage >= 80) matchClass = 'match-excellent';
            else if (percentage >= 60) matchClass = 'match-good';
            else matchClass = 'match-fair';

            html += '<div class="result-card ' + matchClass + '">';
            html += '<div class="result-rank">#' + (index + 1) + '</div>';

            if (breed.image) {
                html += '<div class="result-image">';
                html += '<img src="' + breed.image + '" alt="' + breed.name + '">';
                html += '</div>';
            }

            html += '<div class="result-content">';
            html += '<h3 class="result-name">' + breed.name + '</h3>';
            html += '<div class="result-match">';
            html += '<div class="match-bar">';
            html += '<div class="match-fill" style="width: ' + percentage + '%"></div>';
            html += '</div>';
            html += '<span class="match-percent">' + percentage + '% Match</span>';
            html += '</div>';

            // Display characteristics - filter out null/empty values
            let traits = [];
            if (breed.caratteristiche && Array.isArray(breed.caratteristiche)) {
                traits = breed.caratteristiche.filter(function(t) {
                    return t && t !== null && t !== '' && t !== 'null';
                });
            }

            // Fallback traits based on breed data
            if (traits.length === 0) {
                if (breed.temperamento) traits.push(capitalizeFirst(breed.temperamento));
                if (breed.affettuosita >= 4) traits.push('Molto affettuoso');
                if (breed.livello_energia >= 4) traits.push('Alta energia');
                else if (breed.livello_energia <= 2) traits.push('Bassa energia');
            }

            // Display traits (max 3)
            if (traits.length > 0) {
                html += '<ul class="result-traits">';
                traits.slice(0, 3).forEach(function(trait) {
                    html += '<li>✓ ' + trait + '</li>';
                });
                html += '</ul>';
            }

            html += '<a href="' + breed.link + '" class="btn btn-sm btn-outline">Scopri di più →</a>';
            html += '</div>';
            html += '</div>';
        });

        // ALWAYS add Meticcio card
        html += '<div class="result-card match-excellent meticcio-card">';
        html += '<div class="result-rank">💖</div>';
        html += '<div class="result-content meticcio-content">';
        html += '<h3 class="result-name">🐶 Meticcio</h3>';
        html += '<p class="meticcio-description"><strong>Considera un meticcio!</strong> I cani meticci sono unici, spesso più sani, e stanno aspettando una famiglia nei canili.</p>';
        html += '<ul class="result-traits">';
        html += '<li>✓ Carattere unico e speciale</li>';
        html += '<li>✓ Spesso più robusti e sani</li>';
        html += '<li>✓ Salvi una vita</li>';
        html += '<li>✓ Costi di adozione ridotti</li>';
        html += '</ul>';
        html += '<a href="' + canincasaAjax.homeurl + '/canili/" class="btn btn-primary">🏥 Visita i Canili</a>';
        html += '</div>';
        html += '</div>';

        html += '</div>';

        // Track quiz completion
        if (typeof gtag !== 'undefined') {
            gtag('event', 'quiz_complete', {
                'event_category': 'Quiz',
                'event_label': 'Scelta Razza'
            });
        }

        $('#results-content').html(html);
    }

    /**
     * Helper: Capitalize first letter
     */
    function capitalizeFirst(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    /**
     * Initialize on document ready
     */
    $(document).ready(function() {
        if ($('#quiz-form').length) {
            initQuiz();
        }
    });

})(jQuery);
