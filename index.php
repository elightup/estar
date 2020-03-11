<?php get_header() ?>

<main>
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class() ?>>
			<?php
			get_template_part( 'template-parts/post/title' );
			get_template_part( 'template-parts/post/content' );
			?>
		</article>
	<?php endwhile ?>
</main>

<?php get_footer() ?>