<header id="header" class="header" role="banner">
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
		<?php endif ?>

		<?php EStar\Integration\WooCommerce::output_cart_icon(); ?>

		<?php if ( get_theme_mod( 'header_search', true ) || get_theme_mod( 'header_search_form', true ) ) : ?>
			<button class="search-open" aria-expanded="false"
				<?php if ( EStar\Integration\AMP::is_active() ) : ?>
					on="tap:header.toggleClass( class='header-search-open' )"
				<?php endif; ?>
			>
				<span class="screen-reader-text"><?php esc_html_e( 'Search', 'estar' ); ?></span>
				<?php EStar\Icons::render( 'search' ) ?>
			</button>
			<div class="header-search">
				<?php get_search_form(); ?>
				<button class="search-close"
					<?php if ( EStar\Integration\AMP::is_active() ) : ?>
						on="tap:header.toggleClass( class='header-search-open', force=false )"
					<?php endif; ?>
				>
					<span class="screen-reader-text"><?php esc_html_e( 'Close', 'estar' ); ?></span>
					&times;
				</button>
			</div>
		<?php endif; ?>
	</div>
</header>