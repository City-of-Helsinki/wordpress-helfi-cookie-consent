<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Views;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register_assets' );
}

function register_assets(): void {
	$debug = \apply_filters( 'wordpress_helfi_cookie_consent_is_debug', '' );
	$url = \apply_filters( 'wordpress_helfi_cookie_consent_assets_url', '' );
	$version = \apply_filters( 'wordpress_helfi_cookie_consent_asset_version', '' );

	\wp_enqueue_script(
		'hel-cookie-consent-vendor',
		$url . 'public/js/' . ( $debug ? 'vendor.js' : 'vendor.min.js' ),
		array(),
		$version,
		array(
			'strategy' => 'defer',
			'in_footer' => true,
		)
	);

	\wp_enqueue_script(
		'hel-cookie-consent',
		$url . 'public/js/' . ( $debug ? 'scripts.js' : 'scripts.min.js' ),
		array( 'hel-cookie-consent-vendor' ),
		$version,
		array(
			'strategy' => 'defer',
			'in_footer' => true,
		)
	);
}
