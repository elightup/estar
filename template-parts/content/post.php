<?php do_action( 'estar_entry_before' ); ?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	<?php do_action( 'estar_entry_header_before' ); ?>

	<header class="entry-header">
		<?php get_template_part( 'template-parts/entry-thumbnail' ); ?>

		<div class="entry-header-text">
			<?php
			EStar\Post::categories();
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php
					EStar\Post::author();
					EStar\Post::date();
					?>
				</div>
			<?php endif; ?>
		</div>
	</header>

	<?php do_action( 'estar_entry_header_after' ); ?>

	<?php do_action( 'estar_entry_content_before' ); ?>

	<div class="entry-content">
		<?php
		the_content();
		wp_link_pages( [
			'before' => '<p class="page-links">' . esc_html__( 'Pages:', 'estar' ),
			'after'  => '</p>',
		] );
		?>
	</div>

	<?php do_action( 'estar_entry_content_after' ); ?>

	<?php do_action( 'estar_entry_footer_before' ); ?>

	<footer class="entry-footer">
		<?php EStar\Post::tags(); ?>
	</footer>

	<?php do_action( 'estar_entry_footer_after' ); ?>
</article>

<?php do_action( 'estar_entry_after' ); ?>