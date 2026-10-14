# Run quality checks

The repo has no PHPUnit, PHPStan or CS config. Available checks:

```bash
# PHP syntax (8.2+)
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done

# composer.json
composer validate --no-check-publish

# XLF well-formedness
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done

# Backend ES module syntax (node treats .js as CommonJS, so check a .mjs copy)
cp Resources/Public/JavaScript/site-settings-premium-strip.js /tmp/strip.mjs && node --check /tmp/strip.mjs
```

After adding or renaming classes in Classic mode run `typo3 dumpautoload`, then `typo3 cache:flush`.
In Production context the import map `?bust=` only changes with extension versions, so browsers can keep an
old JS file after an edit: test with the cache disabled.

## Manual test (TYPO3 14)

Setup: a site with the set `nitsan/ns-google-sitekit` (or the static template "Google Site Kit"), and a
system maintainer for the ns_license module.

1. Sites → Setup → Edit settings of the site: one premium strip below the "Google Site Kit" category
   headline, above "Google Site Verification Code". Searching for another setting hides it with the
   category. A site without the set shows no strip.
2. Settings → Configure extensions → ns_google_sitekit → "configuration": "Premium" strip as first field,
   styled. The extension list must still open (an exception here breaks it for every extension).
3. "Start Free Trial" in both places opens the ns_license module with the trial wizard and Site Kit
   preselected. Check light and dark backend themes.
4. Frontend: fill each ID in the site settings → matching snippet in `<head>`; clear one → its snippet is gone;
   with the site setting empty and the extension configuration filled → the extension configuration value
   is used.

Remove temporary set dependencies, test values and temporary backend users afterwards.
