<?php
$position = EStar\Post::get_thumbnail_position();
if ( ! has_post_thumbnail() || 'no-thumbnail' === $position ) {
	return;
}
?>

<div class="entry-thumbnail <?php echo esc_attr( EStar\Post::get_thumbnail_class() ); ?>">
	<?php the_post_thumbnail( EStar\Post::get_thumbnail_size() ); ?>
</div>