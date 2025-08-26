<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Rule;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Tag;

final class Custom_Page_Hooks
{
	public function __construct(
		private Policy_Page_Factory $factory,
		private string $current_language
	) {}

	public function helfi_custom_pages(): array
	{
		return $this->factory->all();
	}

	public function wp_setup_nav_menu_item( $menu_item )
	{
		$page = $this->factory->from_item_type( $menu_item->type ?? '' );

		if ( $page ) {
			$menu_item->title = $page->title();
			$menu_item->url = $this->page_url( $page );
		}

		return $menu_item;
	}

	public function wp_nav_menu_objects( array $items ): array
	{
		foreach ($items as &$item) {
			$page = $this->factory->from_item_type( $item->type ?? '' );

			if ( $page ) {
				$item->title = $page->title();
				$item->url = $this->page_url( $page );
			}
		}

		return $items;
	}

	public function register_rewrites(): void
	{
		foreach( $this->factory->all() as $page ) {
			$this->register_rewrite_tag( $page->rewrite_tag() );

			array_map(
				array( $this, 'register_rewrite_rule' ),
				\apply_filters(
					'wordpress_helfi_cookie_consent_policy_page_rewrite_rules',
					$page->rewrite_rules(),
					$page
				)
			);
		}
	}

	public function policy_page_template( string $template ): string
	{
		$page = $this->factory->from_item_type(
			\get_query_var( $this->factory->query_var(), '' )
		);

		return $page ? $page->template_path() : $template;
	}

	public function policy_page_content(): void
	{
		$page = $this->factory->from_item_type(
			\get_query_var( $this->factory->query_var(), '' )
		);

		if ( $page ) {
			echo $page->content();
		}
	}

	private function register_rewrite_tag( Rewrite_Tag $tag ): void
	{
		\add_rewrite_tag( $tag->tag(), $tag->regex() );
	}

	private function register_rewrite_rule( Rewrite_Rule $rule ): void
	{
		\add_rewrite_rule( $rule->regex(), $rule->query(), $rule->priority() );
	}

	private function page_url( Policy_Page $page ): string
	{
		return \home_url( \apply_filters(
			'wordpress_helfi_cookie_consent_policy_page_slug',
			'/' . ($page->slug( $this->current_language ) ?: $page->slug( 'en' )),
			$page,
			$this->current_language
		) );
	}
}
