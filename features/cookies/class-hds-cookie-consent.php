<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class HDS_Cookie_Consent implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'HDS CookieConsent';
	}

	public function name(): string
	{
		return 'helfi-cookie-consents';
	}

	public function label(): string
	{
		return 'helfi-cookie-consents';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Sivusto käyttää tätä evästettä tietojen tallentamiseen siitä, ovatko kävijät antaneet hyväksyntänsä tai kieltäytyneet evästeiden käytöstä.',
			'sv' => 'Webbplatsen använder denna cookie för att lagra information om huruvida besökare har samtyckt till eller avböjt användningen av cookies.',
			'en' => 'The website uses this cookie to store information about whether visitors have consented to or declined the use of cookies.'
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '100 päivää',
			'sv' => '100 dagar',
			'en' => '100 days'
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
