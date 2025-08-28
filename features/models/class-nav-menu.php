<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Nav_Menu
{
	private int $menu_id;

	public function __construct(
		private string $location
	) {
		$this->menu_id = $this->determine_menu_id();
	}

	public function location(): string
	{
		return $this->location;
	}

	public function id(): int
	{
		return $this->menu_id;
	}

	public function items(): array
	{
		$items = \wp_get_nav_menu_items( $this->menu_id );

		return is_array( $items ) ? $items : array();
	}

	public function item_types(): array
	{
		return array_map( fn( $item ) => $item->type, $this->items() );
	}

	private function determine_menu_id(): int
	{
		foreach ( \get_nav_menu_locations() as $location => $id ) {
			if ( $location === $this->location ) {
				return $id;
			}
		}

		return 0;
	}
}
