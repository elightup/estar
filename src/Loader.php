<?php
namespace EStar;

class Loader {
	public function __construct() {
		add_action( 'tgmpa_register', [ $this, 'register_plugins' ] );
		add_action( 'after_setup_theme', [ $this, 'setup' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
		add_action( 'wp_head', [ $this, 'replace_html_class' ] );
		$this->init();
	}

	public function register_plugins() {
		$plugins = [
			[
				'name' => __( 'eRocket', 'estar' ),
				'slug' => 'erocket',
			],
			[
				'name' => __( 'Meta Box', 'estar' ),
				'slug' => 'meta-box',
			],
		];
		tgmpa( $plugins );
	}

	public function setup() {
		load_theme_textdomain( 'estar', get_template_directory() . '/languages' );

		register_nav_menus( [
			'menu-1' => __( 'Header', 'estar' ),
		] );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'] );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-logo' );

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 373, 280, true );
		add_image_size( 'estar-grid', 373, 210, true );

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
			[
				'name'      => _x( '5XL', 'Name of the 4XL font size in the block editor', 'estar' ),
				'shortName' => _x( '5XL', 'Short name of the 4XL font size in the block editor.', 'estar' ),
				'size'      => 48,
				'slug'      => '5xl',
			],
			[
				'name'      => _x( '6XL', 'Name of the 4XL font size in the block editor', 'estar' ),
				'shortName' => _x( '6XL', 'Short name of the 4XL font size in the block editor.', 'estar' ),
				'size'      => 64,
				'slug'      => '6xl',
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

		// AMP.
		add_theme_support( 'amp', [
			'paired' => true,
			'nav_menu_toggle' => [
				'nav_container_id'           => 'nav',
				'nav_container_toggle_class' => 'is-open',
				'menu_button_id'             => 'menu-toggle',
			],
			'nav_menu_dropdown' => [
				'sub_menu_button_class'        => 'sub-menu-toggle',
				'sub_menu_button_toggle_class' => 'is-open',
			],
		] );

		// phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound
		$GLOBALS['content_width'] = apply_filters( 'estar_content_width', 768 );
	}

	public function enqueue_assets() {
		$suffix = defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
		$version = wp_get_theme( get_template() )->Version;
		wp_enqueue_style( 'estar', get_template_directory_uri() . "/style$suffix.css", [], $version );
		if ( ! Integration\AMP::is_active() ) {
			wp_enqueue_script( 'estar', get_template_directory_uri() . "/js/script$suffix.js", [], $version, true );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}
	}

	public function widgets_init() {
		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'estar' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );
		register_sidebar( [
			'name'          => esc_html__( 'Footer', 'estar' ),
			'id'            => 'sidebar-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );
	}

	public function replace_html_class() {
		if ( Integration\AMP::is_active() ) {
			return;
		}
		?>
		<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
		<?php
	}

	private function init() {
		Structure::setup();
		Layout::setup();

		$sanitizer = new Customizer\Sanitizer;

		new Fonts\Fonts( $sanitizer );
		new Colors\Colors;

		new Customizer( $sanitizer );

		new Archive( $sanitizer );
		new Post( $sanitizer );
		new Page( $sanitizer );

		new GoToTop( $sanitizer );

		if ( ! is_admin() ) {
			new Menu;
		}

		if ( defined( 'FL_BUILDER_VERSION' ) && defined( 'FL_THEME_BUILDER_VERSION' ) ) {
			new Integration\BeaverThemer;
		}
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			new Integration\ElementorPro;
		}
		if ( defined( 'WC_PLUGIN_FILE' ) ) {
			new Integration\WooCommerce( $sanitizer );
		}
		if ( defined( 'TRIBE_EVENTS_FILE' ) ) {
			new Integration\TheEventsCalendar;
		}
		if ( class_exists( 'bbPress' ) ) {
			new Integration\BBPress;
		}
		if ( defined( 'RWMB_VER' ) ) {
			new PostSettings;
		}
	}
}