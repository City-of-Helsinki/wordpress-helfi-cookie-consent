<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Postpass implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wp-postpass_*';
	}

	public function label(): string
	{
		return 'wp-postpass';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Käytetään istunnon ylläpitämiseen, jos viesti on salasanalla suojattu.',
			'sv' => 'Används för att underhålla sessionen om ett inlägg är lösenordsskyddat.',
			'en' => 'Used to maintain session if a post is password protected.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '10 päivää',
			'sv' => '10 dagar',
			'en' => '10 days'
		);
	}

	public function type(): string
	{
		return 'cookie';
	}

	public function category(): string
	{
		return 'functional';
	}
}
