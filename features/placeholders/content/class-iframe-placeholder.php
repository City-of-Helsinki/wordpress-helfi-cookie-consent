<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Categories;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Content_Config;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Content;

final class Iframe_Placeholder implements Placeholder_Content
{
	public function __construct(
		private Placeholder_Content_Config $config
	) {}

	public function notice_icon(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_icon',
			$this->config->icon,
			$this->config->source
		);
	}

	public function notice_title(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_title',
			_x( 'Content cannot be displayed', 'placeholder notice title', 'wordpress-helfi-cookie-consent' ),
			$this->config->source
		);
	}

	public function notice_text(): string
	{
		$cat_labels = $this->config->categories->labels_text();

		$source = \shortcode_atts( array(
			'scheme' => '',
			'host' => '',
		), parse_url( $this->config->source ) );

		return \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_text',
			sprintf(
				_x( 'This content is hosted by %1$s. To see the content, switch over to the external site or accept the usage of %2$s cookies.', 'placeholder notice text', 'wordpress-helfi-cookie-consent' ),
				implode( '://', $source ),
				$cat_labels
			),
			$source,
			$cat_labels,
			$this->config->source,
			$this->config->categories->list()
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
			_x( 'See content on external site', 'placeholder notice button', 'wordpress-helfi-cookie-consent' ),
			$this->config->source
		);

		$url = \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_external_button_url',
			$this->config->source
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
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_iframe_placeholder_notice_grant_button_text',
			_x( 'Accept required cookies', 'placeholder notice button', 'wordpress-helfi-cookie-consent' ),
			$this->config->source
		);

		return sprintf(
			'<div class="wp-block-button is-style-secondary">
				<button class="wp-element-button" type="button" data-wp-cookie-consent-grant="%1$s" disabled>%2$s</button>
			</div>',
			htmlspecialchars( json_encode( $this->config->categories->names() ) ),
			\esc_html( $content )
		);
	}
}
