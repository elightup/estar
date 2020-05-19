<?php
namespace EStar;

class Post {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
		add_filter( 'post_class', [ $this, 'add_post_classes' ] );

		add_filter( 'previous_post_link', [ $this, 'previous_post_link' ], 10, 4 );
		add_filter( 'next_post_link', [ $this, 'next_post_link' ], 10, 4 );

		add_action( 'wp_head', [ $this, 'output_css' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_section( 'post', [
			'title'    => esc_html__( 'Post', 'estar' ),
			'priority' => Customizer::get_priority( 'post' ),
		] );

		$wp_customize->add_setting( 'post_layout', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'sidebar-right',
		] );
		$wp_customize->add_control( 'post_layout', [
			'label'   => esc_html__( 'Layout', 'estar' ),
			'section' => 'post',
			'type'    => 'select',
			'choices' => [
				'sidebar-right' => __( 'Sidebar Right', 'estar' ),
				'sidebar-left'  => __( 'Sidebar Left', 'estar' ),
				'no-sidebar'    => __( 'No Sidebar', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'post_thumbnail_position', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'thumbnail-before-header',
		] );
		$wp_customize->add_control( 'post_thumbnail_position', [
			'label'   => esc_html__( 'Thumbnail Position', 'estar' ),
			'section' => 'post',
			'type'    => 'select',
			'choices' => [
				'thumbnail-header-background' => __( 'As Post Header Background', 'estar' ),
				'thumbnail-before-header'     => __( 'Before Post Header', 'estar' ),
				'thumbnail-after-header'      => __( 'After Post Header', 'estar' ),
				'no-thumbnail'                => __( 'Do Not Display', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'post_header_align', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'left',
		] );
		$wp_customize->add_control( 'post_header_align', [
			'label'   => esc_html__( 'Header Alignment', 'estar' ),
			'section' => 'post',
			'type'    => 'select',
			'choices' => [
				'left'   => __( 'Left', 'estar' ),
				'right'  => __( 'Right', 'estar' ),
				'center' => __( 'Center', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'post_header_height', [
			'sanitize_callback' => 'absint',
		] );
		$wp_customize->add_control( 'post_header_height', [
			'label'       => esc_html__( 'Header Height (px)', 'estar' ),
			'section'     => 'post',
			'type'        => 'number',
			'description' => esc_html__( 'Works only when the thumbnail is set as header background.', 'estar' ),
		] );
	}

	public function add_body_classes( $classes ) {
		if ( ! is_singular() ) {
			return $classes;
		}
		$classes[] = 'singular';

		$thumbnail_position = self::get_thumbnail_position();
		if ( has_post_thumbnail() || 'thumbnail-header-background' !== $thumbnail_position ) {
			$classes[] = esc_attr( $thumbnail_position );
		}

		if ( ! is_single() ) {
			return $classes;
		}
		$classes[] = 'entry-header-' . esc_attr( get_theme_mod( 'post_header_align', 'left' ) );
		return $classes;
	}

	public function add_post_classes( $classes ) {
		$classes[] = 'entry';
		return $classes;
	}

	public function previous_post_link( $output, $format, $link, $adjacent_post ) {
		if ( empty( $adjacent_post ) ) {
			return $output;
		}

		// Using global $post for setup_postdata() to make template tags work.
		global $post;
		$post = $adjacent_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post );

		ob_start();
		get_template_part( 'template-parts/content/adjacent', 'previous' );
		wp_reset_postdata();

		return ob_get_clean();
	}

	public function next_post_link( $output, $format, $link, $adjacent_post ) {
		if ( empty( $adjacent_post ) ) {
			return $output;
		}

		// Using global $post for setup_postdata() to make template tags work.
		global $post;
		$post = $adjacent_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		setup_postdata( $post );

		ob_start();
		get_template_part( 'template-parts/content/adjacent', 'next' );
		wp_reset_postdata();

		return ob_get_clean();
	}

	public function output_css() {
		if ( ! is_singular() ) {
			return;
		}
		$type = is_page() ? 'page' : 'post';

		$height             = self::get_header_height();
		$thumbnail_position = self::get_thumbnail_position();
		if ( $height && 'thumbnail-header-background' === $thumbnail_position ) {
			echo '<style>.entry-header { height: ', absint( $height ), 'px; }</style>';
		}
	}

	public static function date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		printf(
			$time_string, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
	}

	public static function author() {
		printf(
			'<span class="author vcard">%s <a class="url fn n" href="%s">%s</a></span>',
			get_avatar( get_the_author_meta( 'user_email' ), 24 ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}

	public static function categories() {
		the_category();
	}

	public static function tags() {
		the_tags( '<div class="tags">', '', '</div>' );
	}

	public static function get_thumbnail_position() {
		$type = is_page() ? 'page' : 'post';
		return apply_filters( 'estar_post_thumbnail_position', get_theme_mod( "{$type}_thumbnail_position", 'thumbnail-before-header' ) );
	}

	public static function get_thumbnail_size() {
		$thumbnail_position = self::get_thumbnail_position();
		$layout             = Layout::get_layout();

		$size = 'thumbnail-header-background' === $thumbnail_position || 'no-sidebar' === $layout ? 'full' : 'medium_large';
		return apply_filters( 'estar_post_thumbnail_size', $size );
	}

	public static function get_thumbnail_class() {
		$thumbnail_position = self::get_thumbnail_position();
		$layout             = Layout::get_layout();

		$class = 'thumbnail-header-background' === $thumbnail_position ? 'alignfull' : ( 'no-sidebar' === $layout ? 'alignwide' : '' );
		return apply_filters( 'estar_post_thumbnail_class', $class );
	}

	public static function get_header_height() {
		$type = is_page() ? 'page' : 'post';
		return apply_filters( 'estar_post_header_height', get_theme_mod( "{$type}_header_height" ) );
	}
}