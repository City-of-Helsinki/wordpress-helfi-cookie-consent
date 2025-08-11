<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;

readonly class Rest_Controller_Config
{
	public function __construct(
		public string $namespace,
		public string $name,
		public int $version,
		public Cookie_Repository $cookie_repository
	) {}
}
