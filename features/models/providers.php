<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category_Factory as Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Consent_View;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type_Factory as Type_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories\Cookie_Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Types\Cookie_Type_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns\Unknown_Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns\Unknown_Cookie_Database;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init', 9 );
function init(): void {
	$repository = default_cookie_repository();

	\add_filter(
		'wordpress_helfi_cookie_consent_cookie_repository',
		fn() => $repository,
		1,
		1
	);
}

function default_cookie_repository(): Cookie_Repository {
	return create_cookie_repository(
		create_cookie_database(),
		create_cookie_adapter_factory(
			create_cookie_category_factory(),
			create_cookie_type_factory()
		)
	);
}

function create_cookie_repository( Cookie_Database $database, Cookie_Adapter_Factory $factory ): Cookie_Repository {
	return new Cookie_Repository( $database, $factory );
}

function create_cookie_database(): Cookie_Database {
	static $default;

	$database = \apply_filters(
		'wordpress_helfi_cookie_consent_cookie_database',
		null
	);

	if ( $database ) {
		return $database;
	}

	if ( empty( $default ) ) {
		$default = new Unknown_Cookie_Database();
	}

	return $default;
}

function create_cookie_adapter_factory( Category_Factory $categories, Type_Factory $types ): Cookie_Adapter_Factory {
	static $default;

	$factory = \apply_filters(
		'wordpress_helfi_cookie_consent_cookie_adapter_factory',
		null,
		$categories,
		$types
	);

	if ( $factory ) {
		return $factory;
	}

	if ( empty( $default ) ) {
		$default = new Unknown_Cookie_Adapter_Factory( $categories, $types );
	}

	return $default;
}

function create_cookie_category_factory(): Category_Factory {
	static $factory = new Cookie_Category_Factory(
		\apply_filters(
			'wordpress_helfi_cookie_consent_current_language',
			'en'
		),
		new Cache()
	);

	return \apply_filters(
		'wordpress_helfi_cookie_consent_cookie_category_factory',
		$factory
	);
}

function create_cookie_type_factory(): Type_Factory {
	static $factory = new Cookie_Type_Factory(
		\apply_filters(
			'wordpress_helfi_cookie_consent_current_language',
			'en'
		),
		new Cache()
	);

	return \apply_filters(
		'wordpress_helfi_cookie_consent_cookie_type_factory',
		$factory
	);
}
