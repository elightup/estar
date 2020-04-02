<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="entry-thumbnail" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( EStar\Archive::get_thumbnail_size() ); ?>
		</a>
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
		<?php
		if ( 'post' === get_post_type() ) {
			get_template_part( 'template-parts/post-meta' );
		}
		?>
	</div>
</article>