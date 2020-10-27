<?php
if ( ! has_nav_menu( 'menu-1' ) ) {
	return;
}
?>

<button id="menu-toggle" class="menu-toggle header-icon" aria-controls="primary-menu" aria-expanded="false">
	<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'estar' ); ?></span>
	<?php EStar\Icons::render( 'menu' ) ?>
</button>