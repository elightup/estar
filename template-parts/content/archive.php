<article <?php post_class() ?>>
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<div class="entry-summary">
		<?php
		if ( 'content' === Estar\Settings::get( 'archive_content' ) ) {
			the_content();
		} else {
			the_excerpt();
		}
		?>
	</div>
</article>

