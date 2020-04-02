<?php get_header() ?>

<div class="content container">
	<main class="main">
		<?php
		the_post();
		get_template_part( 'template-parts/content/page' );

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer() ?>