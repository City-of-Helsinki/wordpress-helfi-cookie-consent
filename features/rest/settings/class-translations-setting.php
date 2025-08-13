<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Translations_Setting implements Setting_Interface
{
	public function name(): string
	{
		return 'translations';
	}

	public function value(): mixed
	{
		return array_reduce(
			$this->handlers(),
			function( array $translations, string $handler ) {
				$translations[$handler] = $this->$handler();

				return $translations;
			},
			array()
		);
	}

	private function handlers(): array
	{
		return array(
			'acceptedAt',
			'approveAllConsents',
			'approveOnlyRequiredConsents',
			'approveRequiredAndSelectedConsents',
			'bannerAriaLabel',
			'description',
			'formHeading',
			'formText',
			'heading',
			'hideDetails',
			'hideCookieSettings',
			'highlightedGroup',
			'highlightedGroupAria',
			'notificationAriaLabel',
			'settingsSaved',
			'showCookieSettings',
			'showDetails',
			'storageType1',
			'storageType2',
			'storageType3',
			'storageType4',
			'storageType5',
			'tableHeadingsDescription',
			'tableHeadingsExpiration',
			'tableHeadingsHostName',
			'tableHeadingsName',
			'tableHeadingsType',
		);
	}

	private function acceptedAt(): array
	{
		return array(
			'fi' => 'Olet hyväksynyt tämän kategorian: {{date}} klo {{time}}.',
	        'sv' => 'Du har accepterat denna kategori: {{date}} kl. {{time}}.',
	        'en' => 'You have accepted this category: {{date}} at {{time}}.'
		);
	}

	private function approveAllConsents(): array
	{
		return array(
			'fi' => 'Hyväksy kaikki evästeet',
	        'sv' => 'Acceptera alla kakor',
	        'en' => 'Accept all cookies'
		);
	}

	private function approveOnlyRequiredConsents(): array
	{
		return array(
			'fi' => 'Hyväksy vain välttämättömät evästeet',
	        'sv' => 'Acceptera endast nödvändiga',
	        'en' => 'Accept required cookies only'
		);
	}

	private function approveRequiredAndSelectedConsents(): array
	{
		return array(
			'fi' => 'Hyväksy valitut evästeet',
	        'sv' => 'Acceptera valda kakor',
	        'en' => 'Accept selected cookies'
		);
	}

	private function bannerAriaLabel(): array
	{
		return array(
			'fi' => 'Evästeasetukset',
	        'sv' => 'Inställningar för kakor',
	        'en' => 'Cookie settings'
		);
	}

	private function description(): array
	{
		// TODO: from site settings
		return array(
			'fi' => 'Tämä sivusto käyttää välttämättömiä evästeitä sivun perustoimintojen ja suorituskyvyn varmistamiseksi. Lisäksi käytämme kohdennusevästeitä käyttäjäkokemuksen parantamiseksi, analytiikkaan ja yksilöidyn sisällön näyttämiseen.',
	        'sv' => 'Denna webbplats använder obligatoriska kakor för att säkerställa de grundläggande funktionerna och prestandan. Dessutom använder vi inriktningskakor för bättre användarupplevelse, analytik och individualiserat innehåll.',
	        'en' => 'This website uses required cookies to ensure the basic functionality and performance. In addition, we use targeting cookies to improve the user experience, perform analytics and display personalised content.'
		);
	}

	private function formHeading(): array
	{
		return array(
			'fi' => 'Tietoa sivustolla käytetyistä evästeistä',
	        'sv' => 'Information om kakor som används på webbplatsen',
	        'en' => 'About the cookies used on the website'
		);
	}

	private function formText(): array
	{
		return array(
			'fi' => 'Sivustolla käytetyt evästeet on luokiteltu käyttötarkoituksen mukaan. Alla voit lukea eri luokista ja sallia tai kieltää evästeiden käytön.',
	        'sv' => 'Kakorna som används på webbplatsen har klassificerats enligt användningsändamål. Du kan läsa om de olika klasserna och acceptera eller förbjuda användningen av kakor.',
	        'en' => 'The cookies used on the website have been classified according to their intended use. Below, you can read about the various categories and accept or reject the use of cookies.'
		);
	}

	private function heading(): array
	{
		return array(
			'fi' => '{{siteName}} käyttää evästeitä',
	        'sv' => '{{siteName}} använder kakor',
	        'en' => '{{siteName}} uses cookies'
		);
	}

	private function hideDetails(): array
	{
		return array(
			'fi' => 'Piilota yksityiskohdat',
	        'sv' => 'Stänga detaljer',
	        'en' => 'Hide details'
		);
	}

	private function hideCookieSettings(): array
	{
		return array(
			'fi' => 'Piilota evästeasetukset',
	        'sv' => 'Stänga kakinställningarna',
	        'en' => 'Hide cookie settings'
		);
	}

	private function highlightedGroup(): array
	{
		return array(
			'fi' => 'Sinun on hyväksyttävä tämä kategoria, jotta voit näyttää valitsemasi sisällön.',
	        'sv' => 'Du måste acceptera den här kategorin för att visa innehållet du har valt.',
	        'en' => 'You need to accept this category to display the content you have selected.'
		);
	}

	private function highlightedGroupAria(): array
	{
		return array(
			'fi' => 'Hyvä tietää kategorialle: {{title}}',
	        'sv' => 'Bra att veta för kategorin: {{title}}',
	        'en' => 'Good to know for category: {{title}}'
		);
	}

	private function notificationAriaLabel(): array
	{
		return array(
			'fi' => 'Ilmoitus',
			'sv' => 'Meddelande',
			'en' => 'Annoucement',
		);
	}

	private function settingsSaved(): array
	{
		return array(
			'fi' => 'Asetukset tallennettu!',
			'sv' => 'Inställningar sparade!',
			'en' => 'Settings saved!'
		);
	}

	private function showCookieSettings(): array
	{
		return array(
			'fi' => 'Näytä evästeasetukset',
	        'sv' => 'Visa kakinställningarna',
	        'en' => 'Show cookie settings'
		);
	}

	private function showDetails(): array
	{
		return array(
			'fi' => 'Näytä yksityiskohdat',
	        'sv' => 'Visa detaljer',
	        'en' => 'Show details'
		);
	}

	private function storageType1(): array
	{
		return array(
			'fi' => 'Eväste',
			'sv' => 'Kakan',
			'en' => 'Cookie',
		);
	}

	private function storageType2(): string
	{
		return 'localStorage';
	}

	private function storageType3(): string
	{
		return 'sessionStorage';
	}

	private function storageType4(): string
	{
		return 'IndexedDB';
	}

	private function storageType5(): string
	{
		return 'Cache Storage';
	}

	private function tableHeadingsDescription(): array
	{
		return array(
			'fi' => 'Käyttötarkoitus',
	        'sv' => 'Användning',
	        'en' => 'Purpose of use'
		);
	}

	private function tableHeadingsExpiration(): array
	{
		return array(
			'fi' => 'Voimassaoloaika',
	        'sv' => 'Giltighetstid',
	        'en' => 'Period of validity'
		);
	}

	private function tableHeadingsHostName(): array
	{
		return array(
			'fi' => 'Evästeen asettaja',
	        'sv' => 'Den som lagrat kakan',
	        'en' => 'Cookie set by'
		);
	}

	private function tableHeadingsName(): array
	{
		return array(
			'fi' => 'Nimi',
	        'sv' => 'Namn',
	        'en' => 'Name'
		);
	}

	private function tableHeadingsType(): array
	{
		return array(
			'fi' => 'Tyyppi',
	        'sv' => 'Typ',
	        'en' => 'Type'
		);
	}

}
