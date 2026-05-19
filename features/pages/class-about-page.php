<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Rule;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Tag;
use CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Content\About_Page_Fi;
use CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Content\About_Page_En;
use CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Content\About_Page_Sv;
use CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Traits\Has_Custom_Page_Id;

final class About_Page implements Policy_Page
{
	use Has_Custom_Page_Id;

	private array $content = array(
		'fi' => About_Page_Fi::class,
		'en' => About_Page_En::class,
		'sv' => About_Page_Sv::class,
	);

	private Cache $cache;

	public function __construct(
		private string $query_var,
		private string $current_language
	) {
		$this->cache = new Cache();
	}

	public function query_var(): string
	{
		return $this->query_var;
	}

	public function type(): string
	{
		return 'helfi_about_page';
	}

	public function title(): string
	{
		return $this->get_content( $this->current_language )->title();
	}

	public function content(): string
	{
		$content = \apply_filters(
			'wordpress_helfi_cookie_consent_about_page_content',
			array(
				'title' => $this->content_title(),
				'excerpt' => $this->content_excerpt(),
				'divider' => $this->content_divider(),
				'body' => $this->content_body(),
			)
		);

		$content = sprintf(
			'<div id="about-website" class="helfi-consent-page-content">
				<div class="container">
					%s
				</div>
			</div>',
			implode( PHP_EOL, $content )
		);

		$placeholders = $this->placeholders();

		return \wp_kses_post(
			str_replace(
				array_keys( $placeholders ),
				array_values( $placeholders ),
				$content
			)
		);
	}

	private function content_title(): string
	{
		$content = sprintf(
			'<h1 class="wp-block-heading title">%s</h1>',
			$this->get_content( $this->current_language )->title()
		);

		return \apply_filters( 'wordpress_helfi_cookie_consent_about_page_content_title', $content );
	}

	private function content_divider(): string
	{
		return '<div class="page-divider"></div>';
	}

	private function content_excerpt(): string
	{
		$content = sprintf(
			'<div class="hds-lead-in excerpt">%s</div>',
			$this->get_content( $this->current_language )->excerpt()
		);

		return \apply_filters( 'wordpress_helfi_cookie_consent_about_page_content_excerpt', $content );
	}

	private function content_body(): string
	{
		$content = sprintf(
			'<div class="body">%s</div>',
			$this->get_content( $this->current_language )->body()
		);

		return \apply_filters( 'wordpress_helfi_cookie_consent_about_page_content_body', $content );
	}

	private function placeholders(): array
	{
		$values = $this->placeholder_values();
		$handlers = $this->placeholder_handlers();

		$placeholders = array();
		foreach ( $values as $placeholder => $content ) {
			$placeholders[$placeholder] = $handlers[$placeholder]($content);
		}

		return $placeholders;
	}

	private function placeholder_values(): array
	{
		return array(
			'{{helfi_cookie_policy}}' => \apply_filters( 'wordpress_helfi_cookie_consent_policy_page_url', '' ),
		);
	}

	private function placeholder_handlers(): array
	{
		return array(
			'{{helfi_cookie_policy}}' => function( string $url ) {
				return $url ? sprintf(
					'<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
						<div class="wp-block-button">
							<a class="wp-block-button__link wp-element-button" href="%s">%s</a>
						</div>
					</div>',
					\esc_url( $url ),
					\esc_html( __( 'Open the cookie settings', 'wordpress-helfi-cookie-consent' ) )
				) : '';
			},
		);
	}

	public function template_path(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_path_to_php_file',
			array( 'features', 'pages', 'templates', 'cookie-policy' )
		);
	}

	public function slug( string $lang ): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_page_slug',
			$this->get_content( $lang )->slug()
			   ?: $this->get_content( 'en' )->slug(),
			$this,
			$lang
		);
	}

	public function url( string $lang ): string
	{
		$page_id = $this->custom_page_id_from_name( 'about_website' );
		$permalink = $page_id ? \get_permalink( $page_id ) : '';

		return $permalink ?: \home_url( $this->slug( $lang ) );
	}

	public function rewrite_tag(): ?Rewrite_Tag
	{
		return $this->custom_page_id_from_name( 'about_website' )
			? null
			: new Rewrite_Tag( $this->query_var(), '([^&]+)' );
	}

	public function rewrite_rules(): array
	{
		return $this->custom_page_id_from_name( 'about_website' )
			? array()
			: array_map(
			   fn( string $lang ) => new Rewrite_Rule(
				   $this->query_var(),
				   $this->slug( $lang ),
				   $this->type()
			   ),
			   array_keys( $this->content )
		   );
	}

	private function get_content( string $lang ): mixed
	{
		if ( $this->cache->has( $lang ) ) {
			return $this->cache->get( $lang );
		}

		$content = $this->content[$lang] ?? $this->content['en'];

		return $this->cache->put( $lang, new $content() );
	}
}
