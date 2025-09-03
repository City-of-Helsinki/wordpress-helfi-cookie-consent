<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Languages_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'languages';
	}

	public function value(): mixed
	{
		return array(
			array(
				'code' => 'fi',
				'name' => 'Finnish',
				'direction' => 'ltr',
			),
			array(
				'code' => 'sv',
				'name' => 'Swedish',
				'direction' => 'ltr',
			),
			array(
				'code' => 'en',
				'name' => 'English',
				'direction' => 'ltr',
			),
		);
	}
}
