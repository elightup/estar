<?php $tag = is_singular() ? 'div' : 'h1'; ?>
<<?= esc_html( $tag ) ?> class="site-logo"><?php the_custom_logo() ?></<?= esc_html( $tag ) ?>>