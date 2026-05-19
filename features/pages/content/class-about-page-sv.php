<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class About_Page_Sv
{
	public function slug(): string
	{
		return 'information-om-webbplatsen';
	}

	public function title(): string
	{
		return 'Information om webbplatsen';
	}

	public function excerpt(): string
	{
		return '<p>Information om kakor på webbplatsen, registrerades rättigheter och textinnehållets licensen.</p>';
	}

	public function body(): string
	{
		return '<h2 class="wp-block-heading">Kakor</h2>

		<p>Vi använder kakor på vår webbplats. Syftet med kakorna är att förbättra webbplatsens innehåll och prestanda. Med hjälp av responsen kan vi utveckla webbplatsen och erbjuda information som bättre möter stadsbornas behov.</p>

		<p>I kakinställningarna kan du läsa mer om vilka kakor som används samt godkänna eller hindra användningen av dem. Du kan även ändra kakinställningarna när du vill.</p>

		{{helfi_cookie_policy}}

		<h2 class="wp-block-heading">Kakor och webbplatsens funktion</h2>

		<p>En kaka (eng. cookie) är en liten textfil som webbläsaren sparar i användarens dator eller mobila enhet när hen besöker en webbplats. Den skadar inte användarens enhet eller filer. Kakor kan inte användas för att sprida skadeprogram.</p>

		<p>Användarinformationen som fås från kakorna hjälper oss att säkerställa webbplatsens funktionalitet och förbättra kvaliteten på våra digitala tjänster. Med hjälp av dem kan vi utveckla webbplatsens användarvänlighet och göra det lättare att hitta information.</p>

		<h2 class="wp-block-heading">Kakor och webbplatsens funktion</h2>

		<p>Nödvändiga kakor behövs för att webbplatsen ska fungera. Dessutom kan webbplatsen använda kakor som inte är nödvändiga för webbplatsens funktion. Dessa kakor används exempelvis till profilering, analys och marknadsföring. Sådana kakor kan endast användas med användarens tillåtelse.</p>

		<p>Kakor kan sparas permanent på användarens enhet. Då kommer webbplatsen ihåg användaren alltid när hen besöker webbplatsen. Kakor kan också vara sessionsspecifika, vilket innebär att de raderas efter att webbläsaren stängs.</p>

		<p>Kakorna kan komma från första eller tredje part. Kakor från första part läggs in av den webbplats som användaren besöker. Kakor från tredje part läggs in av utomstående parter. Sådana är till exempel sociala medietjänsters kakor som är inbäddade i webbplatsen.</p>

		<h2 class="wp-block-heading">Registerbeskrivning och den registrerades rättigheter</h2>

		<p>Vi följer lagen om tillhandahållande av digitala tjänster. <a href="https://www.hel.fi/sv/beslutsfattande-och-forvaltning/information-om-helsingfors/dataskydd-och-informationshantering/dataskydd">Mer information om behandlingen av dina personuppgifter</a>.</p>

		<h2 class="wp-block-heading">Mer information om tillgänglighet</h2>

		<p>Lagen om tillhandahållande av digitala tjänster förpliktar den offentliga sektorn att iaktta kraven i Europeiska unionens tillgänglighetsdirektiv. WCAG (Web Content Accessibility Guidelines) är en internationell anvisning om tillgängligheten av webbinnehåll. Enligt lagen ska webbplatser och applikationer uppfylla kriterierna för A- och AA-nivå i WCAG 2.1-anvisningen. Helsingfors stad syftar till att uppnå minst AA-nivån enligt WCAG-anvisningarna när det gäller tillgängligheten av digitala tjänster.</p>

		<p>Tillgängliga digitala tjänster är lätt användbara för alla användare, inklusive äldre och personer med olika slags funktionsnedsättningar. När tillgängligheten har beaktats kan så många som möjligt använda digitala tjänster på egen hand.</p>

		<h2 class="wp-block-heading">Textinnehållet licensierat med Creative Commons</h2>

		<p>Textinnehållet på webbplatsen är licensierat med <a href="https://creativecommons.org/licenses/by/4.0/deed.sv">Creative Commons BY 4.0-licensen(Länk leder till extern tjänst)</a>. Bilderna på webbplatsen får inte användas annanstans utan tillstånd.</p>';
	}
}
