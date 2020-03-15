<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
	?>
	<header class="header">
		<div class="container">
			<div class="branding">
				<?php
				if ( has_custom_logo() ) {
					get_template_part( 'template-parts/site/logo' );
				} else {
					get_template_part( 'template-parts/site/title' );
					get_template_part( 'template-parts/site/description' );
				}
				?>
			</div>
			<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
				<nav class="nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'estar' ); ?>">
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
		</div>
	</header>
