<?php
if ( ! has_nav_menu( 'menu-1' ) ) {
	return;
}
?>

<nav id="nav" class="nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'estar' ); ?>" role="navigation">
	<?php
	wp_nav_menu( [
		'container'      => null,
		'theme_location' => 'menu-1',
		'menu_id'        => 'primary-menu',
	] );
	?>
</nav>