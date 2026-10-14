# Feature — Premium strip and ns_license free trial

*Status: Done. Verified live on TYPO3 14.3.7 (both placements, trial modal opens with Site Kit preselected).
Requires ns_license 14.5.4 (deep-link support) to be released.*

## Licensing status

Freemium per the NITSAN Free/Freemium sheet. Premium product: https://t3planet.de/sitekit-by-google-fur-typo3
(not linked from the UI; the trial stays inside the TYPO3 backend).

## Dependency

`composer.json` `"nitsan/ns-license": "^14.5.4"`, `ext_emconf.php` `'ns_license' => '14.5.4-14.9.99'`.

## Strip

Same look as ns_revolution_slider / ns_feedback / ns_news_comments.

- `Backend\PremiumStrip::render(string $trialUrl, string $linkTarget = '')` returns the HTML. It only uses
  `IconFactory` and `$GLOBALS['LANG']`, both available in the install tool's failsafe container.
- Content: `actions-rocket` core icon (`IconSize::SMALL`), headline + description, one `btn btn-primary`
  "Start Free Trial" link.
- Labels in `locallang.xlf`:
  - `premium.strip.headline`: "You are using the free version"
  - `premium.strip.description`: "Upgrade to Premium for the Site Kit dashboard, PageSpeed Insights and page-wise reports."
  - `premium.strip.trial`: "Start Free Trial"
  - `extensionconfiguration.premium`: "Premium" (field label in the Extension Configuration)
- Styling: `.ns-google-sitekit-premium-strip` in `Resources/Public/Css/backend-premium-strip.css` — light-blue
  bar (`#e7f2fc`, border `#8eb6e8`, 4px `#2b6cb0` left accent, text `#0d2c4a`), `light-dark()` for dark mode,
  button `#007bff` (hover `#0062cc`).

## Placements

The extension has no plugin or module, so the strip sits where the extension is configured.

1. **Site Settings editor** (Sites → Setup → Edit settings), only for sites whose settings contain
   `ns_google_sitekit.googleTagID` (i.e. the set is included). Placed inside the "Google Site Kit" category,
   below its headline and above "Google Site Verification Code" (user request, 2026-10-14).
   - The editor has no public content hook (settings types and categories are `@internal`).
     `EventListener\SiteSettingsPremiumStrip` listens to `ModifyButtonBarEvent`, checks route
     `site_configuration.editSettings` + query `site`, adds the CSS via `PageRenderer::addCssFile()` and a
     JS module instruction `JavaScriptModuleInstruction::create('@nitsan/…/site-settings-premium-strip.js',
     'insertPremiumStrip')->invoke(null, $html, 'ns_google_sitekit')`.
   - The export name must be passed to `create()`: without it core's item processor resolves the module's
     `default` export and the call silently does nothing.
   - The JS waits for `customElements.whenDefined()` + `updateComplete` of `<typo3-backend-settings-editor>`
     (Lit, light DOM) and appends the strip to `.settings-category[data-key="ns_google_sitekit"]` (headline +
     description block), so search hides it together with the category. A `MutationObserver` re-adds it if a
     re-render drops it. Depends on core's internal editor markup: re-check after TYPO3 updates.
2. **Extension Configuration** (Settings → Configure extensions → ns_google_sitekit, "configuration" tab,
   first field "Premium"). `ext_conf_template.txt` field `premiumStrip`,
   `type=user[NITSAN\NsGoogleSitekit\Configuration\PremiumStripField->render]`.
   - Rendered by the install tool via AJAX: no `PageRenderer`, so the field outputs its own
     `<link rel="stylesheet">`.
   - Failsafe container: `UriBuilder` can't be built (`makeInstance` throws "Too few arguments", which broke
     the whole extension list before the fix). Returns `''` when `ns_license` is not loaded or
     `$GLOBALS['TYPO3_REQUEST']` is missing.

## Trial link

- Site Settings editor: `UriBuilder::buildUriFromRoute('nitsan_nslicensemodule', ['trial' => 'ns_google_sitekit'],
  UriBuilder::SHAREABLE_URL)` + `#free-section`, same frame.
- Extension Configuration: `BackendEntryPointResolver::getUriFromRequest($request, 'module/nitsan/NsLicense')`
  + `?trial=ns_google_sitekit#free-section`, `target="_top"` (leaves the install tool modal).
  `PremiumStrip::LICENSE_MODULE_PATH` must match `path` in ns_license `Configuration/Backend/Modules.php`.
  `main?redirect=<route>&redirectParams=…` was tried and lands on the Dashboard on this installation, even
  for core modules (verified live), so it is not used.
- ns_license's `get-license.js` (`maybeOpenTrialDeepLink()`) reads `?trial=`, removes it from the URL and
  opens its "Get New License" wizard in Free Trial mode with "Site Kit by Google (ns_google_sitekit)"
  preselected. The ns_license module requires system maintainer access.
