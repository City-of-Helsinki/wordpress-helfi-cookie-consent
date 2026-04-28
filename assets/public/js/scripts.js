"use strict";

(function (hds, config) {
  if (hds.CookieConsentCore && config.routes) {
    init_handler(config);
    function init_handler({
      routes,
      options,
      cookiesHandler
    }) {
      let handlers = {
        complianz: complianz_cookies_handler,
        none: no_cookies_handler
      };
      if (!handlers.hasOwnProperty(cookiesHandler)) {
        cookiesHandler = 'none';
      }
      handlers[cookiesHandler](create_cookie_consent(routes.settings, options));
    }
    function complianz_cookies_handler(cookieConsentPromise) {
      const allow = group => cmplz_set_consent(group, 'allow');
      const deny = group => cmplz_set_consent(group, 'deny');
      const denyAll = () => cmplz_deny_all();
      const handleComplianzCategoryEnabled = event => {
        if (hds.cookieConsent) {
          hds.cookieConsent.setGroupsStatusToAccepted([event.detail.category]);
        }
      };
      const handleConsentChanges = () => {
        if (hds.cookieConsent) {
          document.removeEventListener('cmplz_enable_category', handleComplianzCategoryEnabled);
          hds.cookieConsent.getAllConsentStatuses().forEach(({
            consented,
            group
          }) => consented ? allow(group) : deny(group));
          document.addEventListener('cmplz_enable_category', handleComplianzCategoryEnabled);
        }
      };
      window.addEventListener('hds-cookie-consent-ready', handleConsentChanges);
      window.addEventListener('hds-cookie-consent-changed', handleConsentChanges);

      // window.addEventListener('hds-cookie-consent-unapproved-item-found', event => console.log(event));
    }
    function no_cookies_handler() {
      console.error('no cookies handler');
    }
    function create_cookie_consent(settingsUrl, options) {
      return hds.CookieConsentCore.create((({
        language
      }) => {
        let params = new URLSearchParams();
        params.append('lang', language);
        return settingsUrl + '?' + params.toString();
      })(options), options);
    }
  }
})(hds, HelfiCookieConsent);