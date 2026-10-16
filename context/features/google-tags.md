# Feature — Google tags in the page header

*Status: Done.*

## Setup

Install/activate the extension. TypoScript is registered automatically via `ext_localconf.php`
(`addTypoScriptSetup` → `Configuration/TypoScript/setup.typoscript`). Configure tag IDs under
**Settings → Configure extensions → ns_google_sitekit**.

There is **no site set**. An optional static template "Google Site Kit" remains registered for Classic
installs that prefer including it manually (same setup file; harmless if both load).

`setup.typoscript` renders `page.headerData.5` (FLUIDTEMPLATE `HeaderData.html`, DataProcessor
`CustomDataProcessing`).

## Settings (Extension Configuration only)

| Extension configuration key | Output in `HeaderData.html` |
|---|---|
| `verificationToken` | `dns-prefetch` for googletagmanager.com + `<meta name="google-site-verification">` |
| `googleTagID` | gtag.js loader + inline config (`linker.domains` = current host, `developer_id.dZTNiMT`) |
| `tagmanagerContainer` | GTM head script (no `<noscript>` body iframe) |
| `adsenseClientId` | `adsbygoogle.js?client=…` |

- All defaults are `''`. Each snippet renders only when its value is non-empty.
- Values come from `ExtensionConfiguration::get('ns_google_sitekit')` (errors → `[]`).
- `domainName` = `normalizedParams->getRequestHost()` (fallback `HTTP_HOST`).
- Template variables are top-level (`{googleTagID}`), not under `{sitekit}`: the processor writes into
  `$processedData` directly; `as` is unused.

## Premium (not in this repo)

Per the T3Planet product page: Site Kit backend dashboard, PageSpeed Insights, search bar / page-wise
statistics, admin panel. Promoted by the premium strip (`premium-cta.md`).
