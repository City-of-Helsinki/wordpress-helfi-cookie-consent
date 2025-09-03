<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category_Factory as Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type_Factory as Type_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories\Cookie_Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Types\Cookie_Type_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns\Unknown_Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns\Unknown_Cookie_Database;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init', 9 );
function init(): void {
	$current_language = \apply_filters(
		'wordpress_helfi_cookie_consent_current_language',
		'en'
	);

	$types = \apply_filters(
		'wordpress_helfi_cookie_consent_cookie_type_factory',
		create_cookie_type_factory( $current_language )
	);

	$categories = \apply_filters(
		'wordpress_helfi_cookie_consent_cookie_category_factory',
		create_cookie_category_factory( $current_language )
	);

	$repository = create_cookie_repository( array(
		'database' => \apply_filters(
			'wordpress_helfi_cookie_consent_cookie_database',
			create_unknown_cookie_database()
		),
		'factory' => \apply_filters(
			'wordpress_helfi_cookie_consent_cookie_adapter_factory',
			create_unknown_cookie_adapter_factory( array(
				'current_language' => $current_language,
				'categories' => $categories,
				'types' => $types,
			) ),
			$categories,
			$types,
			$current_language
		),
		'known_cookies' => known_cookies_data(
			\apply_filters(
				'wordpress_helfi_cookie_consent_known_cookies',
				array()
			)
		),
	) );

	\add_filter(
		'wordpress_helfi_cookie_consent_cookie_repository',
		fn() => $repository,
		1,
		1
	);
}

function create_cookie_repository( array $config ): Cookie_Repository {
	return new Cookie_Repository( ...$config );
}

function create_unknown_cookie_database(): Cookie_Database {
	return new Unknown_Cookie_Database();
}

function create_unknown_cookie_adapter_factory( array $config ): Cookie_Adapter_Factory {
	return new Unknown_Cookie_Adapter_Factory( ...$config );
}

function create_cookie_category_factory( string $current_language ): Category_Factory {
	return new Cookie_Category_Factory( $current_language, new Cache() );
}

function create_cookie_type_factory( string $current_language ): Type_Factory {
	return new Cookie_Type_Factory( $current_language, new Cache() );
}

function known_cookies_data( array $cookies ): Known_Cookies {
	return new Known_Cookies( $cookies );
}
