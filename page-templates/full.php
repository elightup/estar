<?php
/**
 * Template Name: Full Width
 * Template Post Type: post, page
 */

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();