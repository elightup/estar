<?php
require __DIR__ . '/vendor/autoload.php';

add_action( 'after_setup_theme', 'estar_setup' );

function estar_setup() {
	load_theme_textdomain( 'estar', get_template_directory() . '/languages' );

	register_nav_menus( [
		'menu-1' => __( 'Header', 'estar' ),
	] );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption'] );
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for the block editor.
	 *
	 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/
	 */
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_editor_style( 'style-editor.css' );

	add_theme_support( 'editor-font-sizes', [
		[
			'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'estar' ),
			'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'estar' ),
			'size'      => 14,
			'slug'      => 'small',
		],
		[
			'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'estar' ),
			'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'estar' ),
			'size'      => 16,
			'slug'      => 'normal',
		],
		[
			'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'estar' ),
			'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'estar' ),
			'size'      => 18,
			'slug'      => 'large',
		],
		[
			'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'estar' ),
			'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'estar' ),
			'size'      => 20,
			'slug'      => 'larger',
		],
		[
			'name'      => _x( 'Huge', 'Name of the huge font size in the block editor', 'estar' ),
			'shortName' => _x( 'XL', 'Short name of the huge font size in the block editor.', 'estar' ),
			'size'      => 24,
			'slug'      => 'huge',
		],
	] );

	add_theme_support( 'editor-color-palette', [
		[
			'name'  => __( 'Accent Color', 'estar' ),
			'slug'  => 'accent',
			'color' => '#4299e1',
		],
		[
			'name'  => __( 'Dark', 'estar' ),
			'slug'  => 'dark',
			'color' => '#1a202c',
		],
		[
			'name'  => __( 'Base', 'estar' ),
			'slug'  => 'base',
			'color' => '#4a5568',
		],
		[
			'name'  => __( 'Gray', 'estar' ),
			'slug'  => 'gray',
			'color' => '#a0aec0',
		],
		[
			'name'  => __( 'Light', 'estar' ),
			'slug'  => 'light',
			'color' => '#e2e8f0',
		],
		[
			'name'  => __( 'White', 'estar' ),
			'slug'  => 'background',
			'color' => '#fff',
		],
	] );
}

add_action( 'wp_enqueue_scripts', 'estar_scripts' );

function estar_scripts() {
	wp_enqueue_style( 'estar', get_template_directory_uri() . '/style.css', [], '0.0.1' );

	if ( is_child_theme() ) {
		wp_enqueue_style( get_stylesheet(), get_stylesheet_uri(), ['estar'], '0.0.1' );
	}

	wp_enqueue_script( 'estar', get_template_directory_uri() . '/js/script.js', [], '0.0.1', true );
	wp_localize_script( 'estar', 'EStar', [
		'submenuToggle' => __( 'Show submenu for %s', 'estar' ),
	] );
}

new EStar\Fonts\Fonts;
new EStar\Colors\Colors;
if ( ! is_admin() ) {
	new EStar\TemplateFunctions;
}