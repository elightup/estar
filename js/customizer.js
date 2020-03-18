( function ( document, $, api ) {
	// List of text elements that have postMessage transport.
	var texts = {
		blogname: '.site-title a',
		blogdescription: '.site-description',
		footer_copyright: '.site-info'
	};

	// Live update the text elements.
	Object.entries( texts ).forEach( ( [setting, selector] ) => api( setting, value => value.bind( to => document.querySelector( selector ).innerHTML = to ) ) );
} )( document, jQuery, wp.customize );
