<?php
namespace EStar;

class PostSettings {
	public function __construct() {
		add_filter( 'rwmb_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ], 99 );
		add_filter( 'estar_layout', [ $this, 'get_layout' ] );
		add_filter( 'estar_post_thumbnail_position', [ $this, 'get_post_thumbnail_position' ] );
		add_filter( 'estar_post_thumbnail_class', [ $this, 'get_post_thumbnail_class' ] );
		add_filter( 'estar_post_header_height', [ $this, 'get_post_header_height' ] );
	}

	public function register_meta_boxes( $meta_boxes ) {
		$post_types = get_post_types( ['public' => true] );

		// Do not add settings for attachment and WooCommerce products.
		$post_types = array_diff( $post_types, ['attachment', 'product'] );

		$meta_boxes[] = [
			'title'      => __( 'Settings', 'estar' ),
			'id'         => 'estar-page-settings',
			'post_types' => $post_types,
			'context'    => 'side',
			'priority'   => 'low',
			'fields'     => [
				[
					'type' => 'custom_html',
					'std' => esc_html__( 'Note: These options will override page template settings and theme options in the Customizer.', 'estar' ),
				],
				[
					'name'    => esc_html__( 'Layout', 'estar' ),
					'id'      => 'layout',
					'type'    => 'select',
					'options' => [
						''              => esc_html__( 'Default', 'estar' ),
						'sidebar-left'  => esc_html__( 'Sidebar Left', 'estar' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'estar' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'estar' ),
					],
				],
				[
					'name'    => esc_html__( 'Content Width', 'estar' ),
					'id'      => 'content_width',
					'type'    => 'select',
					'desc'    => esc_html__( 'Works only when the layout is no sidebar.', 'estar' ),
					'options' => [
						''       => esc_html__( 'Default', 'estar' ),
						'narrow' => esc_html__( 'Narrow', 'estar' ),
						'wide'   => esc_html__( 'Wide', 'estar' ),
						'full'   => esc_html__( 'Full Width', 'estar' ),
					],
				],
				[
					'name'    => esc_html__( 'Sticky Header', 'estar' ),
					'id'      => 'header_sticky',
					'type'    => 'select',
					'options' => [
						''  => esc_html__( 'Default', 'estar' ),
						'1' => esc_html__( 'Yes', 'estar' ),
						'0' => esc_html__( 'No', 'estar' ),
					],
				],
				[
					'name'    => esc_html__( 'Thumbnail Position', 'estar' ),
					'id'      => 'thumbnail_position',
					'type'    => 'select',
					'options' => [
						''                            => __( 'Default', 'estar' ),
						'thumbnail-header-background' => __( 'As Header Background', 'estar' ),
						'thumbnail-before-header'     => __( 'Before Header', 'estar' ),
						'thumbnail-after-header'      => __( 'After Header', 'estar' ),
						'no-thumbnail'                => __( 'Do Not Display', 'estar' ),
					],
				],
				[
					'name'    => esc_html__( 'Header Alignment', 'estar' ),
					'id'      => 'post_header_align',
					'type'    => 'select',
					'options' => [
						''       => __( 'Default', 'estar' ),
						'left'   => __( 'Left', 'estar' ),
						'right'  => __( 'Right', 'estar' ),
						'center' => __( 'Center', 'estar' ),
					],
				],
				[
					'name'        => esc_html__( 'Header Height', 'estar' ),
					'id'          => 'post_header_height',
					'type'        => 'number',
					'size'        => 6,
					'append'      => 'px',
					'description' => esc_html__( 'Works only when the thumbnail is set as header background.', 'estar' ),
				],
				[
					'name'    => esc_html__( 'Transparent Header', 'estar' ),
					'id'      => 'header_transparent',
					'desc'    => esc_html__( 'Works only when the thumbnail is set as header background.', 'estar' ),
					'type'    => 'select',
					'options' => [
						''  => esc_html__( 'Default', 'estar' ),
						'1' => esc_html__( 'Yes', 'estar' ),
						'0' => esc_html__( 'No', 'estar' ),
					],
				],
			],
		];

		return $meta_boxes;
	}

	public function add_body_classes( $classes ) {
		if ( ! is_singular() || is_singular( ['attachment', 'product'] ) ) {
			return $classes;
		}

		$content_width = rwmb_meta( 'content_width' );
		if ( $content_width ) {
			$classes[] = esc_attr( "content-$content_width" );
		}

		$header_sticky = rwmb_meta( 'header_sticky' );
		if ( '1' === $header_sticky ) {
			$classes[] = 'header-sticky';
		} elseif ( '0' === $header_sticky ) {
			$classes = array_diff( $classes, ['header-sticky'] );
		}

		$header_transparent = rwmb_meta( 'header_transparent' );
		if ( '1' === $header_transparent ) {
			$classes[] = 'header-transparent';
		} elseif ( '0' === $header_transparent ) {
			$classes = array_diff( $classes, ['header-transparent'] );
		}

		$align = rwmb_meta( 'post_header_align' );
		if ( $align ) {
			$classes = array_diff( $classes, ['entry-header-left', 'entry-header-right', 'entry-header-center'] );
			$classes[] = esc_attr( "entry-header-$align" );
		}

		$classes = array_unique( array_filter( $classes ) );

		return $classes;
	}

	public function get_layout( $layout ) {
		if ( ! is_singular() || is_singular( ['attachment', 'product'] ) ) {
			return $layout;
		}
		$settings = rwmb_meta( 'layout' );
		if ( $settings ) {
			$layout = $settings;
		}
		return $layout;
	}

	public function get_post_thumbnail_position( $position ) {
		$settings = rwmb_meta( 'thumbnail_position' );
		if ( $settings ) {
			$position = $settings;
		}
		return $position;
	}

	public function get_post_thumbnail_class( $class ) {
		$settings = rwmb_meta( 'content_width' );
		if ( 'full' === $settings ) {
			$class = 'alignfull';
		}
		return $class;
	}

	public function get_post_header_height( $height ) {
		$settings = rwmb_meta( 'post_header_height' );
		if ( $settings ) {
			$height = $settings;
		}
		return $height;
	}
}