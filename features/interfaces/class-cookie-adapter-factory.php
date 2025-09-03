<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Cookie_Adapter_Factory
{
	public function create_adapter( mixed $data ): Cookie_Adapter;
	public function create_known_cookie( Known_Cookie_Data $data ): Cookie_Adapter;
}
