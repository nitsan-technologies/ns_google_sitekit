# ns_google_sitekit — Operating Principles

*Every change to code, context or docs must serve the goals below.*

---

## Goal 1 — Nothing that works may break

The extension is declared for TYPO3 v14 only (Composer and Classic mode).

- The header tags are rendered on every frontend page when the extension is active. A broken template or
  DataProcessor breaks every page, so test the frontend after each change.
- The Extension Configuration is rendered by the install tool with the **failsafe container**. Code reached
  from `ext_conf_template.txt` may only use services the failsafe container provides (no backend
  `UriBuilder`, router or module registry). An exception there breaks "Configure extensions" for **all**
  extensions, not only this one.
- Prefer the smallest change that fixes the root cause. No drive-by refactors.
- Run `tasks/run-quality.md` and re-test the affected flow in the frontend and backend before claiming done.

## Goal 2 — Token-cost efficiency (agent context)

- **DRY context:** each fact lives in exactly ONE file. Reference, don't copy.
- **Load on demand:** read `context/features/<area>.md` for the task, not everything.
- **Prune as you go:** keep `context/session-state.md` short.

## Goal 3 — Accuracy and trust

- Answer from context + code, never from invented API, setting or label names.
- Mark facts as "verified live" or "code-read". Conflicting facts across files = fix the source file.

---

## Guardrails (non-negotiable)

- **No site set.** Configuration is Extension Configuration only (`ext_conf_template.txt`). Keep
  `CustomDataProcessing` keys in sync when adding or renaming a tag ID.
- Do not reintroduce `Configuration/Sets/` or site-settings readers without an explicit product decision.
- Values go into `<script>` and `<meta>` markup; keep Fluid escaping on (no `f:format.raw`).
- Do not change ns_license from an ns_google_sitekit task; reuse its module and trial modal.
- All UI text goes into `Resources/Private/Language/locallang.xlf` (English source only; NITSAN translations
  are managed on Crowdin), no hard-coded labels in PHP or JS.

---

## Apply this whenever you

- Edit `context/` or `AGENTS.md`
- Land a feature or bugfix (update the matching `context/features/*.md` + `session-state.md`)
