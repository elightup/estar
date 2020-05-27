<?php
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
			$estar_comment_count = get_comments_number();
			echo esc_html( sprintf(
				// Translators: 1: comment count number.
				_n( '%1$s comment', '%1$s comments', $estar_comment_count, 'estar' ),
				number_format_i18n( $estar_comment_count )
			) );
			?>
		</h3>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol>
		<?php the_comments_navigation(); ?>
		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'estar' ); ?></p>
		<?php endif; ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</div>
