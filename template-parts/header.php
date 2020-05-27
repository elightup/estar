<header class="header" role="banner">
	<div class="header-inner container">
		<div class="branding">
			<?php get_template_part( 'template-parts/site/logo' ); ?>
			<div class="site-name">
				<?php
				get_template_part( 'template-parts/site/title' );
				get_template_part( 'template-parts/site/description' );
				?>
			</div>
		</div>

		<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
			<nav class="nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'estar' ); ?>" role="navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'estar' ); ?></span>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/></svg>
				</button>
				<?php
				wp_nav_menu( [
					'container'      => null,
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				] );
				?>
			</nav>
		<?php endif ?>

		<?php EStar\Integration\WooCommerce::output_cart_icon(); ?>

		<?php if ( get_theme_mod( 'header_search', true ) ) : ?>
			<button class="search-open" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Search', 'estar' ); ?></span>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>
			</button>
			<div class="header-search">
				<?php get_search_form(); ?>
				<button class="search-close">
					<span class="screen-reader-text"><?php esc_html_e( 'Close', 'estar' ); ?></span>
					&times;
				</button>
			</div>
		<?php endif; ?>
	</div>
</header>