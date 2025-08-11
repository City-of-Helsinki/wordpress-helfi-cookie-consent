<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Remove_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'remove';
	}

	public function value(): mixed
	{
		return false;
	}
}
