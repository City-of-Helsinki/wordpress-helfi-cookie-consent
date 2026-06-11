<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Api_Schema_Model implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wp-api-schema-model';
	}

	public function label(): string
	{
		return 'wp-api-schema-model';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Käytetään REST API -skeemamallin välimuistissa olevana kopiona, jos saatavilla.',
			'sv' => 'Används som en cachad kopia av REST API-schemamodellen om tillgänglig.',
			'en' => 'Used as a cached copy of the REST API schema model if available.',
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
		return 'sessionstorage';
	}

	public function category(): string
	{
		return 'functional';
	}
}
