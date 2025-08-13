<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type_Factory as Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;

final class Cookie_Type_Factory implements Factory
{
	private array $class_map;

	public function __construct(
		protected string $current_language,
		private Cache $cache
	) {
		$this->class_map = array(
			'cachestorage' => Cache_Storage_Cookie_Type::class,
			'cookie' => Cookie_Cookie_Type::class,
			'indexeddb' => Indexed_Db_Cookie_Type::class,
			'localstorage' => Local_Storage_Cookie_Type::class,
			'sessionstorage' => Session_Storage_Cookie_Type::class,
			'unknown' => Unknown_Cookie_Type::class,
		);
	}

	public function from_string( string $name ): Cookie_Type
	{
		if ( $this->cache->has( $name ) ) {
			return $this->cache->get( $name );
		}

		if ( $this->is_valid( $name ) ) {
			return $this->cache->put( $name, $this->to_object( $name ) );
		}

		return $this->default_item();
	}

	private function is_valid( string $name ): bool
	{
		return isset( $this->class_map[$name] );
	}

	private function to_object( string $name ): Cookie_Type
	{
		$class = $this->class_map[$name];

		return new $class( $this->current_language );
	}

	private function default_item(): Cookie_Type
	{
		return $this->cache->has( 'unknown' )
			? $this->cache->get( 'unknown' )
			: $this->cache->put( 'unknown', $this->to_object( 'unknown' ) );
	}
}
