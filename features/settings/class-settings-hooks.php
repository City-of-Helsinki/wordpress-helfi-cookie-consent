<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Settings_Hooks
{
	public function __construct(
		private array $settings
	) {}

	public function register(): void
	{
		foreach ( $this->settings as $settings ) {
			if ( ! $settings->active() ) {
				continue;
			}

			\add_settings_section(
				$settings->section(),
				$settings->title(),
				array( $settings, 'render_section' ),
				$settings->page()
			);

			foreach ( $settings->fields() as $field ) {
				\add_settings_field(
					$field->id(),
					$field->title(),
					array( $field, 'render' ),
					$settings->page(),
					$settings->section()
				);

				\register_setting( $settings->page(), $field->id() );
			}
		}
	}

	public function provide_field_values(): void
	{
		foreach ( $this->settings as $settings ) {
			if ( ! $settings->active() ) {
				continue;
			}

			foreach ( $settings->fields() as $field ) {
				\add_filter(
					$field->id(),
					fn( $value ) => $field->value() ?: $value
				);
			}
		}
	}
}
