<?php
/**
 * Template Name: Landing Page
 * Template Post Type: post, page
 */
?>

<?php get_header() ?>

<?php
while ( have_posts() ) {
	the_post();

	do_action( 'estar_entry_before' );

	the_content();

	do_action( 'estar_entry_after' );
}
?>

<?php get_footer() ?>