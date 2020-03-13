jQuery( function ( $ ) {
	'use strict';

	function updateFontStyle() {
		let styles = $( this ).find( 'option:selected' ).data( 'styles' ),
			$options = $( this ).closest( '.customize-control' ).next().find( 'option' );

		if ( ! styles ) {
			return;
		}

		styles = styles.toString().split( ',' );
		$options.prop( 'selected', false ).show();

		// Hide unmatched styles.
		$options.filter( function ( index ) {
			return index && - 1 === $.inArray( this.value, styles );
		} ).hide();

		// Reset the selection to "No change".
		$options.first().prop( 'selected', true );
	}

	function updateCheckboxListValue() {
		const $control = $( this ).closest( '.customize-control' );
		const values = $control.find( 'input[type="checkbox"]:checked' ).map( function() {
			return this.value;
		} ).get().join( ',' );

		$control.find( 'input[type="hidden"]' ).val( values ).trigger( 'change' );
	}

	$( document )
		.on( 'change', '.customize-control-estar-font-family select', updateFontStyle )
		.on( 'change', '.customize-control-estar-checkbox-list input[type="checkbox"]', updateCheckboxListValue );
} );
