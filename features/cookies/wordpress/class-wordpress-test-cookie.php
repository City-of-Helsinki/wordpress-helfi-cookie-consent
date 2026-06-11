<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WordPress_Test_Cookie implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wordpress_test_cookie';
	}

	public function label(): string
	{
		return 'wordpress_test_cookie';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Testaa, hyväksyykö selain evästeet.',
			'sv' => 'Testar att webbläsaren accepterar cookies.',
			'en' => 'Tests that the browser accepts cookies.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => 'Istunto',
			'sv' => 'Session',
			'en' => 'Session'
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
