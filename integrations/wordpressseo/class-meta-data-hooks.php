<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\WordPressSeo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use Yoast\WP\SEO\Context\Meta_Tags_Context;

final class Meta_Data_Hooks
{
	public function __construct(
		private string $page_title,
		private string $title_separator,
		private string $policy_page_url,
		private string $current_language
	) {}

	public function title( string $title ): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_page_meta_title',
			$this->page_title,
			$this->title_separator
		);
	}

	public function url( string $url ): string
	{
		return $this->policy_page_url;
	}

	public function image_url( string $url ): string
	{
		return '';
	}

	public function breadcrumbs( array $crumbs ): array
	{
		return array(
			array_shift( $crumbs ),
			array(
				'id' => 0,
				'text' => $this->page_title,
				'url' => $this->policy_page_url,
			)
		);
	}

	public function schema_graph( array $graph, Meta_Tags_Context $context ): array
	{
		$website = null;
		$breadcrumbs = null;

		foreach ( $graph as $piece ) {
			if ( $this->is_website_graph_piece( $piece ) ) {
				$website = $piece;
			} else if ( $this->is_breadcrumbs_graph_piece( $piece ) ) {
				$breadcrumbs = $piece;
				$breadcrumbs['@id'] = $this->policy_page_url . '#breadcrumb';
			}
		}

		return array_filter( array(
			$this->web_page_graph_piece( $website, $breadcrumbs ),
			$website,
			$breadcrumbs
		) );
	}

	private function web_page_graph_piece( ?array $website, ?array $breadcrumbs ): array
	{
		$piece = array(
			'@type' => 'WebPage',
			'@id' => $this->policy_page_url,
			'url' => $this->policy_page_url,
			'name' => $this->page_title,
			'description' => $this->page_title,
			'inLanguage' => $this->current_language,
		);

		if ( $website ) {
			$piece['isPartOf'] = array( '@id' => $website['@id'] );
		}

		if ( $breadcrumbs ) {
			$piece['breadcrumb'] = array( '@id' => $breadcrumbs['@id'] );
		}

		return $piece;
	}

	private function is_website_graph_piece( array $piece ): bool
	{
		return isset( $piece['@type'] ) && 'WebSite' === $piece['@type'];
	}

	private function is_breadcrumbs_graph_piece( array $piece ): bool
	{
		return isset( $piece['@type'] ) && 'BreadcrumbList' === $piece['@type'];
	}
}
