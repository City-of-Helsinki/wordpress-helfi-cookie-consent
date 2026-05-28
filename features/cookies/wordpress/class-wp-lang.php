<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Lang implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wp_lang';
	}

	public function label(): string
	{
		return 'wp_lang';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa käyttäjän WordPress-verkkosivuston ensisijaisen kieliasetuksen.',
			'sv' => 'Lagrar användarens föredragna språkinställning för WordPress-webbplatsen.',
			'en' => 'Store user\'s preferred language setting for WordPress website.',
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
		return 'cookie';
	}

	public function category(): string
	{
		return 'functional';
	}
}
