<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Comment_Author implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'comment_author_*';
	}

	public function label(): string
	{
		return 'comment_author';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Käytetään kommentin kirjoittajan nimen seurantaan, jos "Tallenna nimeni, sähköpostiosoitteeni ja verkkosivustoni tähän selaimeen seuraavaa kommentointikertaa varten" on valittuna.',
			'sv' => 'Används för att spåra kommentarens författares namn, om "Spara mitt namn, min e-postadress och webbplats i den här webbläsaren till nästa gång jag skriver en kommentar" är markerat.',
			'en' => 'Used to tracked comment author name, if "Save my name, email, and website in this browser for the next time I comment." is checked.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '347 päivää',
			'sv' => '347 dagar',
			'en' => '347 days'
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
