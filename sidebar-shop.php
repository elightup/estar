<?php
if ( 'no-sidebar' === get_theme_mod( 'product_archive_layout', 'no-sidebar' ) ) {
	return;
}
?>

<aside class="sidebar" role="complementary">
	<?php
	do_action( 'estar_sidebar_top' );

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		dynamic_sidebar( 'sidebar-3' );
	} else {
		esc_html_e( 'Please go to Customize > Widgets and add widgets to this area.', 'estar' );
	}

	do_action( 'estar_sidebar_bottom' );
	?>
</aside>
