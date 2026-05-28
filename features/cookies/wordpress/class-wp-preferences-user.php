<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Preferences_User implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'WP_PREFERENCES_USER_*';
	}

	public function label(): string
	{
		return 'WP_PREFERENCES_USER';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'WordPressin ydintoiminto käyttäjätietojen hallintaan.',
			'sv' => 'WordPress kärnfunktion för att hantera användardata.',
			'en' => 'WordPress core function to manage user data.',
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
		return 'localstorage';
	}

	public function category(): string
	{
		return 'functional';
	}
}
