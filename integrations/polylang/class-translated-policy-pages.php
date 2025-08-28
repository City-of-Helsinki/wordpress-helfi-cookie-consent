<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Polylang;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Rule;

final class Translated_Policy_Pages
{
	private array $page_slugs;
	private array $query_vars;

	public function __construct()
	{
		$this->page_slugs = array();
		$this->query_vars = array();
	}

	public function translate_rewrite_rules( array $rules, Policy_Page $page ): array
	{
		$default_lang = $this->default_language();
		$default_hidden = $this->default_language_hidden();

		$modified = array();
		foreach ( $this->active_languages_slugs() as $lang ) {
			if ( isset( $rules[$lang] ) ) {
				$slug = ($lang === $default_lang && $default_hidden)
					? $page->slug( $lang )
					: $lang . '/' . $page->slug( $lang );

				$modified[$lang] = new Rewrite_Rule(
					$page->query_var(),
					$slug,
					$page->type()
				);

				$this->page_slugs[$lang] = $slug;
				$this->query_vars[$page->query_var()] = $page->type();
			}
		}

		return $modified;
	}

	public function policy_page_language_link( ?string $url, ?string $slug, ?string $locale ): ?string
	{
		foreach ( $this->query_vars as $key => $value ) {
			if ( $this->should_provide_language_link( $key, $value, $slug ) ) {
				return $this->page_url( $slug );
			}
		}

		return $url;
	}

	public function policy_page_slug( string $slug, Policy_Page $page, string $lang ): string
	{
		return $this->page_slugs[$lang] ?? $slug;
	}

	private function should_provide_language_link( string $key, string $value, string $lang ): bool
	{
		return \get_query_var( $key, false ) === $value
			&& ! empty( $this->page_slugs[$lang] );
	}

	private function page_url( string $lang ): string
	{
		return \home_url( sprintf( '/%s', $this->page_slugs[$lang] ) );
	}

	private function default_language_hidden(): bool
	{
		return (bool) \PLL()->options['hide_default'];
	}

	private function default_language(): string
	{
		return \pll_default_language( 'slug' );
	}

	private function active_languages_slugs(): array
	{
		return array_column(
			\pll_the_languages( array( 'raw' => 1 ) ),
			'slug'
		);
	}
}
