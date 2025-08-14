<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Description_Translations;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Label_Translations;

final class Marketing_Cookie_Category implements Cookie_Category
{
	use Description_Translations;
	use Label_Translations;

	protected array $labels = array(
		'fi' => 'Markkinointi',
		'sv' => 'Marknadsföring',
		'en' => 'Marketing',
	);

	protected array $descriptions = array(
		'fi' => 'Markkinointievästeet ovat evästeitä tai muita paikallisia tallennusmuotoja, joita käytetään käyttäjäprofiilien luomiseen mainosten näyttämiseksi tai käyttäjän seuraamiseksi tällä verkkosivustolla tai useilla verkkosivustoilla vastaavissa markkinointitarkoituksissa.',
		'sv' => 'Marknadsföringscookies är cookies eller någon annan form av lokal lagring som används för att skapa användarprofiler för att visa reklam eller för att spåra användaren på denna webbplats eller på flera webbplatser för liknande marknadsföringssyften.',
		'en' => 'Marketing cookies are cookies or any other form of local storage, used to create user profiles to display advertising or to track the user on this website or across several websites for similar marketing purposes.',
	);

	public function __construct(
		protected string $current_language
	) {}

	public function name(): string
	{
		return 'marketing';
	}

	public function label( string $language = '' ): string
	{
		return $this->translated_label( $language, $this->current_language )
			?: __( 'Marketing', 'wordpress-helfi-cookie-consent' );
	}

	public function description( string $language = '' ): string
	{
		return $this->translated_description( $language, $this->current_language )
			?: __( 'Marketing cookies are cookies or any other form of local storage, used to create user profiles to display advertising or to track the user on this website or across several websites for similar marketing purposes.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return false;
	}
}
