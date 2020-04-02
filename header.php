<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'estar' ); ?></a>
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
	?>
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
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_e( 'Menu', 'estar' ); ?></span></button>
					<?php
					wp_nav_menu( [
						'container'      => null,
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					] );
					?>
				</nav>
			<?php endif ?>
			<button class="search-open" aria-expanded="false">
				<span class="screen-reader-text"><?php esc_html_e( 'Search', 'estar' ); ?></span>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/></svg>
			</button>
			<div class="header-search">
				<?php get_search_form(); ?>
				<button class="search-close">
					<span class="screen-reader-text"><?php esc_html_e( 'Search', 'estar' ); ?></span>
					&times;
				</button>
			</div>
		</div>
	</header>

	<div class="content container" id="content">
