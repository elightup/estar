<?php
namespace EStar;

class Sanitizer {
	public function sanitize_checkbox( $checked ) {
		return isset( $checked ) && true == $checked;
	}

	public function sanitize_css( $css ) {
		return wp_strip_all_tags( $css );
	}

	public function sanitize_dropdown_pages( $page_id, $setting ) {
		$page_id = absint( $page_id );

		// If $page_id is an ID of a published page, return it; otherwise, return the default.
		return 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default;
	}

	public function sanitize_email( $email, $setting ) {
		$email = sanitize_email( $email );
		return ! is_null( $email ) ? $email : $setting->default;
	}

	public function sanitize_hex_color( $hex_color, $setting ) {
		$hex_color = sanitize_hex_color( $hex_color );
		return ! is_null( $hex_color ) ? $hex_color : $setting->default;
	}

	public function sanitize_html( $html ) {
		return wp_filter_post_kses( $html );
	}

	public function sanitize_image( $image, $setting ) {
	    $mimes = array(
	        'jpg|jpeg|jpe' => 'image/jpeg',
	        'gif'          => 'image/gif',
	        'png'          => 'image/png',
	        'bmp'          => 'image/bmp',
	        'tif|tiff'     => 'image/tiff',
	        'ico'          => 'image/x-icon'
	    );

		// Return an array with file extension and mime_type.
	    $file = wp_check_filetype( $image, $mimes );

	    return $file['ext'] ? $image : $setting->default;
	}

	public function sanitize_nohtml( $nohtml ) {
		return wp_filter_nohtml_kses( $nohtml );
	}

	public function sanitize_number_absint( $number, $setting ) {
		$number = absint( $number );
		return $number ? $number : $setting->default;
	}

	public function sanitize_number_range( $number, $setting ) {
		$number = absint( $number );
		$atts   = $setting->manager->get_control( $setting->id )->input_attrs;
		$min    = isset( $atts['min'] ) ? $atts['min'] : $number;
		$max    = isset( $atts['max'] ) ? $atts['max'] : $number;
		$step   = isset( $atts['step'] ) ? $atts['step'] : 1;
		return $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default;
	}

	public function sanitize_select( $input, $setting ) {
		$input = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return array_key_exists( $input, $choices ) ? $input : $setting->default;
	}

	public function sanitize_url( $url ) {
		return esc_url_raw( $url );
	}

	public function sanitize_svg( $svg ) {
		return wp_kses( $svg, SVG::get_allowed_tags() );
	}
}