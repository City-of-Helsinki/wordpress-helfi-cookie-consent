<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Description_Translations;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Label_Translations;

final class Statistics_Anonymous_Cookie_Category implements Cookie_Category
{
	use Description_Translations;
	use Label_Translations;

	protected array $labels = array(
		'fi' => 'Tilastointi (anonyymi)',
		'sv' => 'Statistik (anonym)',
		'en' => 'Statistics (anonymous)',
	);

	protected array $descriptions = array(
		'fi' => 'Tilastointievästeiden keräämää tietoa käytetään verkkosivuston kehittämiseen.',
		'sv' => 'De uppgifter statistikkakorna samlar in används för att utveckla webbplatsen.',
		'en' => 'The information collected by statistics cookies is used for developing the website.',
	);

	public function __construct(
		protected string $current_language
	) {}

	public function name(): string
	{
		return 'statistics';
	}

	public function label( string $language = '' ): string
	{
		return $this->translated_label( $language, $this->current_language )
			?: __( 'Statistics (anonymous)', 'wordpress-helfi-cookie-consent' );
	}

	public function description( string $language = '' ): string
	{
		return $this->translated_description( $language, $this->current_language )
			?: __( 'The information collected by statistics cookies is used for developing the website.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return false;
	}
}
