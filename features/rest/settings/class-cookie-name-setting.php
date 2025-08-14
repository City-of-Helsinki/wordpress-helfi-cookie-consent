<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\HDS_Cookie_Consent;

final class Cookie_Name_Setting implements Setting_Interface
{
	private string $cookie_name;

	public function __construct()
	{
		$this->cookie_name = (new HDS_Cookie_Consent)->name();
	}

	public function name(): string
	{
		return 'cookieName';
	}

	public function value(): mixed
	{
		return 'helfi-cookie-consents';
	}
}
