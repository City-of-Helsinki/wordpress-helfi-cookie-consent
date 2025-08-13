<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Cookie_Type
{
	public function name(): string;
	public function label( string $language = '' ): string;
	public function code(): int;
}
