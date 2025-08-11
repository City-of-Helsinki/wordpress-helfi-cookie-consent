<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category_Factory as Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;

final class Cookie_Category_Factory implements Factory
{
	private array $class_map;

	public function __construct(
		private Cache $cache
	) {
		$this->class_map = array(
			'preferences' => Preferences_Cookie_Category::class,
			'functional' => Functional_Cookie_Category::class,
			'marketing' => Marketing_Cookie_Category::class,
			'statistics' => Statistics_Cookie_Category::class,
			'statistics_anonymous' => Statistics_Anonymous_Cookie_Category::class,
			'unknown' => Unknown_Cookie_Category::class,
		);
	}

	public function from_string( string $name ): Cookie_Category
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

	private function to_object( string $name ): Cookie_Category
	{
		$class = $this->class_map[$name];

		return new $class();
	}

	private function default_item(): Cookie_Category
	{
		return $this->cache->has( 'unknown' )
			? $this->cache->get( 'unknown' )
			: $this->cache->put( 'unknown', $this->to_object( 'unknown' ) );
	}
}
