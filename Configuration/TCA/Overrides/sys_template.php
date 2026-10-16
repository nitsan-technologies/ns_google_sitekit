<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('Access denied.');

// Optional static template (TypoScript is also auto-loaded in ext_localconf.php).
ExtensionManagementUtility::addStaticFile(
    'ns_google_sitekit',
    'Configuration/TypoScript',
    'Google Site Kit'
);
