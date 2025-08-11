<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;

final class Marketing_Cookie_Category implements Cookie_Category
{
	public function name(): string
	{
		return 'marketing';
	}

	public function label(): string
	{
		return __( 'Marketing', 'wordpress-helfi-cookie-consent' );
	}

	public function description(): string
	{
		return __( 'Marketing description.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return false;
	}
}
