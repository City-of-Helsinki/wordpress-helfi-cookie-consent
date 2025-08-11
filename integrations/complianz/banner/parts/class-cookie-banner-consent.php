<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Html_Renderer;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Cookie_Banner_Settings;

class Cookie_Banner_Consent implements Html_Renderer
{
	public function __construct(
		private Cookie_Banner_Settings $settings
	) {}

	public function render(): string
	{
		return sprintf(
			'<div class="hel-cookie-consent__buttons">%s</div>',
			implode( '', $this->create_buttons() )
		);
	}

	private function create_buttons(): array
	{
		return array(
			$this->button_html(
				'accept-all-cookies cmplz-accept',
				_x( 'Accept all cookies', 'Consent button', 'wordpress-helfi-cookie-consent' )
			),
			$this->button_html(
				'accept-selected-cookies cmplz-save-preferences',
				_x( 'Accept selected cookies', 'Consent button', 'wordpress-helfi-cookie-consent' )
			),
			$this->button_html(
				'accept-required-cookies cmplz-deny',
				_x( 'Accept required cookies only', 'Consent button', 'wordpress-helfi-cookie-consent' )
			),
		);
	}

	private function button_html( string $type, string $label ): string
	{
		return sprintf(
			'<button class="button button--secondary %1$s" type="button">%2$s</button>',
			\esc_attr( $type ),
			\esc_html( $label )
		);
	}
}
