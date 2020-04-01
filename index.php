<?php get_header(); ?>

<div class="content container">
	<main class="main">
		<?php if ( have_posts() ) : ?>
			<?php get_template_part( 'template-parts/page-header' ); ?>

			<div class="entries">
 				<?php
 				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content/archive' );
				}
				?>
			</div>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content/none' ); ?>
		<?php endif; ?>
	</main>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>