<?php

namespace NITSAN\NsGoogleSitekit\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\Exception\ContentRenderingException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class CustomDataProcessing implements DataProcessorInterface{
    
    /**
     * Process data
     *
     * @param ContentObjectRenderer $cObj The content object renderer, which contains data of the content element
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     * @throws ContentRenderingException
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $extConfiguration = $extensionConfiguration->get('ns_google_sitekit');
        $processedData['verificationToken'] = $extConfiguration['verificationToken'];
        $processedData['googleTagID'] = $extConfiguration['googleTagID'];
        $processedData['tagmanagerContainer'] = $extConfiguration['tagmanagerContainer'];
        $processedData['conversionTrackingId'] = $extConfiguration['conversionTrackingId'];
        $processedData['adsenseClientId'] = $extConfiguration['adsenseClientId'];
        $processedData['domainName'] = GeneralUtility::getIndpEnv('HTTP_HOST');
        return $processedData;
    }

}
