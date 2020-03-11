<?php $tag = is_singular() ? 'h1' : 'div'; ?>
<<?= $tag ?> class="site-title">
	<a href="<?= esc_url( home_url() ) ?>"><?php bloginfo( 'name' ); ?></a>
</<?= $tag ?>>