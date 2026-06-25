<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Content\Iframe_Placeholder;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {

	\add_filter(
		'wordpress_helfi_cookie_consent_iframe_placeholder',
		__NAMESPACE__ . '\\render_iframe_placeholder',
		10, 2
	);

};

function create_placeholder( Placeholder_Content $content ): Placeholder {
	return new Placeholder( $content );
}

function render_iframe_placeholder( string $html, string $source ): string {
	$provider = iframe_placeholder_cookie_host( $source );
	if ( ! $provider ) {
		return $html;
	}

	$categories = iframe_placeholder_categories( $provider );
	if ( ! $categories ) {
		return $html;
	}

	return create_placeholder(new Iframe_Placeholder( $source, ...$categories ))
		->render();
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
