<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Site_Name_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'siteName';
	}

	public function value(): mixed
	{
		return ucfirst(
			parse_url(
				\get_home_url( path: '/' ),
				PHP_URL_HOST
			)
		);
	}
}
