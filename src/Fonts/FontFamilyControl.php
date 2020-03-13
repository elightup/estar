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
		$labels   = Fonts::get_labels();
		$input_id = "_customize-input-{$this->id}";
		?>

		<?php if ( ! empty( $this->label ) ) : ?>
			<label class="customize-control-title" for="<?= esc_attr( $input_id ) ?>"><?= esc_html( $this->label ); ?></label>
		<?php endif; ?>

		<select <?php $this->link(); ?> id="<?= esc_attr( $input_id ) ?>">
			<option value=""><?= esc_html( $labels['no_change'] ); ?></option>
			<optgroup label="<?= esc_attr( $labels['system_fonts'] ); ?>">
				<option value="sans-serif"<?php selected( $this->value(), 'sans-serif' ); ?>><?= esc_html( $labels['sans_serif'] ); ?></option>
				<option value="serif"<?php selected( $this->value(), 'serif' ); ?>><?= esc_html( $labels['serif'] ); ?></option>
			</optgroup>
			<optgroup label="<?= esc_attr( $labels['google_fonts'] ); ?>">
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
