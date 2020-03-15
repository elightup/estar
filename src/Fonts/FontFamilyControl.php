<?php
/**
 * Custom control for font family.
 */
namespace EStar\Fonts;

class FontFamilyControl extends \WP_Customize_Control {
	public $type = 'estar-font-family';

	/**
	 * Render the control's content.
	 * Allows the content to be overridden without having to rewrite the wrapper.
	 */
	protected function render_content() {
		$input_id = "_customize-input-{$this->id}";
		?>

		<?php if ( ! empty( $this->label ) ) : ?>
			<label class="customize-control-title" for="<?= esc_attr( $input_id ) ?>"><?= esc_html( $this->label ); ?></label>
		<?php endif; ?>

		<select <?php $this->link(); ?> id="<?= esc_attr( $input_id ) ?>">
			<option value=""><?php esc_html_e( '- No change -', 'estar' ); ?></option>
			<optgroup label="<?php esc_attr_e( 'System Fonts', 'estar' ); ?>">
				<option value="sans-serif"<?php selected( $this->value(), 'sans-serif' ); ?>><?php esc_html_e( 'Sans Serif', 'estar' ); ?></option>
				<option value="serif"<?php selected( $this->value(), 'serif' ); ?>><?php esc_html_e( 'Serif', 'estar' ); ?></option>
			</optgroup>
			<optgroup label="<?php esc_attr_e( 'Google Fonts', 'estar' ); ?>">
				<?php
				$fonts = include __DIR__ . '/fonts.php';
				foreach ( $fonts as $font ) {
					printf(
						'<option value="%s"%s data-styles="%s">%s</option>',
						esc_attr( $font['family'] ),
						selected( $this->value(), $font['family'], false ),
						esc_attr( implode( ',', $font['variants'] ) ),
						esc_html( $font['family'] )
					);
				}
				?>
			</optgroup>
		</select>
		<?php
	}
}
