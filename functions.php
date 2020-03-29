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
			'name'      => _x( 'Very Small', 'Name of the very small font size in the block editor', 'estar' ),
			'shortName' => _x( 'XS', 'Short name of the very small font size in the block editor.', 'estar' ),
			'size'      => 12,
			'slug'      => 'xs',
		],
		[
			'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'estar' ),
			'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'estar' ),
			'size'      => 14,
			'slug'      => 'sm',
		],
		[
			'name'      => _x( 'Medium', 'Name of the medium font size in the block editor', 'estar' ),
			'shortName' => _x( 'M', 'Short name of the medium font size in the block editor.', 'estar' ),
			'size'      => 16,
			'slug'      => 'md',
		],
		[
			'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'estar' ),
			'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'estar' ),
			'size'      => 18,
			'slug'      => 'lg',
		],
		[
			'name'      => _x( 'XL', 'Name of the XL font size in the block editor', 'estar' ),
			'shortName' => _x( 'XL', 'Short name of the XL font size in the block editor.', 'estar' ),
			'size'      => 20,
			'slug'      => 'xl',
		],
		[
			'name'      => _x( '2XL', 'Name of the 2XL font size in the block editor', 'estar' ),
			'shortName' => _x( '2XL', 'Short name of the 2XL font size in the block editor.', 'estar' ),
			'size'      => 24,
			'slug'      => '2xl',
		],
		[
			'name'      => _x( '3XL', 'Name of the 3XL font size in the block editor', 'estar' ),
			'shortName' => _x( '3XL', 'Short name of the 3XL font size in the block editor.', 'estar' ),
			'size'      => 30,
			'slug'      => '3xl',
		],
		[
			'name'      => _x( '4XL', 'Name of the 4XL font size in the block editor', 'estar' ),
			'shortName' => _x( '4XL', 'Short name of the 4XL font size in the block editor.', 'estar' ),
			'size'      => 36,
			'slug'      => '4xl',
		],
	] );

	add_theme_support( 'editor-color-palette', [
		[
			'name'  => __( 'Accent Color', 'estar' ),
			'slug'  => 'accent',
			'color' => get_theme_mod( 'color-accent', '#4299e1' ),
		],
		[
			'name'  => __( 'Dark', 'estar' ),
			'slug'  => 'dark',
			'color' => get_theme_mod( 'color-dark', '#1a202c' ),
		],
		[
			'name'  => __( 'Base', 'estar' ),
			'slug'  => 'base',
			'color' => get_theme_mod( 'color-base', '#4a5568' ),
		],
		[
			'name'  => __( 'Gray', 'estar' ),
			'slug'  => 'gray',
			'color' => get_theme_mod( 'color-gray', '#a0aec0' ),
		],
		[
			'name'  => __( 'Light', 'estar' ),
			'slug'  => 'light',
			'color' => get_theme_mod( 'color-light', '#e2e8f0' ),
		],
		[
			'name'  => __( 'White', 'estar' ),
			'slug'  => 'white',
			'color' => '#fff',
		],
	] );

	$GLOBALS['content_width'] = apply_filters( 'estar_content_width', 648 );
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

add_action( 'widgets_init', 'estar_widgets_init' );

function estar_widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Footer', 'estar' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	] );
}

new EStar\Fonts\Fonts;
new EStar\Colors\Colors;
new EStar\Customizer;

$estar_sanitizer = new EStar\Sanitizer;
$estar_icons = new EStar\Icons;
new EStar\GoToTop( $estar_sanitizer, $estar_icons );

if ( ! is_admin() ) {
	new EStar\TemplateFunctions;
}