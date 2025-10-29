<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;

final class Page_Factory
{
	private array $types = array(
		'helfi_about_page' => About_Page::class,
		'helfi_cookie_policy' => Cookie_Policy_Page::class,
	);

	private array $custom_pages = array(
		'about_website' => 'helfi_about_page',
		'cookie_policy' => 'helfi_cookie_policy',
	);

	public function __construct(
		private Cache $cache,
		private string $current_language
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

	public function about_page(): Policy_Page
	{
		return $this->from_item_type( 'helfi_about_page' );
	}

	public function cookie_policy(): Policy_Page
	{
		return $this->from_item_type( 'helfi_cookie_policy' );
	}

	public function from_id( int $id ): ?Policy_Page
	{
		if ( $id ) {
			foreach ( $this->custom_pages as $filter_name => $page_type ) {
				$page_id = \apply_filters( "wordpress_helfi_cookie_consent_{$filter_name}_page_id", 0 );

				if ( $id === $page_id ) {
					return $this->from_item_type( $page_type );
				}
			}
		}

		return null;
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
				new $this->types[$type](
					$this->query_var(),
					$this->current_language
				)
			);
		}

		return $this->cache->get( $type );
	}
}
