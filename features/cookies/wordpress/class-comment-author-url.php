<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Comment_Author_Url implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'comment_author_url_*';
	}

	public function label(): string
	{
		return 'comment_author_url';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Käytetään kommentin kirjoittajan URL-osoitteen seurantaan, jos "Tallenna nimeni, sähköpostiosoitteeni ja verkkosivustoni tähän selaimeen seuraavaa kommentointikertaa varten" on valittuna.',
			'sv' => 'Används för att spåra kommentarens författares URL, om "Spara mitt namn, min e-postadress och webbplats i den här webbläsaren till nästa gång jag kommenterar" är markerat.',
			'en' => 'Used to tracked comment author url, if "Save my name, email, and website in this browser for the next time I comment." is checked.',
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
