<?php

declare(strict_types=1);

namespace NITSAN\NsGoogleSitekit\Configuration;

use NITSAN\NsGoogleSitekit\Backend\PremiumStrip;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Routing\BackendEntryPointResolver;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * "user" field of ext_conf_template.txt: premium strip at the top of the Extension Configuration.
 *
 * The install tool renders this field with the failsafe container, which has no backend router or module
 * registry. The trial link is therefore built from the backend entry point and the license module path, and
 * opens in the top window.
 */
final class PremiumStripField
{
    /**
     * @param array{fieldName?: string, fieldValue?: mixed} $params
     */
    public function render(array $params): string
    {
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if (!$request instanceof ServerRequestInterface
            || !ExtensionManagementUtility::isLoaded(PremiumStrip::LICENSE_EXTENSION_KEY)
        ) {
            return '';
        }

        $trialUrl = (string)GeneralUtility::makeInstance(BackendEntryPointResolver::class)
            ->getUriFromRequest($request, PremiumStrip::LICENSE_MODULE_PATH)
            ->withQuery(http_build_query(PremiumStrip::TRIAL_PARAMETERS))
            ->withFragment(ltrim(PremiumStrip::LICENSE_FREE_SECTION_ANCHOR, '#'));

        // The install tool loads this markup via AJAX without a PageRenderer, so the stylesheet is linked inline.
        $stylesheetUrl = PathUtility::getPublicResourceWebPath(PremiumStrip::STYLESHEET);

        return '<link rel="stylesheet" href="' . htmlspecialchars($stylesheetUrl) . '">'
            . GeneralUtility::makeInstance(PremiumStrip::class)->render($trialUrl, '_top');
    }
}
