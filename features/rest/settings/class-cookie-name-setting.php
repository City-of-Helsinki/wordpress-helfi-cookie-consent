<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cookie_Name_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'cookieName';
	}

	public function value(): mixed
	{
		return 'helfi-cookie-consents';
	}
}
