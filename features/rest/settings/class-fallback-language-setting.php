<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Fallback_Language_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'fallbackLanguage';
	}

	public function value(): mixed
	{
		return 'en';
	}
}
