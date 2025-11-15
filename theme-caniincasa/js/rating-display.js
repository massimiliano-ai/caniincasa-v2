/**
 * Rating Display and Review Functionality
 *
 * @package CaninCasa
 * @since 1.0.0
 */

(function($) {
    'use strict';

    /**
     * Interactive Star Rating
     */
    class StarRating {
        constructor(element) {
            this.element = $(element);
            this.rating = 0;
            this.readonly = this.element.data('readonly') === true;

            this.init();
        }

        init() {
            this.createStars();

            if (!this.readonly) {
                this.bindEvents();
            }
        }

        createStars() {
            const container = $('<div class="star-rating-interactive"></div>');

            for (let i = 1; i <= 5; i++) {
                const star = $('<span class="star" data-rating="' + i + '">★</span>');
                container.append(star);
            }

            this.element.html(container);
            this.stars = container.find('.star');
        }

        bindEvents() {
            this.stars.on('mouseenter', (e) => this.highlightStars($(e.target).data('rating')));
            this.stars.on('click', (e) => this.setRating($(e.target).data('rating')));
            this.element.on('mouseleave', () => this.highlightStars(this.rating));
        }

        highlightStars(rating) {
            this.stars.each(function(index) {
                if (index < rating) {
                    $(this).addClass('filled');
                } else {
                    $(this).removeClass('filled');
                }
            });
        }

        setRating(rating) {
            this.rating = rating;
            this.highlightStars(rating);
            this.element.trigger('ratingChange', [rating]);
        }

        getRating() {
            return this.rating;
        }
    }

    /**
     * Review Form Handler
     */
    class ReviewForm {
        constructor(formSelector) {
            this.form = $(formSelector);
            this.starRating = null;

            this.init();
        }

        init() {
            if (!this.form.length) return;

            // Initialize star rating
            const ratingElement = this.form.find('.rating-input');
            if (ratingElement.length) {
                this.starRating = new StarRating(ratingElement[0]);
            }

            // Bind form submit
            this.form.on('submit', (e) => this.handleSubmit(e));
        }

        handleSubmit(e) {
            e.preventDefault();

            const rating = this.starRating ? this.starRating.getRating() : 0;

            if (rating === 0) {
                this.showError('Per favore seleziona una valutazione.');
                return;
            }

            const formData = {
                action: 'submit_review',
                nonce: canincasaAjax.nonce,
                post_id: this.form.data('post-id'),
                rating: rating,
                comment: this.form.find('textarea[name="review_comment"]').val()
            };

            this.showLoading();

            $.ajax({
                url: canincasaAjax.ajaxurl,
                type: 'POST',
                data: formData,
                success: (response) => this.handleSuccess(response),
                error: (xhr, status, error) => this.handleError(error),
                complete: () => this.hideLoading()
            });
        }

        handleSuccess(response) {
            if (response.success) {
                this.showSuccess(response.data.message);
                this.form[0].reset();
                if (this.starRating) {
                    this.starRating.setRating(0);
                }
            } else {
                this.showError(response.data.message);
            }
        }

        handleError(message) {
            this.showError('Errore durante l\'invio della recensione.');
            console.error(message);
        }

        showLoading() {
            this.form.find('button[type="submit"]').prop('disabled', true).text('Invio in corso...');
        }

        hideLoading() {
            this.form.find('button[type="submit"]').prop('disabled', false).text('Invia Recensione');
        }

        showSuccess(message) {
            this.showMessage(message, 'success');
        }

        showError(message) {
            this.showMessage(message, 'error');
        }

        showMessage(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            const alert = $('<div class="alert ' + alertClass + '">' + message + '</div>');

            this.form.find('.alert').remove();
            this.form.prepend(alert);

            setTimeout(() => {
                alert.fadeOut(() => alert.remove());
            }, 5000);
        }
    }

    /**
     * Initialize on DOM Ready
     */
    $(document).ready(function() {
        // Initialize readonly star ratings
        $('.star-rating-display').each(function() {
            $(this).data('readonly', true);
            new StarRating(this);
        });

        // Initialize review form
        if ($('#review-form').length) {
            new ReviewForm('#review-form');
        }
    });

})(jQuery);
