<?php $tag = is_singular() ? 'div' : 'h1'; ?>
<<?= esc_html( $tag ) ?> class="site-title">
	<a href="<?= esc_url( home_url() ) ?>"><?php bloginfo( 'name' ) ?></a>
</<?= esc_html( $tag ) ?>>