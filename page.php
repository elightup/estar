<?php get_header() ?>

<main>
	<?php
	the_post();
	get_template_part( 'template-parts/content/page' );
	?>
</main>

<?php get_footer() ?>