<?php
namespace EStar\Customizer\Controls;

class Heading extends \WP_Customize_Control {
	public $type = 'estar-heading';

	public function enqueue() {
		wp_enqueue_style( 'estar-heading', get_template_directory_uri() . '/src/Customizer/assets/heading.css', [], '1.0.0' );
	}

	protected function render_content() {
		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
		<?php
	}
}