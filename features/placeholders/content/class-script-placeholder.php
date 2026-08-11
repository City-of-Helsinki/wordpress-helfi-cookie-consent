<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Categories;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Content_Config;
use CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Placeholder_Content;

final class Script_Placeholder implements Placeholder_Content
{
	public function __construct(
		private Placeholder_Content_Config $config
	) {}

	public function notice_icon(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_script_placeholder_notice_icon',
			$this->config->icon,
			$this->config->source
		);
	}

	public function notice_title(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_script_placeholder_notice_title',
			_x( 'Would you like to give feedback on this page?', 'placeholder notice title', 'wordpress-helfi-cookie-consent' ),
			$this->config->source
		);
	}

	public function notice_text(): string
	{
		$cat_labels = $this->config->categories->labels_text();

		return \apply_filters(
			'wordpress_helfi_cookie_consent_script_placeholder_notice_text',
			sprintf(
				_x( 'Enabling the usage of %1$s cookies will allow you to share your input.', 'placeholder notice text', 'wordpress-helfi-cookie-consent' ),
				$cat_labels
			),
			$cat_labels,
			$this->config->source,
			$this->config->categories->list()
		);
	}

	public function notice_buttons(): array
	{
		return array( $this->notice_grant_button() );
	}

	private function notice_grant_button(): string
	{
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_script_placeholder_notice_grant_button_text',
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
