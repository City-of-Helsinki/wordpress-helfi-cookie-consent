<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Description_Translations;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Label_Translations;

final class Preferences_Cookie_Category implements Cookie_Category
{
	use Description_Translations;
	use Label_Translations;

	protected array $labels = array(
		'fi' => 'Personointi',
		'sv' => 'Preferens',
		'en' => 'Preferences',
	);

	protected array $descriptions = array(
		'fi' => 'Mieltymysevästeet mukauttavat sivuston ulkoasua ja toimintaa käyttäjän aiemman käytön perusteella.',
		'sv' => 'Preferenscookies ändrar webbplatsens utseende och funktioner enligt användarens tidigare användning.',
		'en' => 'Preference cookies modify the visuals and functions of the website based on the user\'s previous sessions.',
	);

	public function __construct(
		protected string $current_language
	) {}

	public function name(): string
	{
		return 'preferences';
	}

	public function label( string $language = '' ): string
	{
		return $this->translated_label( $language, $this->current_language )
			?: __( 'Preferences', 'wordpress-helfi-cookie-consent' );
	}

	public function description( string $language = '' ): string
	{
		return $this->translated_description( $language, $this->current_language )
			?: __( 'Preference cookies modify the visuals and functions of the website based on the user\'s previous sessions.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return false;
	}
}
