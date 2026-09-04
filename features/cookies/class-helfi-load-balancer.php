<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Helfi_Load_Balancer implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return '.hel.fi';
	}

	public function name(): string
	{
		return 'helfi-lb';
	}

	public function label(): string
	{
		return 'helfi-lb';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Käytetään palvelimen kuormantasaajassa varmistamaan, että käyttäjä ohjataan aina samaan palvelininstanssiin käynnissä olevan istunnon aikana. ',
			'sv' => 'Används i serverns belastningsutjämnare för att säkerställa att användaren alltid styrs till samma serverinstans under en pågående session.',
			'en' => 'Used in the server load balancer to ensure that the user is always directed to the same server instance during the current session.'
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => 'Istunto',
			'sv' => 'Session',
			'en' => 'Session',
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
