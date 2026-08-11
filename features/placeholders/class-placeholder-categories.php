<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;

final class Placeholder_Categories
{
	private array $categories;

	public function __construct(
		Cookie_Category ...$categories
	) {
		$this->categories = $categories;
	}

	public function list(): array
	{
		return $this->categories;
	}

	public function labels_text(): string
	{
		$cat_count = count( $this->categories );
		$categories = '';
		$cat_sep = ', ';

		foreach ( $this->categories as $cat_i => $category ) {
			if ( $cat_i > 0 ) {
				if ( ($cat_i + 1) === $cat_count ) {
					$cat_sep = sprintf( ' %s ', __( 'and', 'wordpress-helfi-cookie-consent' ) );
				}

				$categories .= $cat_sep;
			}

			$categories .= mb_strtolower( $category->label() );
		}

		return $categories;
	}

	public function names(): array
	{
		return array_values( array_map(
			fn( Cookie_Category $category ) => $category->name(),
			$this->categories
		) );
	}
}
