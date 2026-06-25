<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Content;

final class Iframe_Placeholder implements Placeholder_Content
{
	private array $categories;

	public function __construct(
		private string $source,
		Cookie_Category ...$categories
	) {
		$this->categories = $categories;
	}

	public function notice_icon(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_icon',
			'alert-circle-fill'
		);
	}

	public function notice_title(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_title',
			_x( 'Content cannot be displayed', 'placeholder notice title', 'wordpress-helfi-cookie-consent' )
		);
	}

	public function notice_text(): string
	{
		$cat_count = count( $this->categories );
		$categories = '';
		$cat_sep = ', ';

		foreach ( $this->categories as $cat_i => $category ) {
			if ( $cat_i > 0 ) {
				if ( ($cat_i + 1) === $cat_count ) {
					$cat_sep = sprintf( ' %s ', _x( 'and', 'wordpress-helfi-cookie-consent' ) );
				}

				$categories .= $cat_sep;
			}

			$categories .= mb_strtolower( $category->label() );
		}

		$source = \shortcode_atts( array(
			'scheme' => '',
			'host' => '',
		), parse_url( $this->source ) );

		return \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_text',
			sprintf(
				_x( 'This content is hosted by %1$s. To see the content, switch over to the external site or accept the usage of %2$s cookies.', 'placeholder notice text', 'wordpress-helfi-cookie-consent' ),
				implode( '://', $source ),
				$categories
			),
			$source,
			$categories,
			$this->source,
			$this->categories
		);
	}

	public function notice_buttons(): array
	{
		return array(
			$this->notice_external_button(),
			$this->notice_grant_button(),
		);
	}

	private function notice_external_button(): string
	{
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_external_button_text',
			_x( 'See content on external site', 'placeholder notice button', 'wordpress-helfi-cookie-consent' )
		);

		$url = \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_external_button_url',
			$this->source
		);

		return sprintf(
			'<div class="wp-block-button">
				<a class="wp-block-button__link wp-element-button" href="%1$s">%2$s</a>
			</div>',
			\esc_url( $url ),
			\esc_html( $content )
		);
	}

	private function notice_grant_button(): string
	{
		$categories = array_values( array_map(
			fn( Cookie_Category $category ) => $category->name(),
			$this->categories
		) );

		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_grant_button_text',
			_x( 'Accept required cookies', 'placeholder notice button', 'wordpress-helfi-cookie-consent' )
		);

		return sprintf(
			'<div class="wp-block-button is-style-secondary">
				<button class="wp-element-button" type="button" data-wp-cookie-consent-grant="%1$s" disabled>%2$s</button>
			</div>',
			htmlspecialchars( json_encode( $categories ) ),
			\esc_html( $content )
		);
	}
}
