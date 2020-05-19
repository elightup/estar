<?php
namespace EStar;

class Archive {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );

		add_filter( 'body_class', [ $this, 'add_body_classes' ] );

		add_filter( 'excerpt_more', [ $this, 'continue_reading_link' ] );
		add_filter( 'the_content_more_link', [ $this, 'continue_reading_link' ] );

		add_filter( 'excerpt_length', [ $this, 'change_excerpt_length' ] );

		add_filter( 'get_the_archive_title', [ $this, 'change_archive_title' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_section( 'archive', [
			'title'    => esc_html__( 'Archive', 'estar' ),
			'priority' => Customizer::get_priority( 'archive' ),
		] );

		$wp_customize->add_setting( 'archive_layout', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'sidebar-right',
		] );
		$wp_customize->add_control( 'archive_layout', [
			'label'   => esc_html__( 'Layout', 'estar' ),
			'section' => 'archive',
			'type'    => 'select',
			'choices' => [
				'sidebar-right' => __( 'Sidebar Right', 'estar' ),
				'sidebar-left'  => __( 'Sidebar Left', 'estar' ),
				'no-sidebar'    => __( 'No Sidebar', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'archive_content_layout', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'list-horizontal',
		] );
		$wp_customize->add_control( 'archive_content_layout', [
			'label'   => esc_html__( 'Content Layout', 'estar' ),
			'section' => 'archive',
			'type'    => 'select',
			'choices' => [
				'list-horizontal' => __( 'List (Horizontal)', 'estar' ),
				'list-vertical'   => __( 'List (Vertical)', 'estar' ),
				'grid'            => __( 'Grid', 'estar' ),
				'grid-card'       => __( 'Grid (Card)', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'archive_content', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'excerpt',
		] );
		$wp_customize->add_control( 'archive_content', [
			'label'   => esc_html__( 'Content Display', 'estar' ),
			'section' => 'archive',
			'type'    => 'select',
			'choices' => [
				'content' => __( 'Content', 'estar' ),
				'excerpt' => __( 'Excerpt', 'estar' ),
			],
		] );

		$wp_customize->add_setting( 'archive_excerpt_length', [
			'sanitize_callback' => 'absint',
			'default'           => 55,
		] );
		$wp_customize->add_control( 'archive_excerpt_length', [
			'label'   => esc_html__( 'Excerpt Length', 'estar' ),
			'section' => 'archive',
			'type'    => 'number',
		] );

		$wp_customize->add_setting( 'archive_continue_text', [
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => __( 'Continue reading', 'estar' ),
		] );
		$wp_customize->add_control( 'archive_continue_text', [
			'label'   => esc_html__( 'Continue Reading Text', 'estar' ),
			'section' => 'archive',
			'type'    => 'text',
		] );
	}

	public function add_body_classes( $classes ) {
		if ( is_singular() ) {
			return $classes;
		}
		$classes[] = 'archive hfeed'; // .hfeed is required for hAtom.

		$layout    = get_theme_mod( 'archive_content_layout', 'list-horizontal' );
		$classes[] = esc_attr( $layout );
		if ( 'grid-card' === $layout ) {
			$classes[] = 'grid';
		}
		return $classes;
	}

	public function continue_reading_link() {
		$layout = get_theme_mod( 'archive_content_layout', 'list-horizontal' );
		if ( false !== strpos( $layout, 'grid' ) ) {
			return '&hellip;';
		}

		$text = get_theme_mod( 'archive_continue_text', __( 'Continue reading', 'estar' ) );
		$text .= the_title( ' <span class="screen-reader-text">', '</span>', false );
		return '&hellip;<p class="more"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . wp_kses_post( $text ) . '</a></p>';
	}

	public function change_excerpt_length( $length ) {
		return is_admin() ? $length : get_theme_mod( 'archive_excerpt_length', 55 );
	}

	public function change_archive_title( $title ) {
		if ( is_category() || is_tag() || is_tax() ) {
			$title = single_term_title( '', false );
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}
		return $title;
	}

	public static function get_thumbnail_size() {
		$sizes = [
			'list-horizontal' => 'post-thumbnail',
			'list-vertical'   => 'medium_large',
			'grid'            => 'estar-grid',
			'grid-card'       => 'estar-grid',
		];
		$layout = get_theme_mod( 'archive_content_layout', 'list-horizontal' );
		return $sizes[ $layout ];
	}
}