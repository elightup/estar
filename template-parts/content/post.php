<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<header class="entry-header">
		<?php if ( has_post_thumbnail() && 'no-thumbnail' !== get_theme_mod( 'post_thumbnail', 'thumbnail-before-header' ) ) : ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		<?php endif; ?>
		<div class="entry-header-text">
			<?php
			EStar\Post::categories();
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
					EStar\Post::author();
					EStar\Post::date();
					?>
				</div>
			<?php endif; ?>
		</div>
	</header>

	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages( [
			'before' => '<p class="page-links">' . esc_html__( 'Pages:', 'estar' ),
			'after'  => '</p>',
		] );
		?>
	</div>

	<footer class="entry-footer">
		<?php EStar\Post::tags(); ?>
	</footer>
</article>