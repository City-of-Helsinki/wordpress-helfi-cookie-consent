<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Html_Renderer;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts\Cookie_Banner_Consent;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts\Cookie_Banner_Cookies;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts\Cookie_Banner_Header;

class Cookie_Banner implements Html_Renderer
{
	public function __construct(
		private Cookie_Banner_Settings $settings,
		private Cookie_Repository $repository
	) {}

	public function render(): string
	{
		return sprintf(
			'<div class="cmplz-cookiebanner cmplz-hidden cmplz-bottom banner-%1$s optin cmplz-categories-type-%2$s hel-cookie-consent" aria-modal="true" data-nosnippet="true" role="dialog" aria-live="polite" aria-labelledby="hel-cookie-consent-title-%1$s" aria-describedby="hel-cookie-consent-description-%1$s">
				<div class="hel-cookie-consent__container">
					%3$s
				</div>
			</div>',
			\esc_attr( $this->settings->id ),
			\esc_attr( $this->settings->use_categories ),
			array_reduce(
				$this->create_parts(),
				fn( string $html, Html_Renderer $part ) => ( $html . $part->render() ),
				''
			)
		);
	}

	private function create_parts(): array
	{
		return array_map(
			fn( string $part ) => new $part( $this->settings, $this->repository ),
			array(
				Cookie_Banner_Header::class,
				Cookie_Banner_Cookies::class,
				Cookie_Banner_Consent::class,
			)
		);
	}
}
