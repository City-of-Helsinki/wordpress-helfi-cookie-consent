<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Nav_Menu
{
	private int $menu_id;
	private string $menu_name;

	public function __construct(
		private string $location
	) {
		$this->menu_id = $this->determine_menu_id();
		$this->menu_name = $this->determine_menu_name();
	}

	public function location(): string
	{
		return $this->location;
	}

	public function id(): int
	{
		return $this->menu_id;
	}

	public function name(): string
	{
		return $this->menu_name;
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

	private function determine_menu_name(): string
	{
		if ( $this->menu_id ) {
			$menu = \wp_get_nav_menu_object( $this->menu_id );

			return ! empty( $menu->name ) ? $menu->name : '';
		}

		return '';
	}
}
