	<footer class="footer">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="footer-widgets">
				<div class="container">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<?php
			$copyright = get_theme_mod( 'footer_copyright' );
			if ( ! $copyright ) {
				// Translators: %1$s - Theme name, %2$s - Theme shop name.
				$copyright = sprintf( __( 'Proudly powered by WordPress. Theme %1$s by %2$s.', 'estar' ), '<a href="https://gretathemes.com/wordpress-themes/estar/">eStar</a>', 'GretaThemes' );
			}
			echo wp_kses_post( $copyright );
			?>
		</div>
	</footer>

	<?php wp_footer() ?>
</body>
</html>