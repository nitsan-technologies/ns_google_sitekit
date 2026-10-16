# Run quality checks

The repo has no PHPUnit, PHPStan or CS config. Available checks:

```bash
# PHP syntax (8.2+)
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done

# composer.json
composer validate --no-check-publish

# XLF well-formedness
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done
```

After adding or renaming classes in Classic mode run `typo3 dumpautoload`, then `typo3 cache:flush`.

## Manual test (TYPO3 14)

Setup: extension active, system maintainer for the ns_license module. No site set required.

1. Settings → Configure extensions → ns_google_sitekit → "configuration": "Premium" strip as first field,
   styled. The extension list must still open (an exception here breaks it for every extension).
2. "Start Free Trial" opens the ns_license module with the trial wizard and Site Kit preselected. Check
   light and dark backend themes.
3. Fill each ID in Extension Configuration → matching snippet in frontend `<head>`; clear one → its snippet
   is gone. Flush caches between changes if needed.

Remove temporary test values afterwards.
