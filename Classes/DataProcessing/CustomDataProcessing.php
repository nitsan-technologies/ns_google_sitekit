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

        $processedData['verificationToken'] = (string)($extConfiguration['verificationToken'] ?? '');
        $processedData['googleTagID'] = (string)($extConfiguration['googleTagID'] ?? '');
        $processedData['tagmanagerContainer'] = (string)($extConfiguration['tagmanagerContainer'] ?? '');
        $processedData['adsenseClientId'] = (string)($extConfiguration['adsenseClientId'] ?? '');

        $request = $cObj->getRequest();
        $normalizedParams = $request->getAttribute('normalizedParams');
        $processedData['domainName'] = is_object($normalizedParams) && method_exists($normalizedParams, 'getRequestHost')
            ? (string)$normalizedParams->getRequestHost()
            : (string)(GeneralUtility::getIndpEnv('HTTP_HOST') ?: '');

        return $processedData;
    }

    private function getExtensionConfiguration(): array
    {
        try {
            $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
            $configuration = $extensionConfiguration->get('ns_google_sitekit');
            return is_array($configuration) ? $configuration : [];
        } catch (\Throwable) {
            return [];
        }
    }
}
