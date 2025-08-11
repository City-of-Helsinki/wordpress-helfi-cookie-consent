<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type_Factory;

final class Unknown_Cookie_Adapter_Factory implements Cookie_Adapter_Factory
{
	private Cookie_Adapter $adapter;
	private Cookie_Adapter $consents;

	public function __construct(
		Cookie_Category_Factory $categories,
		Cookie_Type_Factory $types,
	) {
		$this->adapter = new Unknown_Cookie_Adapter( array(
			'issuer' => '',
			'name' => 'unknown',
			'label' => __( 'Unknown', 'wordpress-helfi-cookie-consent' ),
			'description' => '',
			'retention' => '',
			'type' => $types->from_string( 'unknown' ),
			'category' => $categories->from_string( 'unknown' ),
		) );

		$this->adapter = new Unknown_Cookie_Adapter( array(
			'issuer' => '',
			'name' => 'helfi-cookie-consents',
			'label' => 'helfi-cookie-consents',
			'description' => 'Sivusto käyttää tätä evästettä tietojen tallentamiseen siitä, ovatko kävijät antaneet hyväksyntänsä tai kieltäytyneet evästeiden käytöstä.',
			'retention' => '100 päivää',
			'type' => $types->from_string( 'unknown' ),
			'category' => $categories->from_string( 'unknown' ),
		) );
	}

	public function create_consents_cookie(): Cookie_Adapter
	{
		return $this->consents;
	}

	public function create_adapter( mixed $data ): Cookie_Adapter
	{
		return $this->adapter;
	}
}
