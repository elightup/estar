<?php
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}

$layout = is_singular() ? get_theme_mod( 'post_layout', 'sidebar-right' ) : get_theme_mod( 'archive_layout', 'list-horizontal sidebar-right' );
if ( false !== strpos( $layout, 'no-sidebar' ) ) {
	return;
}
?>

<aside class="sidebar widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>