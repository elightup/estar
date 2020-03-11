<?php
add_action( 'after_setup_theme', 'estar_setup' );

function estar_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
}

add_action( 'wp_enqueue_scripts', 'estar_scripts' );

function estar_scripts() {
	wp_enqueue_style( 'estar', get_stylesheet_uri(), [], '0.0.1' );
}