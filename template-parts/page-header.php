<?php
if ( is_front_page() ) {
	return;
}
?>
<header class="page-header">
	<?php if ( is_home() ) : ?>
		<h1 class="page-title"><?php single_post_title(); ?></h1>
	<?php else : ?>
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
	<?php endif; ?>
</header>