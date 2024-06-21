<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die('Access denied.');

$_EXTKEY = 'ns_google_sitekit';

// Adding fields to the tt_content table definition in TCA
ExtensionManagementUtility::addStaticFile(
    $_EXTKEY,
    'Configuration/TypoScript',
    'Google Site Kit'
);
