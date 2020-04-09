<?php
/**
 * Template Name: Narrow Content
 * Template Post Type: post, page
 */
?>

<?php get_header(); ?>

<main class="main" role="main">
	<?php
	while ( have_posts() ) {
		the_post();
		the_content();
	}
	?>
<?php get_footer(); ?>