<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Has_Custom_Page_Id
{
	private function custom_page_id_from_name( string $name ): int
	{
		if ( ! $this->custom_page_enabled() ) {
			return 0;
		}

		return \apply_filters(
			"wordpress_helfi_cookie_consent_custom_page_id",
			(int) \apply_filters( "wordpress_helfi_cookie_consent_{$name}_page_id", 0 ),
			$name
		);
	}

	private function custom_page_enabled(): bool
	{
		return (bool) \apply_filters( "wordpress_helfi_cookie_consent_enable_custom_pages", 0 );
	}
}
