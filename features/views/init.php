<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Views;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register_assets' );
	\add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\register_assets' );

	\add_filter(
		'wordpress_helfi_cookie_consent_settings_element_id',
		__NAMESPACE__ . '\\provide_settings_element_id'
	);
}

function provide_settings_element_id(): string {
	return 'hel-cookie-consent-settings';
}

function register_assets(): void {
	if ( ! \apply_filters( 'wordpress_helfi_cookie_consent_has_cookie_provider', false ) ) {
		return;
	}

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

	register_settings_element_inline_styles();
}

function register_settings_element_inline_styles(): void {
	\wp_register_style( 'hel-cookie-consent', false );
	\wp_enqueue_style( 'hel-cookie-consent' );

	\wp_add_inline_style(
		'hel-cookie-consent',
		sprintf(
			'body:not(.page) .helfi-consent-page-content {%s}',
			implode( ' ', array(
				'min-height: 100vh;',
				'margin: 0 auto max(3vw,50px);',
				'max-width: 1200px;',
				'width: 90%',
			) )
		)
	);
}
