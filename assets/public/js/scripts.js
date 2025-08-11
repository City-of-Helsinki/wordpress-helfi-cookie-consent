"use strict";

(function ({
  CookieConsentCore
}, {
  routes
}) {
  if (CookieConsentCore && routes) {
    try {
      CookieConsentCore.create(routes.settings, {});
    } catch (e) {
      console.log(e);
    }
  }
})(hds, HelfiCookieConsent);