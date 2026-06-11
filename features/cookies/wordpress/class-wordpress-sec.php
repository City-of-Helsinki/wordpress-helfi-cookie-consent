<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WordPress_Sec implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wordpress_sec_*';
	}

	public function label(): string
	{
		return 'wordpress_sec';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'WordPress-tietoturvaeväste, jota käytetään käyttäjän todennuksen vahvistamiseen. Tallentaa tilitiedot.',
			'sv' => 'WordPress säkerhetscookie används för att validera användarautentisering. Lagrar kontouppgifter.',
			'en' => 'WordPress security cookie used to validate user authentication. Stores account details.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '-',
			'sv' => '-',
			'en' => '-'
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
