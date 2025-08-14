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
		\add_filter( 'cmplz_document_html', __NAMESPACE__ . '\\replace_cookie_statement', 99999, 3 );

		\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\disable_complianz_styles', PHP_INT_MAX - 49 );
		\remove_action( 'wp_footer', array( \cmplz_banner_loader::this(), 'cookiebanner_html' ) );

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
			4
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
	Cookie_Type_Factory $types,
	string $current_language
	): Complianz_Cookie_Adapter_Factory {
	return new Complianz_Cookie_Adapter_Factory(
		$current_language,
		$categories,
		$types
	);
}

function replace_cookie_statement( string $html, string $type, int $post_id ): string {
	if ( 'cookie-statement' !== $type ) {
		return $html;
	}

	$id = \apply_filters( 'wordpress_helfi_cookie_consent_settings_element_id', '' );

	return $id ? sprintf( '<div id="%s"></div>', \esc_attr( $id ) ) : '';
}

function disable_complianz_styles(): void {
	\wp_dequeue_style( 'cmplz-cookie' );
	\wp_dequeue_style( 'cmplz-document' );
	\wp_dequeue_style( 'cmplz-document-grid' );

	\add_filter( 'cmplz_custom_document_css', '__return_empty_string' );
}
