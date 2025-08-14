<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Setting_Interface;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Cookie_Name_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Fallback_Language_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Groups_Whitelisted_For_Api_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Languages_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Monitor_Interval_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Optional_Groups_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Remove_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Required_Groups_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Robot_Cookies_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Site_Name_Setting;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Translations_Setting;
use WP_Error;
use WP_REST_Response;
use WP_REST_Request;
use WP_REST_Server;

final class Settings_Rest_Controller
{
	public function __construct(
		private Rest_Controller_Config $config
	) {}

	public function register_routes(): void
	{
		\register_rest_route(
			sprintf( '%s/v%d', $this->config->namespace, $this->config->version ),
			'/' . $this->config->name,
			array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => array( $this, 'get_settings' ),
				'permission_callback' => array( $this, 'get_settings_permissions' ),
			)
		);
	}

	public function get_settings_permissions( WP_REST_Request $request ): bool
	{
		return true;
	}

	public function get_settings( WP_REST_Request $request ): WP_REST_Response|WP_Error
	{
		$settings = \apply_filters(
			'wordpress_helfi_cookie_consent_rest_settings',
			array_reduce(
				$this->create_settings(),
				function( array $settings, Setting_Interface $setting ) {
					$settings[$setting->name()] = $setting->value();

					return $settings;
				},
				array()
			)
		);

		return \rest_ensure_response( $settings );
	}

	private function requestLanguage( WP_REST_Request $request ): string
	{
		return $request->get_param( 'lang' )
			?: \apply_filters(
				'wordpress_helfi_cookie_consent_current_language',
				'en'
			);
	}

	private function create_settings(): array
	{
		return array_map(
			fn( string $settingClass ) => new $settingClass( $this->config->cookie_repository ),
			array(
				Cookie_Name_Setting::class,
				Fallback_Language_Setting::class,
				Groups_Whitelisted_For_Api_Setting::class,
				Languages_Setting::class,
				Monitor_Interval_Setting::class,
				Optional_Groups_Setting::class,
				Remove_Setting::class,
				Required_Groups_Setting::class,
				Robot_Cookies_Setting::class,
				Site_Name_Setting::class,
				Translations_Setting::class,
			)
		);
	}

	private function settings_languages(): array
	{
		return array();
	}
}
