<?php $html_tag = is_singular() ? 'div' : 'h1'; ?>
<<?php echo esc_html( $html_tag ) ?> class="site-title">
	<a href="<?php echo esc_url( home_url() ) ?>"><?php bloginfo( 'name' ) ?></a>
</<?php echo esc_html( $html_tag ) ?>>