<?php get_header() ?>

<main class="main" role="main">
	<?php
	the_post();
	get_template_part( 'template-parts/content/post' );

	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>
</main>

<?php get_sidebar(); ?>
<?php get_footer() ?>