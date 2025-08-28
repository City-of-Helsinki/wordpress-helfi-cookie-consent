<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Notices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Missing_Cookie_Provider_Notice
{
	public function type(): string
	{
		return 'error';
	}

	public function message(): string
	{
		return $this->title()
			. $this->paragraphs()
			. $this->supported_providers();
	}

	private function title(): string
	{
		$title = \apply_filters( 'wordpress_helfi_cookie_consent_plugin_title', '' );

		return $title ? sprintf( '<h2>%s</h2>', $title ) : '';
	}

	private function paragraphs(): string
	{
		return array_reduce(
			array(
				__( 'The cookie consent is missing a cookie provider.', 'wordpress-helfi-cookie-consent' ),
				__( 'The cookie banner won\'t be able to group and list the cookies used on this site without a cookie provider.', 'wordpress-helfi-cookie-consent'  ),
				__( 'Please activate one of the supported cookie providers to use this plugin.', 'wordpress-helfi-cookie-consent' ),
			),
			fn( string $text, string $paragraph ) => $text . '<p>' . $paragraph . '</p>',
			''
		);
	}

	private function supported_providers(): string
	{
		return sprintf(
			'<p><strong>%s:</strong> %s</p>',
			__( 'Supported cookie providers', 'wordpress-helfi-cookie-consent' ),
			'Complianz, Complianz Premium'
		);
	}
}
