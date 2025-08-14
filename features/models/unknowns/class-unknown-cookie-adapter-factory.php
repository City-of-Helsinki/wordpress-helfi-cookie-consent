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
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Unknown_Cookie_Adapter_Factory implements Cookie_Adapter_Factory
{
	public function __construct(
		private string $current_language,
		Cookie_Category_Factory $categories,
		Cookie_Type_Factory $types,
	) {}

	public function create_known_cookie( Known_Cookie_Data $data ): Cookie_Adapter
	{
		return new Default_Cookie_Adapter( ...array(
			'current_language' => $this->current_language,
			'issuer' => $data->issuer(),
			'name' => $data->name(),
			'label' => $data->label(),
			'descriptions' => $data->descriptionTranslations(),
			'retentions' => $data->retentionTranslations(),
			'type' => $types->from_string( $data->type() ),
			'category' => $categories->from_string( $data->category() ),
		) );
	}

	public function create_adapter( mixed $data ): Cookie_Adapter
	{
		return new Default_Cookie_Adapter( ...array(
			'current_language' => $this->current_language,
			'issuer' => '',
			'name' => 'unknown',
			'label' => __( 'Unknown', 'wordpress-helfi-cookie-consent' ),
			'descriptions' => array(),
			'retentions' => array(),
			'type' => $types->from_string( 'unknown' ),
			'category' => $categories->from_string( 'unknown' ),
		) );
	}
}
