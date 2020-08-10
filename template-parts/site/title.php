<?php $html_tag = is_front_page() ? 'h1' : 'div'; ?>
<<?php echo esc_html( $html_tag ) ?> class="site-title">
	<a href="<?php echo esc_url( home_url() ) ?>"><?php bloginfo( 'name' ) ?></a>
</<?php echo esc_html( $html_tag ) ?>>