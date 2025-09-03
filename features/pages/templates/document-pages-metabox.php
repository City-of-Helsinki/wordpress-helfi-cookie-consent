<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages\Templates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
