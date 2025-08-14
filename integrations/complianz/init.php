<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type_Factory;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init', 5 );
function init(): void {
	if ( is_complianz_active() ) {
		\add_filter( 'cmplz_document_comment', '__return_empty_string' );
		\add_filter( 'cmplz_banner_html', '__return_empty_string', 9999 );
		\add_filter( 'cmplz_template_file', __NAMESPACE__ . '\\disable_default_cookiebanner', 9999, 2 );

		\add_filter(
			'wordpress_helfi_cookie_consent_cookie_database',
			__NAMESPACE__ . '\\provide_cookie_database',
			10,
			1
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_cookie_adapter_factory',
			__NAMESPACE__ . '\\provide_cookie_adapter_factory',
			10,
			3
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_cookies_handler',
			fn() => 'complianz',
			10,
			1
		);
	}
}

function is_complianz_active(): bool {
	return class_exists( 'COMPLIANZ' );
}

function provide_cookie_database( ?Cookie_Database $database ): Complianz_Cookie_Database {
	static $adapter;

	if ( empty( $adapter ) ) {
		global $wpdb;
		$adapter = new Complianz_Cookie_Database( $wpdb );
	}

	return $adapter;
}

function provide_cookie_adapter_factory(
	?Cookie_Adapter_Factory $factory,
	Cookie_Category_Factory $categories,
	Cookie_Type_Factory $types
	): Complianz_Cookie_Adapter_Factory {
	static $adapter;

	if ( empty( $adapter ) ) {
		$adapter = new Complianz_Cookie_Adapter_Factory(
			\apply_filters(
				'wordpress_helfi_cookie_consent_current_language',
				'en'
			),
			$categories,
			$types
		);
	}

	return $adapter;
}

function disable_default_cookiebanner( string $path, string $file_name ): string {
	return 'cookiebanner.php' === $file_name ? '' : $path;
}
