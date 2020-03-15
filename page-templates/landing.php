<?php
/**
 * Template Name: Landing Page
 */
?>

<?php get_header() ?>

<main id="content" class="container">
	<?php
	the_post();
	the_content();
	?>
</main>

<?php get_footer() ?>