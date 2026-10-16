# ns_google_sitekit — Architecture

## Registration

| What | Where |
|---|---|
| Auto TypoScript setup (always on when extension is active) | `ext_localconf.php` → `Configuration/TypoScript/setup.typoscript` |
| Optional static template "Google Site Kit" | `Configuration/TCA/Overrides/sys_template.php` |
| `page.headerData.5` FLUIDTEMPLATE | `Configuration/TypoScript/setup.typoscript` |
| Extension configuration (tag IDs + premium strip field) | `ext_conf_template.txt` |
| DI (autowire `Classes/*`) | `Configuration/Services.yaml` |

No site set, no `ext_tables.php`, no `ext_tables.sql`, no TCA tables, plugins or backend modules.

## Classes

| Class | Role |
|---|---|
| `DataProcessing\CustomDataProcessing` | Reads tag IDs from Extension Configuration and `domainName` for `HeaderData.html` |
| `Backend\PremiumStrip` | Strip HTML for a given trial URL; ns_license route/path constants. Failsafe-container safe |
| `Configuration\PremiumStripField` | `type=user` field of the Extension Configuration (see `features/premium-cta.md`) |

## Views and assets

| File | Use |
|---|---|
| `Resources/Private/Templates/HeaderData.html` | Verification meta, gtag.js, GTM and AdSense snippets |
| `Resources/Public/Css/backend-premium-strip.css` | Premium strip styles |
| `Resources/Public/Icons/Extension.svg`, `ext_icon.svg` | Extension icon |
