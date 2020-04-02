<?php
/**
 * Checkbox list control.
 *
 * @link http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
 */
namespace EStar\Fonts;

class CheckboxListControl extends \WP_Customize_Control {
	public $type = 'estar-checkbox-list';

	public function render_content() {
		if ( empty( $this->choices ) )
			return;
		?>

		<?php if ( !empty( $this->label ) ) : ?>
			<label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
		<?php endif; ?>

		<?php
		$value = $this->value();
		$values = is_array( $value ) ? $value : explode( ',', $value );
		?>
		<ul>
			<?php foreach ( $this->choices as $value => $label ) : ?>
				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $values ) ); ?>>
						<?php echo esc_html( $label ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
		<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $values ) ); ?>">
	<?php }
}