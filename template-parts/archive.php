<main class="main" role="main">
	<?php if ( have_posts() ) : ?>
		<?php get_template_part( 'template-parts/archive-header' ); ?>

		<div class="entries">
			<?php
			while ( have_posts() ) {
				the_post();

				$layout = get_theme_mod( 'archive_content_layout', 'list-horizontal' );
				$layout = in_array( $layout, ['grid', 'grid-card'], true ) ? 'grid' : 'list';
				get_template_part( 'template-parts/content/archive', $layout );
			}
			?>
		</div>

		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<?php get_template_part( 'template-parts/content/none' ); ?>
	<?php endif; ?>
</main>

<?php if ( have_posts() ) : ?>
	<?php get_sidebar(); ?>
<?php endif; ?>