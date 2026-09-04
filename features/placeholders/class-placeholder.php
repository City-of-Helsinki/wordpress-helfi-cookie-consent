<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;

final class Placeholder
{
	public function __construct(
		private Placeholder_Content $content
	) {}

	public function render(): string
	{
		return sprintf(
			'<div class="wp-cookie-consent-placeholder">%s</div>',
			implode( PHP_EOL, $this->content() )
		);
	}

	private function content(): array
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_placeholder_content',
			array(
				$this->notice_icon(),
				$this->notice_title(),
				$this->notice_text(),
				$this->notice_buttons(),
			)
		);
	}

	private function notice_icon(): string
	{
		$icon = \apply_filters(
			'wordpress_helfi_cookie_consent_placeholder_notice_icon',
			$this->content->notice_icon()
		);

		return $icon ? sprintf(
			'<span class="icon mask-icon icon--%1$s hds-icon--%1$s" aria-hidden="true" role="img"></span>',
			\esc_attr( $icon )
		) : '';
	}

	private function notice_title(): string
	{
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_placeholder_notice_title',
			$this->content->notice_title()
		);

		return $content ? sprintf(
			'<h2 class="wp-block-heading">%s</h2>',
			\esc_html( $content )
		) : '';
	}

	private function notice_text(): string
	{
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_placeholder_notice_text',
			$this->content->notice_text()
		);

		return $content ? sprintf(
			'<p class="wp-block-paragraph">%s</p>',
			\esc_html( $content )
		) : '';
	}

	private function notice_buttons(): string
	{
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_placeholder_notice_buttons',
			$this->content->notice_buttons()
		);

		return $content ? sprintf(
			'<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">%s</div>',
			implode( PHP_EOL, $content )
		) : '';
	}
}
