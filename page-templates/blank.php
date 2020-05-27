<?php
/**
 * Template Name: Blank Canvas
 * Template Post Type: post, page
 */
?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	wp_footer();
	?>
</body>
</html>