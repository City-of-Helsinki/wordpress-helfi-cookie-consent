<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Parts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Html_Renderer;
use CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner\Cookie_Banner_Settings;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_List;

class Cookie_Banner_Cookie_List implements Html_Renderer
{
	private string $id;

	public function __construct(
		string $id,
		private Cookie_List $cookie_list
	) {
		$this->id = sprintf( '%s-%s', $id, $this->cookie_list->name() );
	}

	public function render(): string
	{
		return sprintf(
			'<div class="cookie-list cmplz-category cmplz-%s">
				%s
				%s
				%s
			</div>',
			\esc_attr( $this->cookie_list->name() ),
			$this->cookies_list_header(),
			$this->cookies_list_toggle(),
			$this->cookies_list_panel()
		);
	}

	private function cookies_list_header(): string
	{
		return sprintf(
			'<div class="hds-checkbox">
				<input id="cmplz-%1$s-optin" class="hds-checkbox__input cmplz-%2$s" type="checkbox" data-category="cmplz_%2$s" value="1" %3$s %4$s>
				<label class="hds-checkbox__label" for="cmplz-%1$s-optin">%5$s</label>
			</div>
			<p class="cookie-list__description">%6$s</p>',
			\esc_attr( $this->id ),
			\esc_attr( $this->cookie_list->name() ),
			\checked( $this->has_consent(), true ),
			$this->is_disabled() ? 'disabled' : '',
			\esc_html( $this->cookie_list->label() ),
			\wp_kses_post( $this->cookie_list->description() )
		);
	}

	private function is_disabled(): bool
	{
		return 'functional' === $this->cookie_list->name();
	}

	private function has_consent(): bool
	{
		return (bool) \cmplz_has_consent( $this->cookie_list->name() );
	}

	private function cookies_list_toggle(): string
	{
		return sprintf(
			'<button id="cookie-list-toggle-%1$s" class="cookie-list-toggle toggle button button--small button--supplementary" aria-controls="cookie-list-%1$s" aria-expanded="false" aria-live="polite" type="button">
				<span aria-hidden="true" class="hel-cookie-consent-icon hel-cookie-consent-icon--angle-down"></span>
				<span class="button__label show">%2$s</span>
				<span class="button__label hide">%3$s</span>
			</button>',
			\esc_attr( $this->id ),
			\esc_html( _x( 'Show details', 'Cookie details toggle', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'Hide details', 'Cookie details toggle', 'wordpress-helfi-cookie-consent' ) )
		);
	}

	private function cookies_list_panel(): string
	{
		return sprintf(
			'<div id="cookie-list-%1$s" class="panel">
				<div class="panel__animator">
					%2$s
				</div>
			</div>',
			\esc_attr( $this->id ),
			$this->cookies_table()
		);
	}

	private function cookies_table(): string
	{
		return sprintf(
			'<table class="cookie-list__table">
				%s
				%s
			</table>',
			$this->cookies_table_head(),
			$this->cookies_table_body()
		);
	}

	private function cookies_table_head(): string
	{
		$cells = array(
			\esc_html( _x( 'Name', 'Cookies table th', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'Cookie set by', 'Cookies table th', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'Purpose of use', 'Cookies table th', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'Period of validity', 'Cookies table th', 'wordpress-helfi-cookie-consent' ) ),
			\esc_html( _x( 'Type', 'Cookies table th', 'wordpress-helfi-cookie-consent' ) ),
		);

		return sprintf(
			'<thead>
				<tr>
					<th>%s</th>
				</tr>
			</thead>',
			implode( '</th><th>', $cells )
		);
	}

	private function cookies_table_body(): string
	{
		$rows = array_map(
			array( $this, 'cookies_table_row' ),
			$this->cookie_list->cookies()
		);

		return sprintf( '<tbody>%s</tbody>', implode( '', $rows ) );
	}

	private function cookies_table_row( Cookie_Adapter $cookie ): string
	{
		$cells = array(
			\esc_html( $cookie->label() ),
			\esc_html( $cookie->issuer() ),
			\esc_html( $cookie->description() ),
			\esc_html( $cookie->retention() ),
			\esc_html( $cookie->type()->label() ),
		);

		return sprintf(
			'<tr>
				<td>%s</td>
			</tr>',
			implode( '</td><td>', $cells )
		);
	}
}
