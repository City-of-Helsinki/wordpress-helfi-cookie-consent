<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class Cookie_Repository
{
	private array $cookies;
	private array $provider_categories;

	public function __construct(
		private Cookie_Database $database,
		private Cookie_Adapter_Factory $factory,
		private Known_Cookies $known_cookies
	) {
		$this->refresh();
	}

	public function refresh(): void
	{
		$this->cookies = array();
		$this->provider_categories = array();
	}

	public function list_cookies(): array
	{
		if ( ! $this->cookies ) {
			$this->cookies = array_values(
				array_merge(
					$this->create_cookie_adapters(),
					$this->create_known_cookies()
				)
			);
		}

		return $this->cookies;
	}

	public function provider_categories(): array
	{
		if ( ! $this->provider_categories ) {
			$this->provider_categories = array_reduce(
				$this->list_cookies(),
				function( array $out, Cookie_Adapter $cookie ): array {
					if ( ! isset( $out[$cookie->issuer()] ) ) {
						$out[$cookie->issuer()] = array();
					}

					$category = $cookie->category();
					if ( ! isset( $out[$cookie->issuer()][$category->name()] ) ) {
						$out[$cookie->issuer()][$category->name()] = $category;
					}

					return $out;
				},
				array()
			);
		}

		return $this->provider_categories;
	}

	private function create_known_cookies(): array
	{
		return array_reduce(
			$this->known_cookies->list(),
			function( array $cookies, Known_Cookie_Data $data ): array {
				$cookie = $this->factory->create_known_cookie( $data );

				$key = $cookie->type()->name() . $cookie->name();
				$cookies[$key] = $cookie;

				return $cookies;
			},
			array()
		);
	}

	private function create_cookie_adapters(): array
	{
		return array_reduce(
			$this->database->cookies(),
			function( array $cookies, mixed $data ): array {
				$cookie = $this->create_cookie_adapter( $data );

				$key = $cookie->type()->name() . $cookie->name();
				$cookies[$key] = $cookie;

				return $cookies;
			},
			array()
		);
	}

	private function create_cookie_adapter( mixed $data ): Cookie_Adapter
	{
		return $this->factory->create_adapter( $data );
	}

	public function cookie_lists(): Cookie_List_Collection
	{
		$lists = array_map(
			fn( array $data ) => new Cookie_List(
				$data['category'],
				...$data['cookies']
			),
			array_reduce(
				$this->list_cookies(),
				function( array $sorted, Cookie_Adapter $cookie ): array {
					$category = $cookie->category();

					if ( ! isset( $sorted[$category->name()] ) ) {
						$sorted[$category->name()] = array(
							'category' => $category,
							'cookies' => array(),
						);
					}

					$sorted[$category->name()]['cookies'][] = $cookie;

					return $sorted;
				},
				array()
			)
		);

		return new Cookie_List_Collection( ...$lists );
	}
}
