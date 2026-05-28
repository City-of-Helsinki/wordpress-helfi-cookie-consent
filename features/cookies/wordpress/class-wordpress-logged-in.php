<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WordPress_Logged_In implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wordpress_logged_in_*';
	}

	public function label(): string
	{
		return 'wordpress_logged_in';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa kirjautuneet käyttäjät, muistaa käyttäjän istunnon. Tämä eväste osoittaa, että olet kirjautunut WordPressiin ja tarjoaa käyttäjätietosi useimpia käyttöliittymän käyttötarkoituksia varten.',
			'sv' => 'Spara inloggade användare, kom ihåg användarsession. Denna cookie indikerar att du är inloggad på WordPress och tillhandahåller din användarinformation för de flesta gränssnittsanvändningar.',
			'en' => 'Store logged in users, remember user session. This cookie indicates that you are logged in to WordPress and provides your user information for most of the interface uses.',
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
