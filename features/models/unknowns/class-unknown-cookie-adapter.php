<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Description_Translations;

final class Unknown_Cookie_Adapter implements Cookie_Adapter
{
	use Description_Translations;

	public function __construct(
		protected string $current_language,
		protected string $issuer,
		protected string $name,
		protected string $label,
		protected array $descriptions,
		protected array $retentions,
		protected Cookie_Type $type,
		protected Cookie_Category $category
	) {}

	public function issuer(): string
	{
		return $this->issuer;
	}

	public function name(): string
	{
		return $this->name;
	}

	public function label(): string
	{
		return $this->label;
	}

	public function description( string $language = '' ): string
	{
		return $this->translated_description( $language, $this->current_language )
			?: '';
	}

	public function retention( string $language = '' ): string
	{
		return $this->data[__FUNCTION__];
	}

	public function type(): Cookie_Type
	{
		return $this->type;
	}

	public function category(): Cookie_Category
	{
		return $this->category;
	}
}
