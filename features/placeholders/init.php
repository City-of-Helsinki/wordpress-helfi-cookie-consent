<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Content\Iframe_Placeholder;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Content\Script_Placeholder;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Enums\Placeholder_Type;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_filter(
		'wordpress_helfi_cookie_consent_iframe_placeholder',
		__NAMESPACE__ . '\\render_iframe_placeholder',
		10, 2
	);

	\add_filter(
		'wordpress_helfi_cookie_consent_script_placeholder',
		__NAMESPACE__ . '\\render_script_placeholder',
		10, 2
	);
};

function determine_categories_provider( Placeholder_Type $type, string $source ): string {
	return \apply_filters(
		"wordpress_helfi_cookie_consent_{$type->value}_placeholder_cookie_host",
		parse_url( $source, PHP_URL_HOST ),
		$source
	);
}

function determine_categories( Placeholder_Type $type, string $source ): array {
	$provider = determine_categories_provider( $type, $source );

	$cookies = \apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', null );
	$categories = $cookies->provider_categories() ?: array();

	return \apply_filters(
		"wordpress_helfi_cookie_consent_{$type->value}_placeholder_cookie_categories",
		array_values( $categories[$provider] ?? array() ),
		$provider,
		$categories
	);
}

function placeholder_categories( Placeholder_Type $type, string $source ): Placeholder_Categories {
	$categories = determine_categories( $type, $source );

	return new Placeholder_Categories( ...$categories );
}

function create_placeholder( Placeholder_Content $content ): Placeholder {
	return new Placeholder( $content );
}

function render_script_placeholder( string $html, string $source ): string {
	$categories = placeholder_categories( Placeholder_Type::SCRIPT, $source );

	if ( $categories->list() ) {
		$config = create_placeholder_content_config(
			Placeholder_Type::SCRIPT,
			$categories,
			$source
		);

		return create_placeholder( new Script_Placeholder( $config ) )->render();
	}

	return $html;
}

function render_iframe_placeholder( string $html, string $source ): string {
	$categories = placeholder_categories( Placeholder_Type::IFRAME, $source );

	if ( $categories->list() ) {
		$config = create_placeholder_content_config(
			Placeholder_Type::IFRAME,
			$categories,
			$source
		);

		return create_placeholder( new Iframe_Placeholder( $config ) )->render();
	}

	return $html;
}

function create_placeholder_content_config(
	Placeholder_Type $type,
	Placeholder_Categories $categories,
	string $source
): Placeholder_Content_Config {
	return new Placeholder_Content_Config(
		$type,
		$categories,
		$source,
		'alert-circle-fill'
	);
}
