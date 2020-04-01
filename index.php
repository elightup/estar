<?php get_header(); ?>

<div class="content container">
	<main class="main">
		<?php
		if ( have_posts() ) {
			get_template_part( 'template-parts/page-header' );

			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/archive' );
			}

			the_posts_pagination();
		} else {
			get_template_part( 'template-parts/content/none' );
		}
		?>
	</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>