<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;

final class Policy_Page_Factory
{
	private array $types = [
		'helfi_cookie_policy' => Cookie_Policy_Page::class,
	];

	public function __construct(
		private Cache $cache
	) {}

	public function query_var(): string
	{
		return 'policy_page';
	}

	public function all(): array
	{
		return array_map(
			array( $this, 'create_page' ),
			array_keys( $this->types )
		);
	}

	public function from_item_type( string $type ): ?Policy_Page
	{
		return isset( $this->types[$type] ) ? $this->create_page( $type ) : null;
	}

	private function create_page( string $type ): Policy_Page
	{
		if ( ! $this->cache->has( $type ) ) {
			$this->cache->put(
				$type,
				new $this->types[$type]( $this->query_var() )
			);
		}

		return $this->cache->get( $type );
	}
}
