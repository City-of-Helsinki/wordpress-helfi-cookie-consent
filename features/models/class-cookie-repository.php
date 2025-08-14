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
	}

	public function list_cookies(): array
	{
		if ( ! $this->cookies ) {
			$this->cookies = array_reduce(
				$this->known_cookies->list(),
				function( array $cookies, Known_Cookie_Data $data ) {
					$cookies[] = $this->factory->create_known_cookie( $data );
					return $cookies;
				},
				array_map(
					fn( $cookie ) => $this->factory->create_adapter( $cookie ),
					$this->database->cookies()
				)
			);
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
