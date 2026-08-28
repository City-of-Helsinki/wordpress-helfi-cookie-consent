<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\HDS_Cookie_Consent;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\Helfi_Load_Balancer;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\Comment_Author_Email;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\Comment_Author_Url;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\Comment_Author;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WordPress_Logged_In;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WordPress_Sec;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WordPress_Test_Cookie;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Api_Schema_Model;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Autosave;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Data_User;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Lang;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Postpass;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Preferences_User;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Saving_Post;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Settings_Time;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress\WP_Settings;
use Closure;

final class Known_Cookies
{
	private Closure $callback;

	public function __construct(
		callable $callback
	) {
		$this->callback = Closure::fromCallable( $callback );
	}

	public function list(): array
	{
		return array_map(
			array( $this, 'to_cookie_data' ),
			$this->get_cookies()
		);
	}

	private function get_cookies(): array
	{
		return array_values(
		    array_unique(
		        array_merge(
		            $this->default_cookies(),
		            call_user_func( $this->callback )
		        )
		    )
		);
	}

	private function to_cookie_data( string $cookie ): Known_Cookie_Data
	{
		return new $cookie();
	}

	private function default_cookies(): array
	{
		$cookies = array(
			Helfi_Load_Balancer::class,
			HDS_Cookie_Consent::class,
			WordPress_Test_Cookie::class,
			WP_Postpass::class,
			WP_Lang::class,
			WordPress_Logged_In::class,
			WordPress_Sec::class,
			WP_Api_Schema_Model::class,
			WP_Data_User::class,
			WP_Preferences_User::class,
			WP_Settings_Time::class,
			WP_Settings::class,
			WP_Autosave::class,
			WP_Saving_Post::class,
		);

		if ( \apply_filters( 'wordpress_helfi_cookie_consent_comments_enabled', false ) ) {
			$cookies[] = Comment_Author_Email::class;
			$cookies[] = Comment_Author_Url::class;
			$cookies[] = Comment_Author::class;
		}

		return $cookies;
	}
}
