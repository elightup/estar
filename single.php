<?php get_header() ?>

<main>
	<?php
	the_post();
	get_template_part( 'template-parts/content/post' );
	?>
</main>

<?php get_footer() ?>