<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {

	\add_filter(
		'wordpress_helfi_cookie_consent_iframe_placeholder',
		__NAMESPACE__ . '\\render_iframe_placeholder',
		10, 2
	);

};

function render_iframe_placeholder( string $html, string $source ): string {
	$provider = iframe_placeholder_cookie_host( $source );
	if ( ! $provider ) {
		return $html;
	}

	$categories = iframe_placeholder_categories( $provider );
	if ( ! $categories ) {
		return $html;
	}

	return (new Placeholder( $source, ...$categories ))->render();
}

function iframe_placeholder_cookie_host( string $source ): string {
	return \apply_filters(
		'wordpress_helfi_cookie_consent_iframe_placeholder_cookie_host',
		parse_url( $source, PHP_URL_HOST )
	);
}

function iframe_placeholder_categories( string $provider ): array {
	$cookies = \apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', null );
	$categories = $cookies?->provider_categories() ?: array();

	return \apply_filters(
		'wordpress_helfi_cookie_consent_iframe_placeholder_cookie_categories',
		array_values( $categories[$provider] ?? array() ),
		$provider,
		$categories
	);
}
