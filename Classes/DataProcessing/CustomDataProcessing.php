<?php

declare(strict_types=1);

namespace NITSAN\NsGoogleSitekit\DataProcessing;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
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
        $extConfiguration = $this->getExtensionConfiguration();

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
        $processedData['domainName'] = is_object($normalizedParams) && method_exists($normalizedParams, 'getRequestHost')
            ? (string)$normalizedParams->getRequestHost()
            : (string)(GeneralUtility::getIndpEnv('HTTP_HOST') ?: '');

        return $processedData;
    }

    private function resolveSetting(
        ContentObjectRenderer $cObj,
        string $siteSettingKey,
        string $extensionConfigurationKey,
        array $extConfiguration
    ): string {
        $request = $cObj->getRequest();
        if (method_exists($request, 'getAttribute')) {
            $site = $request->getAttribute('site');
            if (is_object($site) && method_exists($site, 'getSettings')) {
                $settings = $site->getSettings();
                if (is_object($settings) && method_exists($settings, 'get')) {
                    $siteValue = (string)($settings->get($siteSettingKey) ?? '');
                    if ($siteValue !== '') {
                        return $siteValue;
                    }
                }
            }
        }

        return (string)($extConfiguration[$extensionConfigurationKey] ?? '');
    }

    private function getExtensionConfiguration(): array
    {
        try {
            $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
            $configuration = $extensionConfiguration->get('ns_google_sitekit');
            return is_array($configuration) ? $configuration : [];
        } catch (\Throwable $exception) {
            return [];
        }
    }
}
