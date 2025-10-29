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
			$slug = ($lang === $default_lang && $default_hidden)
				? $page->slug( $lang )
				: \trailingslashit( $lang ) . $page->slug( $lang );

			$modified[] = new Rewrite_Rule(
				$page->query_var(),
				$slug,
				$page->type()
			);

			$this->cache_page_config( $page, $lang, $slug );
		}

		return $modified;
	}

	private function cache_page_config( Policy_Page $page, string $lang, string $slug ): void
	{
		if ( ! isset( $this->page_slugs[$page->type()] ) ) {
			$this->page_slugs[$page->type()] = array();
		}

		$this->page_slugs[$page->type()][$lang] = $slug;
		$this->query_vars[$page->type()] = $page->query_var();
	}

	public function policy_page_language_link( ?string $url, ?string $lang, ?string $locale ): ?string
	{
		foreach ( $this->query_vars as $page_type => $query_var ) {
			if ( $this->should_provide_language_link( $query_var, $page_type, $lang ) ) {
				return $this->page_url( $page_type, $lang );
			}
		}

		return $url;
	}

	public function policy_page_slug( string $slug, Policy_Page $page, string $lang ): string
	{
		return $this->page_slugs[$page->type()][$lang] ?? $slug;
	}

	private function should_provide_language_link( string $query_var, string $page_type, string $lang ): bool
	{
		return \get_query_var( $query_var, false ) === $page_type
			&& ! empty( $this->page_slugs[$page_type][$lang] );
	}

	private function page_url( string $page_type, string $lang ): string
	{
		return \home_url( sprintf( '/%s', $this->page_slugs[$page_type][$lang] ) );
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
