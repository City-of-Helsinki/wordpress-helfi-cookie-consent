<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;

class Robot_Cookies_Setting implements Setting_Interface
{
	public function __construct(
		private Cookie_Repository $repository
	) {}

	public function name(): string
	{
		return 'robotCookies';
	}

	public function value(): mixed
	{
		return array();
	}
}
