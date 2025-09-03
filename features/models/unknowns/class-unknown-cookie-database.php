<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;

final class Unknown_Cookie_Database implements Cookie_Database
{
	public function cookies(): array
	{
		return array();
	}
}
