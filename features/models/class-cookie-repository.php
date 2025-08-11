<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter_Factory;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;

final class Cookie_Repository
{
	private array $cookies;

	public function __construct(
		private Cookie_Database $database,
		private Cookie_Adapter_Factory $factory
	) {
		$this->refresh();
	}

	public function refresh(): void
	{
		$this->cookies = array();
	}

	public function list_cookies(): array
	{
		if ( ! $this->cookies ) {
			$this->cookies = array_map(
				fn( $cookie ) => $this->factory->create_adapter( $cookie ),
				$this->database->cookies()
			);

			$this->cookies[] = $this->factory->create_consents_cookie();
		}

		return $this->cookies;
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
				function( array $sorted, Cookie_Adapter $cookie ) {
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
