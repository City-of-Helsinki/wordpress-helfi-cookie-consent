<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;

final class Functional_Cookie_Category implements Cookie_Category
{
	public function name(): string
	{
		return 'functional';
	}

	public function label(): string
	{
		return __( 'Functional', 'wordpress-helfi-cookie-consent' );
	}

	public function description(): string
	{
		return __( 'Functional description.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return true;
	}
}
