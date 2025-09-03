<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Admin_Notice;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Nav_Menu;

final class Nav_Menu_Policy_Pages_Added_Notice implements Admin_Notice
{
	public function __construct(
		private Nav_Menu $menu
	) {}

	public function type(): string
	{
		return 'success';
	}

	public function message(): string
	{
		return $this->title()
			. $this->paragraphs();
	}

	private function title(): string
	{
		$title = \apply_filters( 'wordpress_helfi_cookie_consent_plugin_title', '' );

		return $title ? sprintf( '<h2>%s</h2>', $title ) : '';
	}

	private function paragraphs(): string
	{
		return sprintf(
			'<p>%s</p>',
			sprintf(
				__( 'Cookie policy pages added to the "%s" navigation menu.', 'wordpress-helfi-cookie-consent' ),
				$this->menu->name() ?: $this->menu->location()
			)
		);
	}
}
