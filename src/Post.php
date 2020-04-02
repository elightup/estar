<?php
namespace EStar;

class Post {
	private $sanitizer;

	public function __construct( $sanitizer ) {
		$this->sanitizer = $sanitizer;

		add_action( 'customize_register', [ $this, 'register' ] );
		add_filter( 'body_class', [ $this, 'add_body_classes' ] );
		add_filter( 'post_class', [ $this, 'add_post_classes' ] );

		add_action( 'template_redirect', [ $this, 'add_hook_for_thumbnail' ] );
	}

	public function register( $wp_customize ) {
		$wp_customize->add_section( 'post', [
			'title'    => esc_html__( 'Post', 'estar' ),
			'priority' => '1300',
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

		$wp_customize->add_setting( 'post_thumbnail', [
			'sanitize_callback' => [ $this->sanitizer, 'sanitize_choice' ],
			'default'           => 'thumbnail-before-header',
		] );
		$wp_customize->add_control( 'post_thumbnail', [
			'label'   => esc_html__( 'Post Thumbnail', 'estar' ),
			'section' => 'post',
			'type'    => 'select',
			'choices' => [
				'thumbnail-header-background' => __( 'As Post Header Background', 'estar' ),
				'thumbnail-before-header'     => __( 'Before Post Header', 'estar' ),
				'thumbnail-after-header'      => __( 'After Post Header', 'estar' ),
				'no-thumbnail'                => __( 'Do not display', 'estar' ),
			],
		] );
	}

	public function add_body_classes( $classes ) {
		if ( ! is_single() ) {
			return $classes;
		}
		$classes[] = 'singular';
		$classes[] = get_theme_mod( 'post_layout', 'sidebar-right' );
		$classes[] = get_theme_mod( 'post_thumbnail', 'thumbnail-before-header' );
		return $classes;
	}

	public function add_post_classes( $classes ) {
		$classes[] = 'entry';
		return $classes;
	}

	public function add_hook_for_thumbnail() {
		if ( ! is_single() || ! has_post_thumbnail() ) {
			return;
		}
		$position = get_theme_mod( 'post_thumbnail', 'thumbnail-before-header' );
		if ( 'thumbnail-before-header' === $position ) {
			add_action( $hook, [ 'estar/entry_header/before', 'output_thumbnail' ] );
		} elseif ( 'thumbnail-after-header' === $position ) {
			add_action( $hook, [ 'estar/entry_header/after', 'output_thumbnail' ] );
		} elseif ( 'thumbnail-header-background' === $position ) {
			add_action( 'wp_head', [ $this, 'output_thumbnail_css' ] );
		}
	}

	public function output_thumbnail() {
		echo '<div class="entry-thumbnail">';
		the_post_thumbnail( 'full' );
		echo '</div>';
	}

	public function output_thumbnail_css() {
		?>
		<style>.entry-header { background-image: url(<?= esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>); }
		<?php
	}

	public static function date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo $time_string; // WPCS: OK.
	}

	public static function author() {
		$byline = sprintf(
			'<span class="author vcard">%s <a class="url fn n" href="%s">%s</a></span>',
			get_avatar( get_the_author_meta( 'user_email' ), 24 ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
		echo $byline; // WPCS: OK.
	}

	public static function categories() {
		the_category();
	}

	public static function tags() {
		$tags = get_the_tag_list( '', '' );
		if ( $tags ) {
			echo '<div class="tags">', $tags, '</div>'; // WPCS: OK.
		}
	}
}