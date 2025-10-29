<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Settings\Reading;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Settings\Setting_Field;

final class Enable_Custom_Pages_Field implements Setting_Field
{
	public function id(): string
	{
		return 'wordpress_helfi_cookie_consent_enable_custom_pages';
	}

	public function title(): string
	{
		return __( 'Custom pages', 'wordpress-helfi-cookie-consent' );
	}

	public function value(): mixed
	{
		return (int) \get_option( $this->id(), 0 );
	}

	public function render(): void
	{
		printf(
			'<label><input type="checkbox" id="%s" name="%s" value="1" %s> %s</label>',
			\esc_attr( $this->id() ),
			\esc_attr( $this->id() ),
			\checked( $this->value(), 1, false ),
			\esc_html( __( 'Enable custom pages', 'wordpress-helfi-cookie-consent' ) )
		);

		printf(
			'<p class="description">%s</p>',
			\esc_html( __( 'Enabling custom pages disables the default page paths.', 'wordpress-helfi-cookie-consent' ) )
		);
	}
}
