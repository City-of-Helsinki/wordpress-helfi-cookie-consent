<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Enums\Placeholder_Type;

readonly class Placeholder_Content_Config
{
	public function __construct(
		public Placeholder_Type $type,
		public Placeholder_Categories $categories,
		public string $source,
		public string $icon
	) {}
}
