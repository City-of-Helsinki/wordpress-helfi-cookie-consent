<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Cmplz_Policy_Id implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Complianz';
	}

	public function name(): string
	{
		return 'cmplz_policy_id';
	}

	public function label(): string
	{
		return 'cmplz_policy_id';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Nykyinen hyväksytty evästekäytäntöversio.',
			'sv' => 'Nuvarande version av accepterad cookiepolicy.',
			'en' => 'Current accepted cookie policy version.',
		);
	}

	public function retentionTranslations(): array
	{
		$expiry = (int) \apply_filters( 'wordpress_helfi_cookie_consent_cmplz_expiry_days', 365 );

		return array(
			'fi' => $expiry . ' päivää',
			'sv' => $expiry . ' dagar',
			'en' => $expiry . ' days',
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
