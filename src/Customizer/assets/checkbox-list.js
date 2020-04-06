jQuery( function ( $ ) {
	'use strict';

	function updateCheckboxListValue() {
		const $control = $( this ).closest( '.customize-control' );
		const values = $control.find( 'input[type="checkbox"]:checked' ).map( function() {
			return this.value;
		} ).get().join( ',' );

		$control.find( 'input[type="hidden"]' ).val( values ).trigger( 'change' );
	}

	$( document )
		.on( 'change', '.customize-control-estar-checkbox-list input[type="checkbox"]', updateCheckboxListValue );
} );
