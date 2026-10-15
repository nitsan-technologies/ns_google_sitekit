# ns_google_sitekit — Session state

## 2026-10-14 — ns_license integration + premium strip + agent context

- Branch `master` (uncommitted). Added `nitsan/ns-license ^14.5.4` / `ns_license 14.5.4-14.9.99`.
- Premium strip "Start Free Trial" in the Site Settings editor (sites using the set) and the Extension
  Configuration; new `Configuration/Services.yaml` and `JavaScriptModules.php` (see `features/premium-cta.md`).
- Verified on TYPO3 14.3.7 with a temporary set dependency on site `camino`, a temp admin / system maintainer
  (all reverted): one strip in each place, none without the set, trial wizard opens with Site Kit preselected.
- Fixed during testing: missing export name in the JS instruction; `UriBuilder` in the failsafe container.
- Created agent context (`AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/`); no previous context existed.
- Open: ns_license 14.5.4 not yet published; frontend header tags only code-read this session.
- Moved the Site Settings strip from above the editor into the "Google Site Kit" category (below its
  headline). Verified via DOM on site `camino` (set now included by the developer); one strip, before the
  first setting.
- Switched the strip to the team-wide standard from the review, same in every NITSAN strip except the name —
  "You're using the free version of NS Google Site Kit" / "Unlock premium features and get more out of NS Google
  Site Kit.", two lines, "Start Free Trial →", 14px 18px padding, 6px radius (see `features/premium-cta.md`).
  Version 2.0.0 → 2.1.0. Site settings placement verified live on 14.3.7; the Extension Configuration placement
  uses the same `render()` and stylesheet but was not re-opened. Uncommitted.
