<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Polylang\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Pll_Language implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Polylang';
	}

	public function name(): string
	{
		return 'pll_language';
	}

	public function label(): string
	{
		return 'pll_language';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa kieliasetuksen.',
			'sv' => 'Lagrar språkinställningen.',
			'en' => 'Stores language setting.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '-',
			'sv' => '-',
			'en' => '-',
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
