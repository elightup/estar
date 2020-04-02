<article <?php post_class() ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
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
</article>