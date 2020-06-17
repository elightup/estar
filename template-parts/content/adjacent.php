<article class="adjacent">
	<?php if ( has_post_thumbnail() ) : ?>
		<a class="adjacent-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
	<?php endif; ?>
	<div class="adjacent-body">
		<div class="adjacent-label"><?php esc_html_e( 'Previous Post', 'estar' ); ?></div>
		<?php the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
	</div>
</article>