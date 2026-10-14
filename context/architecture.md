# ns_google_sitekit — Architecture

## Registration

| What | Where |
|---|---|
| Site set `nitsan/ns-google-sitekit` ("Google Site Kit"), settings category `ns_google_sitekit` | `Configuration/Sets/ns_google_sitekit/` |
| Static template "Google Site Kit" (`Configuration/TypoScript`) | `Configuration/TCA/Overrides/sys_template.php` |
| `page.headerData.5` FLUIDTEMPLATE (set imports the static setup) | `Configuration/TypoScript/setup.typoscript` |
| Extension configuration (tag IDs + premium strip field) | `ext_conf_template.txt` |
| Event listener `ns-google-sitekit/site-settings-premium-strip` (`#[AsEventListener]`) | `Classes/EventListener/SiteSettingsPremiumStrip.php` |
| JS import map `@nitsan/ns-google-sitekit/` | `Configuration/JavaScriptModules.php` |
| DI (autowire `Classes/*`) | `Configuration/Services.yaml` |

No `ext_localconf.php`, `ext_tables.php`, `ext_tables.sql`, TCA tables, plugins or backend modules.

## Classes

| Class | Role |
|---|---|
| `DataProcessing\CustomDataProcessing` | Resolves the tag IDs (site setting → extension configuration) and `domainName` for `HeaderData.html` |
| `Backend\PremiumStrip` | Strip HTML for a given trial URL; ns_license route/path constants. Failsafe-container safe |
| `EventListener\SiteSettingsPremiumStrip` | Adds the strip to the site settings editor (see `features/premium-cta.md`) |
| `Configuration\PremiumStripField` | `type=user` field of the Extension Configuration (see `features/premium-cta.md`) |

## Views and assets

| File | Use |
|---|---|
| `Resources/Private/Templates/HeaderData.html` | Verification meta, gtag.js, GTM and AdSense snippets |
| `Resources/Public/JavaScript/site-settings-premium-strip.js` | Places the strip in the "Google Site Kit" category of `<typo3-backend-settings-editor>` |
| `Resources/Public/Css/backend-premium-strip.css` | Premium strip styles |
| `Resources/Public/Icons/Extension.svg`, `ext_icon.svg` | Extension icon |
