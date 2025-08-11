<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Html_Renderer;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Cookie_Banner_Settings;

class Cookie_Banner_Cookies implements Html_Renderer
{
	public function __construct(
		private Cookie_Banner_Settings $settings,
		private Cookie_Repository $repository
	) {}

	public function render(): string
	{
		return $this->cookies_panel_toggle() . $this->cookies_panel();
	}

	private function cookies_panel_toggle(): string
	{
		return sprintf(
			'<button id="cookies-panel-toggle-%1$s" class="cookies-panel-toggle toggle button button--small button--supplementary" aria-controls="cookies-panel-%1$s" aria-expanded="false" aria-live="polite" type="button">
				<span aria-hidden="true" class="hel-cookie-consent-icon hel-cookie-consent-icon--angle-down"></span>
				<span class="button__label show">%2$s</span>
				<span class="button__label hide">%3$s</span>
			</button>',
			\esc_attr( $this->settings->id ),
			\esc_html( _x( 'Show details', 'Cookie details toggle', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'Hide details', 'Cookie details toggle', 'wordpress-helfi-cookie-consent' ) )
		);
	}

	private function cookies_panel(): string
	{
		return sprintf(
			'<div id="cookies-panel-%1$s" class="cookies-panel panel">
				<div class="panel__animator">
					<h3 class="cookies-panel__title">%2$s</h3>
					<p class="cookies-panel__description">%3$s</p>
					<div class="cookies-panel__content">
						%4$s
					</div>
				</div>
			</div>',
			\esc_attr( $this->settings->id ),
			\esc_html( _x( 'About the cookies used on the website', 'Cookie details title', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'The cookies used on the website have been classified according to their intended use. Below, you can read about the various categories and accept or reject the use of cookies.', 'Cookie details description', 'wordpress-helfi-cookie-consent' ) ),
			array_reduce(
				$this->create_cookie_lists(),
				fn( string $html, Html_Renderer $part ) => ( $html . $part->render() ),
				''
			)
		);
	}

	private function create_cookie_lists(): array
	{
		return array_map(
			fn( $list ) => new Cookie_Banner_Cookie_List( $this->settings->id, $list ),
			$this->repository->cookie_lists()->all()
		);
	}
}
