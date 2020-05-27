<?php
namespace EStar\Integration;

class WooCommerce {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'after_setup_theme', [ $this, 'add_theme_support' ] );
		add_action( 'customize_register', [ $this, 'register' ] );
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );

		add_action( 'template_redirect', [ $this, 'setup_hooks' ] );
		add_filter( 'body_class', [ $this, 'remove_body_classes' ], 99 );
		add_filter( 'estar_layout', [ $this, 'get_layout' ] );

		add_filter( 'woocommerce_add_to_cart_fragments', [ $this, 'add_cart_icon_fragment' ] );

		add_action( 'template_redirect', [ $this, 'remove_assets' ] );
	}

	public function add_theme_support() {
		add_theme_support( 'woocommerce', [
			'thumbnail_image_width' => 245,
		] );

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_setting( 'header_cart', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'header_cart', [
			'label'   => esc_html__( 'Show cart icon', 'estar' ),
			'section' => 'title_tagline',
			'type'    => 'checkbox',
		] );

		$wp_customize->add_setting( 'product_archive_layout', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'no-sidebar',
		] );
		$wp_customize->add_control( 'product_archive_layout', [
			'label'    => esc_html__( 'Layout', 'estar' ),
			'section'  => 'woocommerce_product_catalog',
			'panel'    => 'woocommerce',
			'priority' => 1,
			'type'     => 'select',
			'choices'  => [
				'sidebar-right' => __( 'Sidebar Right', 'estar' ),
				'sidebar-left'  => __( 'Sidebar Left', 'estar' ),
				'no-sidebar'    => __( 'No Sidebar', 'estar' ),
			],
		] );

		$wp_customize->add_section( 'wc_optimization', [
			'title' => __( 'Optimization', 'estar' ),
			'panel' => 'woocommerce',
		] );

		$wp_customize->add_setting( 'wc_no_assets', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_checkbox' ],
			'default'           => true,
		] );
		$wp_customize->add_control( 'wc_no_assets', [
			'label'   => esc_html__( 'Remove styles and scripts on non-WooCommerce pages', 'estar' ),
			'section' => 'wc_optimization',
			'type'    => 'checkbox',
			'description' => __( 'Do not enable this option if you use WooCommerce blocks', 'estar' ),
		] );
	}

	public function widgets_init() {
		register_sidebar( [
			'name'          => esc_html__( 'Shop Sidebar', 'estar' ),
			'id'            => 'sidebar-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );
	}

	public function setup_hooks() {
		if ( ! is_woocommerce() ) {
			return;
		}

		// Change content wrapper.
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

		// No sidebar for single products.
		if ( is_product() ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
			return;
		}

		// Product archive.
		add_action( 'woocommerce_before_main_content', [ $this, 'output_content_wrapper' ] );
		add_action( 'woocommerce_after_main_content', [ $this, 'output_content_wrapper_end' ] );
	}

	public function output_content_wrapper() {
		echo '<main class="main" role="main">';
	}

	public function output_content_wrapper_end() {
		echo '</main>';
	}

	public function remove_body_classes( $classes ) {
		if ( ! is_woocommerce() ) {
			return $classes;
		}

		// Remove all classes set by Post/Archive classes.
		$classes = array_diff( $classes, [
			'singular',
			'thumbnail-before-header', 'thumbnail-after-header', 'thumbnail-header-background',
			'entry-header-left', 'entry-header-right', 'entry-header-center',

			'archive', 'hfeed',
			'list-horizontal', 'list-vertical', 'grid', 'grid-card',
		] );

		return $classes;
	}

	public function get_layout( $layout ) {
		if ( ! is_woocommerce() ) {
			return $layout;
		}
		// No layout for single product, set layout for product archive only.
		return is_product() ? '' : get_theme_mod( 'product_archive_layout', 'no-sidebar' );
	}

	public function add_cart_icon_fragment( $fragments ) {
		ob_start();
		self::output_cart_icon();
		$fragments['.cart-icon'] = ob_get_clean();
		return $fragments;
	}

	public static function output_cart_icon() {
		if ( ! defined( 'WC_PLUGIN_FILE' ) || ! get_theme_mod( 'header_cart', true ) ) {
			return;
		}
		?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon">
			<?php
			$count = WC()->cart->get_cart_contents_count();
			if ( $count ) {
				echo '<span class="cart-badge">' . esc_html( $count ) . '<span class="screen-reader-text">' . esc_html__( 'Items in Cart', 'estar' ) . '</span></span>';
			}
			?>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M17 16a3 3 0 1 1-2.83 2H9.83a3 3 0 1 1-5.62-.1A3 3 0 0 1 5 12V4H3a1 1 0 1 1 0-2h3a1 1 0 0 1 1 1v1h14a1 1 0 0 1 .9 1.45l-4 8a1 1 0 0 1-.9.55H5a1 1 0 0 0 0 2h12zM7 12h9.38l3-6H7v6zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
		</a>
		<?php
	}

	public function remove_assets() {
		if ( ! get_theme_mod( 'wc_no_assets', true ) || is_woocommerce() || is_cart() || is_checkout() ) {
			return;
		}
		remove_action( 'wp_enqueue_scripts', [ 'WC_Frontend_Scripts', 'load_scripts' ] );
		remove_action( 'wp_print_scripts', [ 'WC_Frontend_Scripts', 'localize_printed_scripts' ], 5 );
		remove_action( 'wp_print_footer_scripts', [ 'WC_Frontend_Scripts', 'localize_printed_scripts' ], 5 );
	}
}