# ns_google_sitekit — Core facts

## Identity

| Item | Value |
|---|---|
| Extension key | `ns_google_sitekit` |
| Composer name | `nitsan/ns-google-sitekit` |
| Title (ext_emconf) / product name | Google Site Kit Integration for TYPO3 / Site Kit by Google |
| Namespace | `NITSAN\NsGoogleSitekit\` → `Classes/` |
| Version (ext_emconf) | 2.1.0 (latest tag 2.0.0) |
| Repository | https://github.com/nitsan-technologies/ns_google_sitekit (branch `master`) |
| Licensing status (NITSAN Free/Freemium sheet) | **Freemium** — this repo is the free version |
| Premium version (sheet) | https://t3planet.de/sitekit-by-google-fur-typo3 (€179/year) |

## Compatibility

| Source | TYPO3 | PHP |
|---|---|---|
| `ext_emconf.php` | `14.0.0-14.9.99` | not declared |
| `composer.json` | `^14` | not declared |
| ns_license 14.5.4 (dependency) | `12.4.18-14.9.99` | — |

- PHP 8.2+ (TYPO3 14 minimum). Verified live on TYPO3 14.3.7 (Classic mode, DDEV).

## Dependencies

| Package | Constraint | Why |
|---|---|---|
| `typo3/cms-core` | `^14` | core |
| `nitsan/ns-license` / `ns_license` | `^14.5.4` / `14.5.4-14.9.99` | TYPO3 Shop module + free-trial deep link (see `features/premium-cta.md`) |
| `typo3/cms-backend`, `typo3/cms-frontend` | not declared | `UriBuilder`, `ModifyButtonBarEvent` / `DataProcessorInterface` (both always installed with core) |

## Tooling

- No PHPUnit, PHPStan, CS fixer or package.json in the repo.
- CI: `.github/workflows/ter-release.yml` (publishes tags to TER).
- `.gitattributes` export-ignores `.github/`, `AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/` and itself, so they
  are not in the GitHub/Composer archive or the TER package (the TER release uploads the GitHub tag archive).
- English labels only (`Resources/Private/Language/locallang.xlf`); no `.crowdin.yml` or translation files.
- No `Documentation/` folder; user docs are external (see `docs-map.md`).

## Conventions

- No plugin, content element, backend module, database table or **site set**. Output is header markup only.
- Tag IDs come from Extension Configuration; TypoScript is auto-registered in `ext_localconf.php`.
- `Configuration/Services.yaml` autowires `Classes/*`.
- Backend premium strip CSS: `Resources/Public/Css/backend-premium-strip.css` (`light-dark()` colours).

## Known issues (existing, not fixed)

All code-read unless marked otherwise.

- `Configuration/TypoScript/constants.typoscript` is empty (if present).
- The comment in `Configuration/TCA/Overrides/sys_template.php` says "tt_content" but it registers the
  static template.
- `ext_emconf.php` still has the obsolete `uploadfolder` / `createDirs` keys.
- README badge says v1.0.3 / TYPO3 12; links use `t3planet.com` while the sheet uses `t3planet.de`.
- `ter-release.yml` uses PHP 7.4 and the deprecated `::set-output`.
- Opening the Extension Configuration writes `'premiumStrip' => ''` into
  `$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['ns_google_sitekit']` (TYPO3 stores every template field; the
  value is unused). Verified live.
