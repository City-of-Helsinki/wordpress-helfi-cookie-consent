<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;

final class Indexed_Db_Cookie_Type implements Cookie_Type
{
	public function name(): string
	{
		return 'indexeddb';
	}

	public function label(): string
	{
		return __( 'IndexedDB', 'wordpress-helfi-cookie-consent' );
	}

	public function code(): int
	{
		return 4;
	}
}
