<?php

declare(strict_types=1);

namespace NITSAN\NsGoogleSitekit\Backend;

use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Imaging\IconSize;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Premium strip with a free-trial link to the ns_license module.
 *
 * Only depends on services of the failsafe container, because the Extension Configuration renders it
 * inside the install tool.
 */
final class PremiumStrip
{
    public const STYLESHEET = 'EXT:ns_google_sitekit/Resources/Public/Css/backend-premium-strip.css';
    public const LICENSE_EXTENSION_KEY = 'ns_license';
    public const LICENSE_MODULE_ROUTE = 'nitsan_nslicensemodule';
    /** Path of LICENSE_MODULE_ROUTE below the backend entry point, for contexts without the backend router. */
    public const LICENSE_MODULE_PATH = 'module/nitsan/NsLicense';
    public const LICENSE_FREE_SECTION_ANCHOR = '#free-section';
    public const TRIAL_PARAMETERS = ['trial' => 'ns_google_sitekit'];

    private const LANGUAGE_FILE = 'LLL:EXT:ns_google_sitekit/Resources/Private/Language/locallang.xlf:';

    public function render(string $trialUrl, string $linkTarget = ''): string
    {
        $icon = GeneralUtility::makeInstance(IconFactory::class)->getIcon('actions-rocket', IconSize::SMALL)->render();
        $targetAttribute = $linkTarget !== '' ? ' target="' . htmlspecialchars($linkTarget) . '"' : '';

        return '<div class="ns-google-sitekit-premium-strip d-flex flex-wrap align-items-center justify-content-between gap-3">'
            . '<div class="d-flex align-items-center gap-3">'
            . '<span class="ns-google-sitekit-premium-strip-icon">' . $icon . '</span>'
            . '<div>'
            . '<div class="ns-google-sitekit-premium-strip-headline">' . $this->translate('premium.strip.headline') . '</div>'
            . '<div class="ns-google-sitekit-premium-strip-description">' . $this->translate('premium.strip.description') . '</div>'
            . '</div>'
            . '</div>'
            . '<a href="' . htmlspecialchars($trialUrl) . '"' . $targetAttribute . ' class="btn btn-primary">'
            . $this->translate('premium.strip.trial') . ' <span aria-hidden="true">&rarr;</span></a>'
            . '</div>';
    }

    private function translate(string $key): string
    {
        $languageService = $GLOBALS['LANG'] ?? null;
        $label = $languageService instanceof LanguageService ? $languageService->sL(self::LANGUAGE_FILE . $key) : '';

        return htmlspecialchars($label);
    }
}
