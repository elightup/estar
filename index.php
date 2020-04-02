<?php get_header(); ?>

<main class="main" role="main">
	<?php if ( have_posts() ) : ?>
		<?php get_template_part( 'template-parts/page-header' ); ?>

		<div class="entries">
				<?php
				while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/archive', get_theme_mod( 'archive_content_layout', 'list-horizontal' ) );
			}
			?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/none' ); ?>
	<?php endif; ?>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>