<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

readonly class Cookie_Banner_Settings
{
	public function __construct(
		public string $id = '',
		public string $message_optin = '',
		public string $use_categories = '',
		public string $home_url = '',
	) {}
}
