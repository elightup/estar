<article <?php post_class() ?>>
	<header class="entry-header">
		<?php
		get_template_part( 'template-parts/breadcrumbs' );
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>
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