<?php
if ( has_nav_menu( 'menu-1' ) ) : ?>
	<nav id="nav" class="nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'estar' ); ?>" role="navigation">
		<button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'estar' ); ?></span>
			<?php EStar\Icons::render( 'menu' ) ?>
		</button>
		<?php
		wp_nav_menu( [
			'container'      => null,
			'theme_location' => 'menu-1',
			'menu_id'        => 'primary-menu',
		] );
		?>
	</nav>
<?php endif; ?>