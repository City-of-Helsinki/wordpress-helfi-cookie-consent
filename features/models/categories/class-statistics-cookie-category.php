<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;

final class Statistics_Cookie_Category implements Cookie_Category
{
	public function name(): string
	{
		return 'statistics';
	}

	public function label(): string
	{
		return __( 'Statistics', 'wordpress-helfi-cookie-consent' );
	}

	public function description(): string
	{
		return __( 'Statistics description.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return false;
	}
}
