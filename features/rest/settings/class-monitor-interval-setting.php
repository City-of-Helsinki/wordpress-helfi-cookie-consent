<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Monitor_Interval_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'monitorInterval';
	}

	public function value(): mixed
	{
		return 500;
	}
}
