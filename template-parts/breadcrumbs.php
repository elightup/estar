<?php
$breadcrumbs = new EStar\Breadcrumbs;
echo wp_kses_post( $breadcrumbs->render() );