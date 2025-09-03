<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Description_Translations
{
	protected function translated_description( string $lang, string $default_lang ): string
	{
		return $this->descriptions[$lang]
			?? $this->descriptions[$default_lang]
			?? '';
	}
}
