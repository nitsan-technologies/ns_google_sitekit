# ns_google_sitekit — Session state

## 2026-10-16 — Remove site set dependency fully

- Branch `feature/ns-license-premium-strip`.
- Deleted `Configuration/Sets/ns_google_sitekit/` (config, settings.definitions, setup).
- `CustomDataProcessing` reads Extension Configuration only (no site settings / `conversionTrackingId`).
- Removed Site Settings premium strip (`EventListener\SiteSettingsPremiumStrip`,
  `site-settings-premium-strip.js`, `JavaScriptModules.php`). Strip remains in Extension Configuration only.
- TypoScript auto-loaded via `ext_localconf.php` `addTypoScriptSetup` so sites need no set dependency.
- Optional static template kept. Agent context / principles updated accordingly.

## 2026-10-14 — ns_license integration + premium strip + agent context

- Added `nitsan/ns-license ^14.5.4` / `ns_license 14.5.4-14.9.99`.
- Premium strip "Start Free Trial" in Extension Configuration (and formerly Site Settings; removed 2026-10-16).
- Created agent context (`AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/`).
