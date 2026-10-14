# Feature — Google tags in the page header

*Status: Done. Code-read; not re-verified in the frontend in the 2026-10-14 session.*

## Setup

Either add the site set `nitsan/ns-google-sitekit` to the site (TYPO3 14 way) or include the static template
"Google Site Kit". Both load `Configuration/TypoScript/setup.typoscript`, which renders `page.headerData.5`
(FLUIDTEMPLATE `HeaderData.html`, DataProcessor `CustomDataProcessing` with `as = sitekit`).

## Settings

| Site setting (set) | Extension configuration key | Output in `HeaderData.html` |
|---|---|---|
| `ns_google_sitekit.verificationToken` | `verificationToken` | `dns-prefetch` for googletagmanager.com + `<meta name="google-site-verification">` |
| `ns_google_sitekit.googleTagID` | `googleTagID` | gtag.js loader + inline config (`linker.domains` = current host, `developer_id.dZTNiMT`) |
| `ns_google_sitekit.tagmanagerContainer` | `tagmanagerContainer` | GTM head script (no `<noscript>` body iframe) |
| `ns_google_sitekit.adsenseClientId` | `adsenseClientId` | `adsbygoogle.js?client=…` |

- All defaults are `''`. Each snippet renders only when its value is non-empty.
- `CustomDataProcessing::resolveSetting()`: the site setting wins when non-empty, otherwise the extension
  configuration value (`ExtensionConfiguration::get('ns_google_sitekit')`, errors → `[]`).
- `domainName` = `normalizedParams->getRequestHost()` (fallback `HTTP_HOST`).
- The template variables are top-level (`{googleTagID}`), not under `{sitekit}`: the processor writes into
  `$processedData` directly; `as` is unused.

## Premium (not in this repo)

Per the T3Planet product page: Site Kit backend dashboard, PageSpeed Insights, search bar / page-wise
statistics, admin panel. Promoted by the premium strip (`premium-cta.md`).
