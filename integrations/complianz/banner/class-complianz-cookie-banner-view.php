<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Banner;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Consent_View;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;

class Complianz_Cookie_Banner_View implements Cookie_Consent_View
{
	private array $banner_settings;

	public function __construct(
		private Cookie_Repository $repository
	) {
		$this->banner_settings = array();
	}

	public function setup(): void
	{
		\add_filter( 'cmplz_document_comment', '__return_empty_string' );
		\add_filter( 'cmplz_cookiebanner_settings_html', array( $this, 'capture_cookiebanner_settings' ), 9999, 2 );
		\add_filter( 'cmplz_template_file', array( $this, 'disable_default_cookiebanner' ), 9999, 2 );
		\add_filter( 'cmplz_banner_html', array( $this, 'hds_cookie_consent_html' ), 9999 );
	}

	public function disable_default_cookiebanner( string $path, string $file_name ): string
	{
		return 'cookiebanner.php' === $file_name ? '' : $path;
	}

	public function capture_cookiebanner_settings( array $settings, \CMPLZ_COOKIEBANNER $banner ): array
	{
		$this->banner_settings = \shortcode_atts(
			array(
				'id' => '',
				'message_optin' => '',
				'use_categories' => '',
			),
			$settings
		);

		return $settings;
	}

	public function hds_cookie_consent_html(): string
	{
		return '';
		// return $this->create_cookie_banner()->render();
	}

	private function create_cookie_banner(): Cookie_Banner
	{
		$settings = array_merge(
			$this->banner_settings,
			array( 'home_url' => \get_home_url( null, '/' ) )
		);

		return new Cookie_Banner(
			new Cookie_Banner_Settings( ...$settings ),
			$this->repository
		);
	}
}
