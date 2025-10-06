<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class About_Page_Fi
{
	public function slug(): string
	{
		return 'tietoa-sivustosta';
	}

	public function title(): string
	{
		return 'Tietoa sivustosta';
	}

	public function excerpt(): string
	{
		return '<p>Tällä sivulla kerrotaan sivuston käyttämistä evästeistä, henkilötietojen käsittelystä ja sisältöjen käyttöoikeudesta.</p>';
	}

	public function body(): string
	{
		return '<h2>Evästeet tällä sivustolla</h2>

		<p>Käytämme sivustollamme evästeitä. Evästeiden tarkoituksena on parantaa sivuston sisältöjä ja suorituskykyä. Evästeistä saatavan palautteen avulla pystymme kehittämään sivustoa ja tarjoamaan paremmin kaupunkilaisten tarpeisiin vastaavaa tietoa.</p>

		<p>Evästeasetuksista voit lukea lisätietoja käytetyistä evästeistä, hyväksyä tai estää niiden käytön. Voit myös muuttaa evästeasetuksia aina halutessasi.</p>

		{{helfi_cookie_policy}}

		<h2>Tietoa evästeistä</h2>

		<p>Eväste (engl. cookie) on pienikokoinen tekstitiedosto, jonka verkkoselain tallentaa käyttäjän tietokoneelle tai mobiililaitteelle, kun vierailet verkkosivustolla. Se ei vahingoita käyttäjän laitetta tai tiedostoja. Evästeitä ei voi käyttää haittaohjelmien levittämiseen.</p>

		<p>Evästeistä saatava käyttäjätieto auttaa meitä varmistamaan sivuston teknisen toimivuuden ja parantamaan digitaalisten palveluidemme laatua. Niiden avulla voimme kehittää sivuston käyttäjäystävällisyyttä ja helpottaa tiedon löytymistä.</p>

		<h2>Evästeet ja sivuston toiminta</h2>

		<p>Välttämättömiä evästeitä tarvitaan, jotta sivusto toimii. Sivustolla voidaan käyttää lisäksi evästeitä, jotka eivät ole välttämättömiä sivuston toimimisen kannalta. Näitä evästeitä käytetään esimerkiksi personointiin, tilastointiin ja markkinointiin. Tällaisia evästeitä voidaan käyttää vain käyttäjän suostumuksella.</p>

		<p>Eväste voidaan tallentaa käyttäjän laitteelle pysyvästi, jolloin verkkosivu muistaa käyttäjän aina tämän vieraillessa sivustolla. Eväste voi olla myös istuntokohtainen, jolloin se poistuu selaimen sulkemisen jälkeen.</p>

		<p>Evästeet voivat olla ensimmäisen tai kolmannen osapuolen evästeitä. Ensimmäisen osapuolen evästeet asetetaan samalta sivustolta, jolla käyttäjä vierailee. Kolmannen osapuolen evästeet puolestaan asettaa ulkopuolinen taho. Tällaisia ovat esimerkiksi sivustolle upotettujen sosiaalisen median palveluiden evästeet.</p>

		<h2>Lisätietoa tietosuojasta ja rekisteröidyn oikeuksista</h2>

		<p>Lisätietoa henkilötietojen käsittelystä sekä rekisteröidyn oikeuksista löydät <a href="https://hel.fi/tietosuoja">tietosuojasivulta</a>.</p>

		<h2>Lisätietoa saavutettavuudesta</h2>

		<p>Laki digitaalisten palvelujen tarjoamisesta velvoittaa julkista sektoria noudattamaan Euroopan Unionin saavutettavuusdirektiivin vaatimuksia. WCAG (Web Content Accessibility Guidelines) on kansainvälinen ohjeistus verkkosisältöjen saavutettavuudesta. Lain mukaan verkkosivustojen ja sovellusten on täytettävä WCAG 2.1 -ohjeistuksen A- ja AA-tason kriteerit. Helsingin kaupungin tavoitteena on pyrkiä digitaalisten palveluiden saavutettavuudessa vähintään WCAG-ohjeistuksen mukaiseen AA-tasoon.</p>

		<p>Saavutettavat digitaaliset palvelut ovat helppokäyttöisiä kaikille käyttäjille, myös ikääntyneille ja eri tavoin toimintarajoitteisille ihmisille. Kun saavutettavuus on huomioitu, mahdollisimman monet ihmiset voivat käyttää digitaalisia palveluita itsenäisesti.</p>

		<h2>Tekstisisältöjen käyttöön riittää maininta lähteestä</h2>

		<p>Sivuston tekstisisällöt on lisensoitu <a href="https://creativecommons.org/licenses/by/4.0/deed.fi">Creative Commons BY 4.0 lisenssillä (Linkki johtaa ulkoiseen palveluun)</a>. Sivuston kuvia ei saa käyttää muualla ilman lupaa.</p>';
	}
}
