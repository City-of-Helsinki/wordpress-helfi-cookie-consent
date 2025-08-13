<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Categories;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Description_Translations;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Label_Translations;

final class Functional_Cookie_Category implements Cookie_Category
{
	use Description_Translations;
	use Label_Translations;

	protected array $labels = array(
		'fi' => 'Välttämättömät toiminnalliset evästeet',
		'sv' => 'Nödvändiga funktionella cookies',
		'en' => 'Essential cookies',
	);

	protected array $description = array(
		'fi' => 'Välttämättömät evästeet auttavat tekemään verkkosivustosta käyttökelpoisen sallimalla perustoimintoja, kuten sivulla siirtymisen ja sivuston suojattujen alueiden käytön. Verkkosivusto ei toimi kunnolla ilman näitä evästeitä eikä niihin tarvita suostumusta.',
		'sv' => 'Nödvändiga cookies hjälper till att göra webbplatsen användbar genom att tillåta grundläggande funktioner som att navigera på sidan och använda de skyddade områdena på webbplatsen. Webbplatsen fungerar inte korrekt utan dessa cookies och kräver inte samtycke.',
		'en' => 'Essential cookies help to make the website usable by allowing basic functions, navigating the page and using the protected areas of the site. The website will not work properly without these cookies and their consent is not required.',
	);

	public function __construct(
		protected string $current_language
	) {}

	public function name(): string
	{
		return 'functional';
	}

	public function label( string $language = '' ): string
	{
		return $this->translated_label( $language, $this->current_language )
			?: __( 'Functional', 'wordpress-helfi-cookie-consent' );
	}

	public function description( string $language = '' ): string
	{
		return $this->translated_description( $language, $this->current_language )
			?: __( 'Functional description.', 'wordpress-helfi-cookie-consent' );
	}

	public function required(): bool
	{
		return true;
	}
}
