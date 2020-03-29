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
				// Translators: %1$s - Current year, %2$s - Blog name, %3$s - Theme name, %4$s - Theme shop name.
				$copyright = sprintf( __( 'Copyright &copy; %1$s %2$s. Theme %3$s by %4$s.', 'estar' ), gmdate( 'Y' ), get_bloginfo( 'name' ), '<a href="https://gretathemes.com/wordpress-themes/estar/">eStar</a>', 'GretaThemes' );
			}
			echo wp_kses_post( $copyright );
			?>
		</div>
	</footer>

	<?php wp_footer() ?>
</body>
</html>