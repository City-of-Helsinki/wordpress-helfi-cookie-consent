<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Content;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class About_Page_En
{
	public function slug(): string
	{
		return 'about-the-website';
	}

	public function title(): string
	{
		return 'About the website';
	}

	public function excerpt(): string
	{
		return '<p>The page contains information on the use of cookies, rights of data subjects and text licensing.</p>';
	}

	public function body(): string
	{
		return '<h2 class="wp-block-heading">Cookies</h2>

		<p>We use cookies on our website. The purpose of cookies is to improve the content and performance of the website. With the feedback gained from cookies, we are able to develop the website and offer information that meets the needs of the city’s residents better.</p>

		<p>In the cookie settings, you can find more information on the cookies used and accept or reject their use. You can also change the cookie settings whenever you wish.</p>

		{{helfi_cookie_policy}}

		<h2 class="wp-block-heading">About cookies</h2>

		<p>A cookie is a small text file that your browser saves on your computer or mobile device when you visit a website. It will not harm your device or files. Cookies cannot be used to spread malware.</p>

		<p>The user data we gain through cookies helps us to ensure our website’s technical functionality and improve the quality of our digital services. They allow us to make our website more user-friendly and make it easier for you to find information.</p>

		<h2 class="wp-block-heading">Cookies and the website’s function</h2>

		<p>Essential cookies are needed for the website to function. The website may also use cookies that are not necessary for the website to function. These cookies are used for purposes such as personalisation, analytics and marketing. These types of cookies can only be used with the user’s consent.</p>

		<p>A cookie may be permanently saved on the user’s computer, in which case the website will always remember the user when they visit the website. A cookie may also be session-specific, in which case it will be removed when the browser is closed.</p>

		<h2 class="wp-block-heading">Register description and the rights of data subjects</h2>

		<p>For more information on the processing of your personal data, please see more about <a href="https://www.hel.fi/en/decision-making/information-on-helsinki/data-protection-and-information-management/data-protection">data protection</a>.</p>

		<h2 class="wp-block-heading">More information on accessibility</h2>

		<p>The Act on the Provision of Digital Services obliges the public sector to comply with the requirements of the European Union’s Accessibility Directive. Web Content Accessibility Guidelines (WCAG) is an international guideline for the accessibility of online content. By law, websites and applications must meet the WCAG 2.1 Level A and Level AA criteria. The City of Helsinki seeks to offer at least an AA level of digital services accessibility in accordance with the WCAG guidelines.</p>

		<p>Accessible digital services are easy to use for all users, including older people and people with various disabilities. When accessibility is taken into account, digital services can be used independently by as many people as possible.</p>

		<h2 class="wp-block-heading">Text licensed under Creative Commons</h2>

		<p>The text content of the hel.fi website is licensed under a <a href="https://creativecommons.org/licenses/by/4.0/deed.en">Creative Commons BY 4.0 license(Link leads to external service)</a>. The images on the website may not be used elsewhere without permission.</p>';
	}
}
