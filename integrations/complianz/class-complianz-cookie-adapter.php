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
		private string $current_language,
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

	public function description( string $language = '' ): string
	{
		if ( ! $language ) {
			$language = $this->current_language;
		}

		return $this->translated_cookie_data( $language, 'cookie_function', '' )
			?: $this->translated_cookie_data( 'en', 'cookie_function', '' );
	}

	public function retention( string $language = '' ): string
	{
		if ( ! $language ) {
			$language = $this->current_language;
		}

		return $this->translated_cookie_data( $language, 'retention', '' )
			?: $this->translated_cookie_data( 'en', 'retention', '' );
	}

	public function type(): Cookie_Type
	{
		return $this->cookie_data( 'type', null );
	}

	public function category(): Cookie_Category
	{
		return $this->cookie_data( 'category', null );
	}

	private function translated_cookie_data( string $lang, string $key, mixed $default = null ): mixed
	{
		return ! empty( $this->cookie[$key][$lang] )
			? $this->cookie[$key][$lang]
			: $default;
	}

	private function cookie_data( string $key, mixed $default = null ): mixed
	{
		return ! empty( $this->cookie[$key] )
			? $this->cookie[$key]
			: $default;
	}
}
