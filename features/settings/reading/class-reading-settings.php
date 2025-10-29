<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Settings\Reading;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Reading_Settings
{
	private array $fields;

	public function title(): string
	{
		return __( 'WordPress Helsinki Cookie Consent', 'wordpress-helfi-cookie-consent' );
	}

	public function section(): string
	{
		return 'wordpress_helfi_cookie_consent_reading';
	}

	public function page(): string
	{
		return 'reading';
	}

	public function render_section(): void
	{}

	public function active(): bool
	{
		return ! (bool) \apply_filters(
			'wordpress_helfi_cookie_consent_helsinkiteema_active',
			false
		);
	}

	public function fields(): array
	{
		if ( ! isset( $this->fields ) ) {
			$this->fields = array_map(
				fn( $classname ) => new $classname(),
				array(
					Enable_Custom_Pages_Field::class,
					About_Website_Page_Field::class,
					Cookie_Policy_Page_Field::class,
				)
			);
		}

		return $this->fields;
	}
}
