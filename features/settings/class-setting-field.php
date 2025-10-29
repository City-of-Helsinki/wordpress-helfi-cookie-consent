<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Setting_Field
{
	public function id(): string;
	public function title(): string;
	public function value(): mixed;
	public function render(): void;
}
