<!DOCTYPE html>
<html class="no-js" <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head() ?>
</head>
<body <?php body_class() ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'estar' ); ?></a>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' ); // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedHooknameFound
	}

	do_action( 'estar_header_before' );
	do_action( 'estar_header' );
	do_action( 'estar_header_after' );
	?>

	<div class="content container" id="content">
