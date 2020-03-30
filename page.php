<?php get_header() ?>

<main>
	<?php
	$breadcrumbs = new EStar\Breadcrumbs;
	echo wp_kses_post( $breadcrumbs->render() );

	the_post();
	get_template_part( 'template-parts/content/page' );

	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
	?>
</main>

<?php get_footer() ?>