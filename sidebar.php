<?php
if ( ! EStar\Layout::has_sidebar() ) {
	return;
}
?>

<aside class="sidebar" role="complementary">
	<?php
	do_action( 'estar_sidebar_top' );

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		dynamic_sidebar( 'sidebar-1' );
	} else {
		esc_html_e( 'Please go to Customize > Widgets and add widgets to this area.', 'estar' );
	}

	do_action( 'estar_sidebar_bottom' );
	?>
</aside>
