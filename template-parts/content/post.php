<article <?php post_class() ?>>
	<header class="entry-header">
		<?php
		the_category();
		the_title( '<h1 class="entry-title">', '</h1>' );

		if ( 'post' === get_post_type() ) {
			get_template_part( 'template-parts/post-meta' );
		}
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

	<footer class="entry-footer">
		<?php
		$tags = get_the_tag_list( '', '' );
		if ( $tags ) {
			echo '<div class="tags">', $tags, '</div>'; // WPCS: OK.
		}
		?>
	</footer>
</article>