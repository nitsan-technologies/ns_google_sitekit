<?php

declare(strict_types=1);

namespace NITSAN\NsGoogleSitekit\DataProcessing;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Http\NormalizedParams;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException;

class CustomDataProcessing implements DataProcessorInterface
{
    /**
     * @throws ContentRenderingException
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $extConfiguration = $extensionConfiguration->get('ns_google_sitekit') ?? [];

        $processedData['verificationToken'] = $this->resolveSetting(
            $cObj,
            'ns_google_sitekit.verificationToken',
            'verificationToken',
            $extConfiguration
        );
        $processedData['googleTagID'] = $this->resolveSetting(
            $cObj,
            'ns_google_sitekit.googleTagID',
            'googleTagID',
            $extConfiguration
        );
        $processedData['tagmanagerContainer'] = $this->resolveSetting(
            $cObj,
            'ns_google_sitekit.tagmanagerContainer',
            'tagmanagerContainer',
            $extConfiguration
        );
        $processedData['conversionTrackingId'] = $this->resolveSetting(
            $cObj,
            'ns_google_sitekit.conversionTrackingId',
            'conversionTrackingId',
            $extConfiguration
        );
        $processedData['adsenseClientId'] = $this->resolveSetting(
            $cObj,
            'ns_google_sitekit.adsenseClientId',
            'adsenseClientId',
            $extConfiguration
        );

        $request = $cObj->getRequest();
        $normalizedParams = $request->getAttribute('normalizedParams');
        $processedData['domainName'] = $normalizedParams instanceof NormalizedParams
            ? $normalizedParams->getRequestHost()
            : (string)(GeneralUtility::getIndpEnv('HTTP_HOST') ?: '');

        return $processedData;
    }

    private function resolveSetting(
        ContentObjectRenderer $cObj,
        string $siteSettingKey,
        string $extensionConfigurationKey,
        array $extConfiguration
    ): string {
        $site = $cObj->getRequest()->getAttribute('site');
        if ($site instanceof Site) {
            $siteValue = (string)($site->getSettings()->get($siteSettingKey) ?? '');
            if ($siteValue !== '') {
                return $siteValue;
            }
        }

        return (string)($extConfiguration[$extensionConfigurationKey] ?? '');
    }
}
