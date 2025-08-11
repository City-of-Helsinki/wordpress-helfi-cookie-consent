<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type_Factory;

final class Complianz_Cookie_Adapter_Factory implements Cookie_Adapter_Factory
{
	public function __construct(
		private string $language,
		private Cookie_Category_Factory $categories,
		private Cookie_Type_Factory $types,
	) {}

	public function create_consents_cookie(): Cookie_Adapter
	{
		return $this->adapter( array(
			'service_name' => '',
			'slug' => 'helfi-cookie-consents',
			'name' => 'helfi-cookie-consents',
			'cookie_function' => 'Sivusto käyttää tätä evästettä tietojen tallentamiseen siitä, ovatko kävijät antaneet hyväksyntänsä tai kieltäytyneet evästeiden käytöstä.',
			'retention' => '100 päivää',
			'type' => $this->types->from_string( 'cookie' ),
			'category' => $this->categories->from_string( 'functional' ),
		) );
	}

	public function create_adapter( mixed $data ): Cookie_Adapter
	{
		return $this->adapter( $this->format_data( $data ) );
	}

	private function adapter( array $data ): Cookie_Adapter
	{
		return new Complianz_Cookie_Adapter( $data );
	}

	private function format_data( mixed $data ): array
	{
		if ( ! is_array( $data ) ) {
			return array();
		}

		foreach ( $data as $key => $value ) {
			if ( is_array( $value ) ) {
				$data[$key] = $value[$this->language] ?? $value['en'] ?? '';
			}
		}

		$casts = array(
			'category' => fn( string $name ) => $this->categories->from_string( $name ),
			'type' => fn( string $name ) => $this->types->from_string( $name ),
		);

		foreach ( $casts as $key => $cast ) {
			if ( isset( $data[$key] ) ) {
				$data[$key] = call_user_func( $cast, $data[$key] );
			}
		}

		return $data;
	}
}
