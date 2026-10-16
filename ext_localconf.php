<?php

defined('TYPO3') || die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Always inject header tags when the extension is active. Configuration comes from
// Extension Configuration only (no site set).
ExtensionManagementUtility::addTypoScriptSetup(
    '@import \'EXT:ns_google_sitekit/Configuration/TypoScript/setup.typoscript\''
);
