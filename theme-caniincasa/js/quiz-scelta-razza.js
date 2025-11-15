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
    const totalSteps = 10;
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

            // 1. Esperienza (peso: 15)
            if (answers.esperienza === 'si') {
                if (breed.adatto_principianti === 'si') score += 15;
                else if (breed.adatto_principianti === 'medio') score += 8;
                else score += 0;
            } else if (answers.esperienza === 'poca') {
                if (breed.adatto_principianti === 'si') score += 12;
                else if (breed.adatto_principianti === 'medio') score += 15;
                else score += 5;
            } else {
                score += 15; // Esperti possono gestire qualsiasi razza
            }

            // 2. Spazio (peso: 15)
            if (answers.spazio === 'appartamento-piccolo') {
                if (breed.adatto_appartamento === 'si') score += 15;
                else if (breed.adatto_appartamento === 'medio') score += 8;
                else score += 0;
            } else if (answers.spazio === 'appartamento-grande') {
                if (breed.adatto_appartamento === 'si' || breed.adatto_appartamento === 'medio') score += 15;
                else score += 8;
            } else {
                score += 15; // Casa/campagna ok per tutte
            }

            // 3. Bambini (peso: 15)
            if (answers.bambini === 'si') {
                if (breed.adatto_bambini === 'si') score += 15;
                else if (breed.adatto_bambini === 'medio') score += 8;
                else score += 0;
            } else if (answers.bambini === 'adolescenti') {
                if (breed.adatto_bambini === 'si' || breed.adatto_bambini === 'medio') score += 15;
                else score += 10;
            } else {
                score += 15;
            }

            // 4. Esercizio (peso: 10)
            if (answers.esercizio === 'poco') {
                if (breed.livello_energia === 'basso') score += 10;
                else if (breed.livello_energia === 'medio') score += 5;
                else score += 0;
            } else if (answers.esercizio === 'medio') {
                if (breed.livello_energia === 'medio') score += 10;
                else score += 7;
            } else {
                if (breed.livello_energia === 'alto') score += 10;
                else score += 5;
            }

            // 5. Addestramento (peso: 10)
            if (answers.addestramento === 'no') {
                if (breed.facilita_addestramento === 'facile') score += 10;
                else if (breed.facilita_addestramento === 'media') score += 5;
                else score += 0;
            } else if (answers.addestramento === 'base') {
                if (breed.facilita_addestramento !== 'difficile') score += 10;
                else score += 5;
            } else {
                score += 10;
            }

            // 6. Taglia (peso: 10)
            if (answers.taglia !== 'qualsiasi') {
                if (breed.taglia === answers.taglia) score += 10;
                else score += 0;
            } else {
                score += 10;
            }

            // 7. Pelo (peso: 10)
            if (answers.pelo === 'allergie') {
                if (breed.ipoallergenico === 'si') score += 10;
                else score += 0;
            } else if (answers.pelo === 'corto') {
                if (breed.tipo_pelo === 'corto') score += 10;
                else if (breed.tipo_pelo === 'medio') score += 7;
                else score += 3;
            } else if (answers.pelo === 'lungo') {
                if (breed.tipo_pelo === 'lungo') score += 10;
                else score += 7;
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
            if (answers.latrato === 'poco') {
                if (breed.tendenza_abbaio === 'bassa') score += 5;
                else if (breed.tendenza_abbaio === 'media') score += 3;
                else score += 0;
            } else if (answers.latrato === 'medio') {
                if (breed.tendenza_abbaio !== 'alta') score += 5;
                else score += 3;
            } else {
                score += 5;
            }

            // 10. Budget (peso: 0 - informativo)
            // Not scored, just informative

            // Calculate percentage
            const percentage = Math.round((score / maxScore) * 100);

            scored.push({
                breed: breed,
                score: score,
                percentage: percentage
            });
        });

        // Sort by score descending
        scored.sort((a, b) => b.score - a.score);

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

            if (breed.caratteristiche) {
                html += '<ul class="result-traits">';
                breed.caratteristiche.slice(0, 3).forEach(function(trait) {
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
     * Initialize on document ready
     */
    $(document).ready(function() {
        if ($('#quiz-form').length) {
            initQuiz();
        }
    });

})(jQuery);
