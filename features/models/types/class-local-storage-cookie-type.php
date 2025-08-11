<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;

final class Local_Storage_Cookie_Type implements Cookie_Type
{
	public function name(): string
	{
		return 'localstorage';
	}

	public function label(): string
	{
		return __( 'localStorage', 'wordpress-helfi-cookie-consent' );
	}

	public function code(): int
	{
		return 2;
	}
}
