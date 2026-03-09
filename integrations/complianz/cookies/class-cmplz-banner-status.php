<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz\Cookies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Cmplz_Banner_Status implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'Complianz';
	}

	public function name(): string
	{
		return 'cmplz_banner-status';
	}

	public function label(): string
	{
		return 'cmplz_banner-status';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Evästebannerin tila.',
			'sv' => 'Status för cookiebanner.',
			'en' => 'Cookie banner status.',
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
