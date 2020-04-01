<article <?php post_class() ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>

	<div class="entry-body">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<div class="entry-summary">
			<?php
			if ( 'excerpt' === get_theme_mod( 'archive_content', 'excerpt' ) ) {
				the_excerpt();
			} else {
				the_content();
			}
			?>
		</div>
	</div>
</article>

