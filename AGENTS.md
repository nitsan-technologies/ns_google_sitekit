# AGENTS.md — ns_google_sitekit (Google Site Kit)

Agent router for the Google Site Kit free extension (Google Search Console verification, Analytics, Tag
Manager and AdSense tags in the page header). Load only what your task needs.

> **Principles:** `context/principles.md`
> **Session log:** `context/session-state.md`
> **Doc index:** `context/docs-map.md`

---

## Always load

| File | Why |
|---|---|
| `context/principles.md` | Guardrails, "nothing that works may break" rule |
| `context/core.md` | Identity, TYPO3/PHP/ns_license constraints, tooling, known issues |

---

## Task router

| Task | Load |
|---|---|
| Header tags, site set settings, extension configuration fallback, TypoScript, DataProcessor | `context/features/google-tags.md` |
| Premium strip / free trial / ns_license dependency | `context/features/premium-cta.md` |
| Classes, registration, assets, services | `context/architecture.md` |
| Lint / validate / manual test | `tasks/run-quality.md` |
| Update agent context after a change | `tasks/context-update.md` |

---

## Feature status

| Feature | Status | Agent entry |
|---|---|---|
| Verification meta tag, gtag.js, GTM and AdSense snippets in `page.headerData.5` | Done | `context/features/google-tags.md` |
| Site set `nitsan/ns-google-sitekit` settings with extension configuration fallback | Done | `context/features/google-tags.md` |
| Premium strip (Site Settings editor + Extension Configuration) + ns_license free-trial deep link | Done (needs ns_license 14.5.4 release) | `context/features/premium-cta.md` |

---

## Quick commands

```bash
cd packages/ns_google_sitekit       # or typo3conf/ext/ns_google_sitekit in Classic mode
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done
composer validate --no-check-publish
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done
```
