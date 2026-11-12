<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package cshero
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
        <div class="st-comments-wrap clearfix">
            <h4 class="comments-title title-after">
                <span><?php comments_number(__('Comments','wp-libra'),__('Comments 1','wp-libra'),__('Comments %','wp-libra')); ?></span>
            </h4>
            <ol class="comment-list">
				<?php wp_list_comments( 'type=comment&callback=wp_libra_cms_comment' ); ?>
			</ol>
			<?php wp_libra_comment_nav(); ?>
        </div>
	<?php endif; // have_comments() ?>

	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name__mail' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$args = array(
			'id_form'           => 'commentform',
			'id_submit'         => 'submit',
			'title_reply'       => '<span>' . esc_html__( 'Leave A Comment','wp-libra') . '</span>',
			'title_reply_to'    => esc_html__( 'Leave A Reply To ','wp-libra') . '%s',
			'cancel_reply_link' => esc_html__( 'Cancel Reply','wp-libra'),
			'label_submit'      => esc_html__( 'SEND MESSAGE','wp-libra'),
			'comment_notes_before' => '',
			'fields' => apply_filters( 'comment_form_default_fields', array(

					'author' =>
					'<div class="comment-form-author pull-left col-xs-12 col-sm-6 col-md-6 col-lg-6">'.
					'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'"' . $aria_req . ' placeholder="'.esc_html__('Your name *', 'wp-libra').'"/></div>',

					'email' =>
					'<div class="comment-form-email pull-left col-xs-12 col-sm-6 col-md-6 col-lg-6">'.
					'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'"' . $aria_req . ' placeholder="'.esc_html__('Your email *', 'wp-libra').'"/></div>',

					'website' =>
					'<div class="comment-form-website pull-left col-xs-12 col-sm-6 col-md-6 col-lg-6">'.
					'<input id="website" name="website" type="text" value=""' . $aria_req . ' placeholder="'.esc_html__('Website (optional)', 'wp-libra').'"/></div>',
			)
			),
			'comment_field' =>  '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.esc_html__('Your comment *', 'wp-libra').'">' .
			'</textarea></p>',
	);
	comment_form($args);
	?>

</div><!-- #comments -->
