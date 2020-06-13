wp.customize.sectionConstructor['estar-link'] = wp.customize.Section.extend( {
	// No events for this type of section.
	attachEvents: () => {},

	// Always make the section active.
	isContextuallyActive: () => true
} );
