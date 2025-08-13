<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Label_Translations
{
	protected function translated_label( string $lang, string $default_lang ): string
	{
		return $this->labels[$lang]
			?? $this->labels[$default_lang]
			?? '';
	}
}
