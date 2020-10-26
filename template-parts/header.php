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

		<?php
		if ( get_theme_mod( 'menu_position' ) == 'right' ) {
			get_template_part( 'template-parts/menu' );
		} ?>

		<?php EStar\Integration\WooCommerce::output_cart_icon(); ?>

		<?php if ( get_theme_mod( 'header_search', true ) || get_theme_mod( 'header_search_form', false ) ) : ?>
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
	<?php if ( get_theme_mod( 'menu_position' ) == 'bottom' ) {
		echo '<div class="header-bottom" id="header-bottom">';
			echo '<div class="container">';
					get_template_part( 'template-parts/menu' );
			echo '</div>';
		echo '</div>';
	} ?>
</header>
