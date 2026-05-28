<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Maps;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_filter( 'cmplz_known_script_tags', function( array $tags ): array {
	$tags[] = array(
		'name' => palvelukartta_hel_fi_integration(),
		'category' => 'preferences',
		'urls' => array( 'palvelukartta.hel.fi' ),
		'placeholder' => 'googlemaps',
		'enable_placeholder' => 1,
		'iframe' => 1,
		'enable_dependency' => 0,
		'dependency' => array(),
	);

	return $tags;
} );
