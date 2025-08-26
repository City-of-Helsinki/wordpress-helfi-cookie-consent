<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;
use WP_Post;
use WP_Query;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_action( 'admin_head-nav-menus.php', __NAMESPACE__ . '\\document_pages_metabox' );

	$hooks = create_custom_page_hooks(
		create_policy_page_factory(),
		\apply_filters( 'wordpress_helfi_cookie_consent_current_language', 'en' )
	);

	\add_filter( 'wp_setup_nav_menu_item', array( $hooks, 'wp_setup_nav_menu_item' ) );
	\add_filter( 'wp_nav_menu_objects', array( $hooks, 'wp_nav_menu_objects' ) );
	\add_filter( 'wordpress_helfi_cookie_consent_nav_menu_metabox_pages', array( $hooks, 'helfi_custom_pages' ) );

	\add_action( 'init', array( $hooks, 'register_rewrites' ) );
	\add_action( 'template_include', array( $hooks, 'policy_page_template' ) );
	\add_action( 'wordpress_helfi_cookie_consent_page', array( $hooks, 'policy_page_content' ) );
}

function create_custom_page_hooks( Policy_Page_Factory $factory, string $current_language ): Custom_Page_Hooks {
	return new Custom_Page_Hooks( $factory, $current_language );
}

function create_policy_page_factory(): Policy_Page_Factory {
	return new Policy_Page_Factory( new Cache() );
}

function document_pages_metabox(): void {
	\add_meta_box(
		'helfi-cookie-consent-documents',
		__( 'Helsinki Cookie Consent', 'wordpress-helfi-cookie-consent' ),
		__NAMESPACE__ . '\\render_document_pages_metabox',
		'nav-menus',
		'side',
		'low'
	);
}

function render_document_pages_metabox(): void {
	$pages = \apply_filters( 'wordpress_helfi_cookie_consent_nav_menu_metabox_pages', array() );
	?>
	<div id="posttype-helfi-cookie-consent-page" class="posttypediv">
        <div id="tabs-panel-helfi-cookie-consent-page" class="tabs-panel tabs-panel-active">
            <ul id="helfi-cookie-consent-page-checklist" class="categorychecklist form-no-clear">
				<?php
					foreach( $pages as $page ) {
						printf(
							'<li>
			                    <label class="menu-item-title">
			                        <input type="checkbox" class="menu-item-checkbox" name="menu-item[-1][menu-item-object-id]" value="-1"> %1$s
			                    </label>
			                    <input type="hidden" class="menu-item-type" name="menu-item[-1][menu-item-type]" value="%2$s">
			                    <input type="hidden" class="menu-item-title" name="menu-item[-1][menu-item-title]" value="%1$s">
			                    <input type="hidden" class="menu-item-url" name="menu-item[-1][menu-item-url]" value="#">
			                </li>',
							\esc_html( $page->title() ),
							\esc_attr( $page->type() )
						);
					}
				?>
            </ul>
        </div>
        <p class="button-controls">
            <span class="add-to-menu">
                <input
					id="submit-posttype-helfi-cookie-consent-page"
					class="button-secondary submit-add-to-menu right"
					type="submit"
					name="add-post-type-menu-item"
					value="<?php \esc_attr_e( 'Add to Menu' ); ?>">
                <span class="spinner"></span>
            </span>
        </p>
    </div>
	<?php
}
