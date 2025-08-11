<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Html_Renderer;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Cookie_Banner_Settings;

class Cookie_Banner_Header implements Html_Renderer
{
	public function __construct(
		private Cookie_Banner_Settings $settings
	) {}

	public function render(): string
	{
		return sprintf(
			'<div class="hel-cookie-consent__header">
				<h2 id="hel-cookie-consent-title-%1$s" class="hel-cookie-consent__title">%2$s</h2>
				<p id="hel-cookie-consent-description-%1$s" class="hel-cookie-consent__description">%3$s</p>
			</div>',
			\esc_attr( $this->settings->id ?: (string) time() ),
			\esc_html( $this->cookie_consent_title() ),
			\esc_html( $this->settings->message_optin ),
		);
	}

	private function cookie_consent_title(): string
	{
		return sprintf(
			_x( 'Cookies on %s', 'Cookie consent title', 'wordpress-helfi-cookie-consent' ),
			parse_url( $this->settings->home_url, PHP_URL_HOST )
		);
	}
}
