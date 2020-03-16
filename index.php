<?php get_header() ?>

<main>
	<?php if ( have_posts() ) : ?>
		<?php if ( ! is_front_page() ) : ?>
			<header class="page-header">
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header>
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content/archive' ); ?>
		<?php endwhile ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/none' ); ?>
	<?php endif; ?>
</main>

<?php get_footer() ?>