<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Settings implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wp-settings-*';
	}

	public function label(): string
	{
		return 'wp-settings';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa käyttäjän asetukset ja säilyttää wp-admin-asetukset. WordPress asettaa tämän evästeen säilyttääkseen käyttäjän wp-admin-asetukset.',
			'sv' => 'Tallentaa käyttäjän asetukset ja säilyttää wp-admin-asetukset. WordPress asettaa tämän evästeen säilyttääkseen käyttäjän wp-admin-asetukset.',
			'en' => 'Store user preferences and persist wp-admin config. WordPress sets this cookie to preserve the user’s wp-admin settings.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '1 vuosi',
			'sv' => '1 år',
			'en' => '1 year'
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
