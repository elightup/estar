<?php get_header() ?>

<main>
	<div class="container">
		<?php
		the_post();
		get_template_part( 'template-parts/content/post' );
		?>
	</div>
</main>

<?php get_footer() ?>