<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Views;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Consent_Views;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	$views = create_cookie_consent_views(
		\apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', null ),
		cookie_consent_views()
	);

	$views->setup();

	if ( $views ) {
		\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register_assets' );
	}
}

function register_assets(): void {
	$debug = \apply_filters( 'wordpress_helfi_cookie_consent_is_debug', '' );
	$url = \apply_filters( 'wordpress_helfi_cookie_consent_assets_url', '' );
	$version = \apply_filters( 'wordpress_helfi_cookie_consent_asset_version', '' );

	\wp_enqueue_style(
		'hel-cookie-consent',
		$url . 'css/consent.css',
		array(),
		$version,
		'all'
	);

	\wp_enqueue_script(
		'hel-cookie-consent-plan-b',
		$url . 'js/consent.js',
		array(),
		$version,
		array(
			'strategy' => 'defer',
			'in_footer' => true,
		)
	);

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

function cookie_consent_views(): array {
	return \apply_filters(
		'wordpress_helfi_cookie_consent_views',
		array()
	);
}

function create_cookie_consent_views( Cookie_Repository $repository, array $views ): Cookie_Consent_Views {
	return new Cookie_Consent_Views( $repository, $views );
}
