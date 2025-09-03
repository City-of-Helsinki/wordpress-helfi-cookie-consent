<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Cookie_Category
{
	public function name(): string;
	public function label( string $language = '' ): string;
	public function description( string $language = '' ): string;
	public function required(): bool;
}
