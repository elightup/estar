<?php
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

if ( ! is_singular() ) {
	$archive_layout = get_theme_mod( 'archive_layout', 'list-horizontal sidebar-right' );
	if ( false !== strpos( $archive_layout, 'no-sidebar' ) ) {
		return;
	}
}
?>

<aside class="sidebar widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>