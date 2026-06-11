<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Autosave implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wp-autosave-*';
	}

	public function label(): string
	{
		return 'wp-autosave';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa käyttäjän verkkosivustolla suorittamat toiminnot.',
			'sv' => 'Lagrar handlingar som utförts av användaren på webbplatsen.',
			'en' => 'Stores actions performed by the user on the website.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => 'Istunto',
			'sv' => 'Session',
			'en' => 'Session'
		);
	}

	public function type(): string
	{
		return 'sessionstorage';
	}

	public function category(): string
	{
		return 'functional';
	}
}
