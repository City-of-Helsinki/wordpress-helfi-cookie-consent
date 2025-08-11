<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;

final class Complianz_Cookie_Adapter implements Cookie_Adapter
{
	public function __construct(
		private array $cookie
	) {}

	public function issuer(): string
	{
		return $this->cookie_data( 'service_name', '' );
	}

	public function name(): string
	{
		return $this->cookie_data( 'slug', '' );
	}

	public function label(): string
	{
		return $this->cookie_data( 'name', '' );
	}

	public function description(): string
	{
		return $this->cookie_data( 'cookie_function', '' );
	}

	public function retention(): string
	{
		return $this->cookie_data( 'retention', '' );
	}

	public function type(): Cookie_Type
	{
		return $this->cookie_data( 'type', null );
	}

	public function category(): Cookie_Category
	{
		return $this->cookie_data( 'category', null );
	}

	private function cookie_data( string $key, mixed $default = null ): mixed
	{
		return ! empty( $this->cookie[$key] )
			? $this->cookie[$key]
			: $default;
	}
}
