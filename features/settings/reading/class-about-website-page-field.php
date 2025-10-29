<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Settings\Reading;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Settings\Setting_Field;

final class About_Website_Page_Field implements Setting_Field
{
	public function id(): string
	{
		return 'wordpress_helfi_cookie_consent_about_website_page_id';
	}

	public function title(): string
	{
		return __( 'About the website page', 'wordpress-helfi-cookie-consent' );
	}

	public function value(): mixed
	{
		return (int) \get_option( $this->id(), 0 );
	}

	public function render(): void
	{
		\wp_dropdown_pages( array(
			'selected' => $this->value(),
			'echo' => true,
			'name' => $this->id(),
			'id' => $this->id(),
			'show_option_none' => __( 'Select a page', 'wordpress-helfi-cookie-consent' ),
			'option_none_value' => 0,
		) );
	}
}
