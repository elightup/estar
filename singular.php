<?php get_header() ?>

<main>
	<?php the_post(); ?>
	<article <?php post_class() ?>>
		<?php
		get_template_part( 'template-parts/post/title', 'singular' );
		get_template_part( 'template-parts/post/content', 'singular' );
		?>
	</article>
</main>

<?php get_footer() ?>