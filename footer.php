	<footer class="footer">
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="footer-widgets">
				<div class="container">
					<?php dynamic_sidebar( 'sidebar-1' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="site-info">
			<?php esc_html_e( 'Proudly powered by WordPress', 'floral' ); ?>
			<?php // Translators: %1$s - Theme name, %2$s - Theme shop name. ?>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'floral' ), '<a href="https://gretathemes.com/wordpress-themes/estar/">eStar</a>', 'GretaThemes' ); ?>
		</div>
	</footer>

	<?php wp_footer() ?>
</body>
</html>