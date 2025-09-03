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
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Complianz_Cookie_Adapter_Factory implements Cookie_Adapter_Factory
{
	public function __construct(
		private string $language,
		private Cookie_Category_Factory $categories,
		private Cookie_Type_Factory $types,
	) {}

	public function create_known_cookie( Known_Cookie_Data $data ): Cookie_Adapter
	{
		return $this->adapter( array(
			'service_name' => $data->issuer(),
			'slug' => $data->name(),
			'name' => $data->label(),
			'cookie_function' => $data->descriptionTranslations(),
			'retention' => $data->retentionTranslations(),
			'type' => $this->types->from_string( $data->type() ),
			'category' => $this->categories->from_string( $data->category() ),
		) );
	}

	public function create_adapter( mixed $data ): Cookie_Adapter
	{
		return $this->adapter( $this->format_data( $data ) );
	}

	private function adapter( array $data ): Cookie_Adapter
	{
		return new Complianz_Cookie_Adapter( $this->language, $data );
	}

	private function format_data( mixed $data ): array
	{
		if ( ! is_array( $data ) ) {
			return array();
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
