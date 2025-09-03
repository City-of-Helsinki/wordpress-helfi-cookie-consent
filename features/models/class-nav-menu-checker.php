<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;

final class Nav_Menu_Checker
{
	private array $page_types;

	public function __construct(
		array $pages
	) {
		$this->page_types = array_map(
			fn( Policy_Page $page ) => $page->type(),
			$pages
		);
	}

	public function policy_page_types_in_menu_location( string $location ): array
	{
		return array_intersect(
			$this->policy_page_types(),
			$this->menu_item_types( $location )
		);
	}

	private function policy_page_types(): array
	{
		return $this->page_types;
	}

	private function menu_item_types( string $location ): array
	{
		return array_values(
			array_unique( (new Nav_Menu($location))->item_types() )
		);
	}
}
