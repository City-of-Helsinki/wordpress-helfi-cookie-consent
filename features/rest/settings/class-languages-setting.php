<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Languages_Setting implements Setting_Interface
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
				'name' => __( 'Finnish' ),
				'direction' => 'ltr',
			),
			array(
				'code' => 'sv',
				'name' => __( 'Swedish' ),
				'direction' => 'ltr',
			),
			array(
				'code' => 'en',
				'name' => __( 'English' ),
				'direction' => 'ltr',
			),
		);
	}
}
