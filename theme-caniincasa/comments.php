<?php
/**
 * Comments Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            printf(
                esc_html( _n( '%d commento', '%d commenti', $comments_number, 'caniincasa' ) ),
                number_format_i18n( $comments_number )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 50,
                'callback'    => 'caniincasa_custom_comment',
            ) );
            ?>
        </ol>

        <?php
        the_comments_pagination( array(
            'prev_text' => '<span class="screen-reader-text">' . __( 'Precedente', 'caniincasa' ) . '</span>',
            'next_text' => '<span class="screen-reader-text">' . __( 'Successivo', 'caniincasa' ) . '</span>',
        ) );
        ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments"><?php esc_html_e( 'I commenti sono chiusi.', 'caniincasa' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
        'title_reply_after'  => '</h2>',
        'class_submit'       => 'btn btn-primary',
        'label_submit'       => __( 'Invia Commento', 'caniincasa' ),
        'comment_field'      => '<p class="comment-form-comment"><label for="comment">' . __( 'Commento', 'caniincasa' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" class="form-control" rows="6" required></textarea></p>',
        'fields'             => array(
            'author' => '<p class="comment-form-author"><label for="author">' . __( 'Nome', 'caniincasa' ) . ' <span class="required">*</span></label><input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" required /></p>',
            'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'caniincasa' ) . ' <span class="required">*</span></label><input id="email" name="email" type="email" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) . '" required /></p>',
            'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Sito web', 'caniincasa' ) . '</label><input id="url" name="url" type="url" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></p>',
        ),
    ) );
    ?>

</div>
