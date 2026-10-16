# Feature — Premium strip and ns_license free trial

*Status: Done. Requires ns_license 14.5.4 (deep-link support) to be released.*

## Licensing status

Freemium per the NITSAN Free/Freemium sheet. Premium product: https://t3planet.de/sitekit-by-google-fur-typo3
(not linked from the UI; the trial stays inside the TYPO3 backend).

## Dependency

`composer.json` `"nitsan/ns-license": "^14.5.4"`, `ext_emconf.php` `'ns_license' => '14.5.4-14.9.99'`.

## Strip

Same look as ns_revolution_slider / ns_feedback / ns_news_comments.

- `Backend\PremiumStrip::render(string $trialUrl, string $linkTarget = '')` returns the HTML. It only uses
  `IconFactory` and `$GLOBALS['LANG']`, both available in the install tool's failsafe container.
- Content: `actions-rocket` core icon (`IconSize::SMALL`), headline and description on two lines, one
  `btn btn-primary` "Start Free Trial →" link (the arrow is `aria-hidden` markup, not part of the label).
- Labels in `locallang.xlf`:
  - `premium.strip.headline`: "You're using the free version of NS Google Site Kit"
  - `premium.strip.description`: "Unlock premium features and get more out of NS Google Site Kit."
  - `premium.strip.trial`: "Start Free Trial"
  - `extensionconfiguration.premium`: "Premium" (field label in the Extension Configuration)
- Styling: `.ns-google-sitekit-premium-strip` (+ `-icon`, `-headline`, `-description`) in
  `Resources/Public/Css/backend-premium-strip.css`.

## Placement

The extension has no plugin, module or site set, so the strip sits only where the extension is configured:

**Extension Configuration** (Settings → Configure extensions → ns_google_sitekit, "configuration" tab,
first field "Premium"). `ext_conf_template.txt` field `premiumStrip`,
`type=user[NITSAN\NsGoogleSitekit\Configuration\PremiumStripField->render]`.

- Rendered by the install tool via AJAX: no `PageRenderer`, so the field outputs its own
  `<link rel="stylesheet">`.
- Failsafe container: `UriBuilder` can't be built. Returns `''` when `ns_license` is not loaded or
  `$GLOBALS['TYPO3_REQUEST']` is missing.
- Trial URL: `BackendEntryPointResolver::getUriFromRequest($request, 'module/nitsan/NsLicense')`
  + `?trial=ns_google_sitekit#free-section`, `target="_top"` (leaves the install tool modal).

## Trial link

ns_license's `get-license.js` (`maybeOpenTrialDeepLink()`) reads `?trial=`, removes it from the URL and
opens its "Get New License" wizard in Free Trial mode with Site Kit preselected. The ns_license module
requires system maintainer access.
