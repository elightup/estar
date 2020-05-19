<footer class="footer" role="contentinfo">
	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="footer-widgets">
			<div class="container">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php
	// Translators: %1$s - Current year, %2$s - Blog name, %3$s - Theme name, %4$s - Theme shop name.
	$default = sprintf( __( 'Copyright &copy; %1$s %2$s. Theme %3$s by %4$s.', 'estar' ), date_i18n( __( 'Y' , 'estar' ) ), get_bloginfo( 'name' ), '<a href="https://gretathemes.com/wordpress-themes/estar/">eStar</a>', 'GretaThemes' );
	$copyright = get_theme_mod( 'footer_copyright', $default );
	if ( $copyright ) {
		echo '<div class="site-info">', wp_kses_post( get_theme_mod( 'footer_copyright', $default ) ), '</div>';
	}
	?>
</footer>