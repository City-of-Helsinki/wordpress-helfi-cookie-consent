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

		\remove_action( 'wp_head', array( \cmplz_banner_loader::this(), 'cookiebanner_css' ) );
		\remove_action( 'wp_footer', array( \cmplz_banner_loader::this(), 'cookiebanner_html' ) );

		\add_filter(
			'cmplz_cookiebanner_settings',
			__NAMESPACE__ . '\\provide_cmplz_cookiebanner_settings',
			10, 2
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_cookie_database',
			__NAMESPACE__ . '\\provide_cookie_database',
			10, 1
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_cookie_adapter_factory',
			__NAMESPACE__ . '\\provide_cookie_adapter_factory',
			10, 4
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_cookies_handler',
			fn() => 'complianz',
			10, 1
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_rest_settings',
			__NAMESPACE__ . '\\filter_rest_settings',
			10, 1
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_has_cookie_provider',
			'__return_true'
		);
	}
}

\add_filter( 'wordpress_helfi_cookie_consent_known_cookies', __NAMESPACE__ . '\\provide_cookies' );
function provide_cookies( array $cookies ): array {
	if ( is_complianz_active() ) {
		$cookies = array_merge( $cookies, array(
			Cookies\Cmplz_Functional::class,
			Cookies\Cmplz_Marketing::class,
			Cookies\Cmplz_Preferences::class,
			Cookies\Cmplz_Statistics::class,
			Cookies\Cmplz_Unknown::class,
			Cookies\Cmplz_Policy_Id::class,
			Cookies\Cmplz_Banner_Status::class,
		) );
	}

	return $cookies;
}

\add_filter( 'wordpress_helfi_cookie_consent_cmplz_expiry_days', __NAMESPACE__ . '\\provide_cmplz_expiry_days' );
function provide_cmplz_expiry_days( int $days ): int {
	$expiry = \cmplz_get_option( 'cookie_expiry' );

	return is_numeric( $expiry ) ? (int) $expiry : $days;
}

function is_complianz_active(): bool {
	return class_exists( 'COMPLIANZ' );
}

function provide_cookie_database( ?Cookie_Database $database ): Complianz_Cookie_Database {
	global $wpdb;

	return new Complianz_Cookie_Database( $wpdb );
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

function filter_rest_settings( array $settings ): array {
	$settings['groupsWhitelistedForApi'] = array_unique(
		array_merge(
			$settings['groupsWhitelistedForApi'] ?? [],
			array( 'functional', 'preferences', 'statistics', 'marketing' )
		)
	);

	return $settings;
}

function provide_cmplz_cookiebanner_settings( array $settings, $banner ): array {
	$repository = \apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', null );

	if ( $repository ) {
		$current_language = \apply_filters(
			'wordpress_helfi_cookie_consent_current_language',
			'en'
		);

		$categories = array_reduce(
			$repository->cookie_lists()->all(),
			function( $categories, $cookie_list ) use ( $current_language ) {
				$categories[$cookie_list->name()] = $cookie_list->label( $current_language );

				return $categories;
			},
			array()
		);

		if ( $categories ) {
			$settings['categories'] = $categories;
		}
	}

	return $settings;
}
