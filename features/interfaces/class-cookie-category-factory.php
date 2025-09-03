<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Cookie_Category_Factory
{
	public function from_string( string $name ): Cookie_Category;
}
