<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Retention_Translations
{
	protected function translated_retention( string $lang, string $default_lang ): string
	{
		return $this->retentions[$lang]
			?? $this->retentions[$default_lang]
			?? '';
	}
}
