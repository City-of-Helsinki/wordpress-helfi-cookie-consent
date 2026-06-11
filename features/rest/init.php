<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_action( 'rest_api_init', __NAMESPACE__ . '\\register_routes' );
	\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\register_rest_config' );
	\add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\register_rest_config' );
}

function register_routes(): void {
	$repository = \apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', null );
	$namespace = route_namespace();

	foreach ( routes() as $name => $config ) {
		$controller = new $config['controller'](
			new Rest_Controller_Config( ...array(
				'namespace' => $namespace,
				'name' => $name,
				'version' => $config['version'],
				'cookie_repository' => $repository,
			) )
		);

		$controller->register_routes();
	}
}

function register_rest_config(): void {
	\wp_add_inline_script(
		'hel-cookie-consent',
		sprintf(
			'const HelfiCookieConsent = %s;',
			json_encode( rest_config() )
		),
		'before'
	);
}

function rest_config(): array {
	$config = array(
		'routes' => array(),
		'options' => array(
			'language' => \esc_attr( current_language() ),
			'settingsPageSelector' => \esc_attr( settings_element_id() ),
			'submitEvent' => true,
		),
		'cookiesHandler' => \esc_attr( cookies_handler() ),
	);

	$namespace = route_namespace();
	foreach ( routes() as $name => $route ) {
		$config['routes'][$name] = \esc_url_raw(
			\get_rest_url( path: sprintf(
				'%s/v%d/%s',
				$namespace,
				$route['version'],
				$name
			) )
		);
	}

	return $config;
}

function settings_element_id(): string {
	$id = \apply_filters( 'wordpress_helfi_cookie_consent_settings_element_id', '' );

	return $id ? '#' . $id : '';
}

function cookies_handler(): string {
	return \apply_filters( 'wordpress_helfi_cookie_consent_cookies_handler', '' );
}

function current_language(): string {
	return \apply_filters( 'wordpress_helfi_cookie_consent_current_language', 'en' );
}

function route_namespace(): string {
	return 'helfi-cookie-consent';
}

function routes(): array {
	return array(
		'settings' => array(
			'controller' => Settings_Rest_Controller::class,
			'version' => 1,
		),
	);
}
