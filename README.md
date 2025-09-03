# WP Helsinki Cookie Consent

WP Implementation of HDS CookieConsent

## Assets

Source: `/assets/public`

- `js/scripts(.min).js` determines current cookie handler and creates `hds.CookieConsentCore` using the inline `HelfiCookieConsent` configuration variable.
- `js/vendor(.min).js` contains `hds-js/standalone/cookieConsent/index.js`.

## Features

### HDS CookieConsent

Source: `/features/models`

- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_type_factory', Cookie_Type_Factory $factory )` to create `Cookie_Type` objects. The default factory uses flyweight for the created types.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_category_factory', Cookie_Category_Factory $factory )` to create `Cookie_Category` objects. The default factory uses flyweight for the created categories.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_database', Cookie_Database $database )` to configure `Cookie_Repository` cookie database.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_adapter_factory', Cookie_Adapter_Factory $factory, Cookie_Category_Factory $categories, Cookie_Type_Factory $types, string $current_language )` to configure `Cookie_Repository` cookie factory.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_known_cookies', array $cookies )` to configure `Cookie_Repository` known cookies.
- Provides `Cookie_Repository` via `wordpress_helfi_cookie_consent_cookie_repository` filter.

### Known cookies

Source: `/features/cookies`

- Provides configuration for known cookies as `Known_Cookie_Data`.

**Cookies**

- `helfi-cookie-consents` from `HDS_Cookie_Consent`

### Notices

Source: `/features/notices`

- Handles displaying `admin_notices` on action.
- Additional notices can be displayed by `do_action( 'wordpress_helfi_cookie_consent_add_admin_notice', Admin_Notice $notice )` before `admin_notices`.
- Displays `Missing_Cookie_Provider_Notice`, if `wordpress_helfi_cookie_consent_has_cookie_provider` is `false`.

### Pages

Source: `/features/pages`

- Registers rewrite tags and rules for dynamic policy pages.
- Determines the current policy page based on `get_query_var()` value.
- Clears rewrite rules when the plugin is either activated or deactivated.
- Provides `Helsinki Cookie Consent` nav menu metabox for adding policy page menu items to a navigation menu.
- Provides dynamic titles and urls for the policy page menu items.
- Provides custom `features/pages/templates/cookie-policy.php` template for policy pages.
- Determines the page content. The page content is extendable with action hooks.
- Determines `document_title` for a policy page.
- Adds policy page links to menu location on `do_action( 'wordpress_helfi_cookie_consent_add_nav_menu_policy_pages', string $location )`.
- Displays `Nav_Menu_Policy_Pages_Added_Notice` when pages are added to menu location.

### REST API

Source: `/features/rest`

- Registers versioned REST endpoint `/settings` in `helfi-cookie-consent` namespace.
- The `/settings` endpoint returns HDS CookieConsent settings in `json` format.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', Cookie_Repository $repository )` to provide cookie data.
- Provides inline `HelfiCookieConsent` JavaScript configuration variable to HDS CookieConsent in `hel-cookie-consent` script.

### Views

Source: `/features/views`

- Registers `hel-cookie-consent-vendor` and `hel-cookie-consent` scripts.
- Registers inline styles for the cookie consent settings wrap element using dynamic handle name based on the `wordpress_helfi_cookie_consent_settings_element_id` filter.
- Provides default value for `wordpress_helfi_cookie_consent_settings_element_id`.

## Integrations

### Complianz – GDPR/CCPA Cookie Consent

From: [complianz.io](https://complianz.io/) and [Plugin Directory](https://wordpress.org/plugins/complianz-gdpr/).

Source: `/integrations/complianz`

- The plugin uses Complianz as a cookie data provider.
- Provides the cookies identified by Complianz to the CookieConsent component.
- Disables the default Complianz cookie banner, cookie banner styles, and replaces the `cookie-statement` document with CookieConsent container.
- The JavaScript `complianz_cookies_handler` function acts as an adapter between Complianz and CookieConsent scripts.
- Provides implementation of `Cookie_Database` to `wordpress_helfi_cookie_consent_cookie_database`.
- Provides implementation of `Cookie_Adapter_Factory` to  `wordpress_helfi_cookie_consent_cookie_adapter_factory`.
- Flags `wordpress_helfi_cookie_consent_has_cookie_provider` as `true`.

### Helsinkiteema

From: [City-of-Helsinki/wordpress-helfi-helsinkiteema](https://github.com/City-of-Helsinki/wordpress-helfi-helsinkiteema)

Source: `/integrations/helsinkiteema`

- On Dashboard view, checks, if the menu location `footer_menu` contains cookie policy pages' links.
- If policy pages' links are missing from the menu, adds the missing ones.
- The check result is cached in a transient for one day.
- The cache transient is cleared when a menu attached to `footer_menu` location is updated.

### Polylang

From: [polylang.pro](https://polylang.pro/) and [Plugin Directory](https://fi.wordpress.org/plugins/polylang/)

Source: `/integrations/polylang`

- Provides multilingual support for the custom policy pages by translating their page slugs.
- Adds the translated policy page url to the language selector.

### Yoast SEO

From: [yoast.com](https://yoast.com/) and [Plugin Directory](https://wordpress.org/plugins/wordpress-seo/)

Source: `/integrations/wordpressseo`

- Provides SEO meta data for the custom policy pages.
