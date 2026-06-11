<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Helsinkiteema;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_filter( 'cmplz_known_script_tags', function( array $tags ): array {
	$tags[] = array(
		'name' => cmplz_integration_name(),
		'category' => 'statistics',
		'urls' => array(
			'wordpress-helfi-helsinkiteema/assets/vendor/askem/init.js'
		),
		'placeholder' => 'default',
		'placeholder_class' => 'rns',
		'enable_placeholder' => 1,
		'iframe' => 0,
		'enable_dependency' => 0,
		'dependency' => array(),
	);

	return $tags;
} );
