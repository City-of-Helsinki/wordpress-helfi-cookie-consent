<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Cache
{
	private array $items;

	public function __construct()
	{
		$this->items = array();
	}

	public function has( string $key ): bool
	{
		return isset( $this->items[$key] );
	}

	public function get( string $key ): mixed
	{
		return $this->items[$key];
	}

	public function put( string $key, mixed $item ): mixed
	{
		$this->items[$key] = $item;

		return $item;
	}
}
