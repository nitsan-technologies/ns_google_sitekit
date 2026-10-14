<?php

declare(strict_types=1);

namespace NITSAN\NsGoogleSitekit\EventListener;

use NITSAN\NsGoogleSitekit\Backend\PremiumStrip;
use TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException;
use TYPO3\CMS\Backend\Routing\Route;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Backend\Template\Components\ModifyButtonBarEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Exception\SiteNotFoundException;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Shows the premium strip below the "Google Site Kit" category headline in the site settings editor.
 *
 * The site settings editor has no content hook; its doc header (ModifyButtonBarEvent) is built before the
 * page is rendered, so the stylesheet and the module that places the strip are added from here.
 */
#[AsEventListener(identifier: 'ns-google-sitekit/site-settings-premium-strip')]
final class SiteSettingsPremiumStrip
{
    private const SITE_SETTINGS_ROUTE = 'site_configuration.editSettings';
    private const SET_SETTING_KEY = 'ns_google_sitekit.googleTagID';
    private const SETTINGS_CATEGORY = 'ns_google_sitekit';
    private const JAVASCRIPT_MODULE = '@nitsan/ns-google-sitekit/site-settings-premium-strip.js';

    private bool $added = false;

    public function __construct(
        private readonly PageRenderer $pageRenderer,
        private readonly SiteFinder $siteFinder,
        private readonly UriBuilder $uriBuilder,
        private readonly PremiumStrip $premiumStrip,
    ) {}

    public function __invoke(ModifyButtonBarEvent $event): void
    {
        if ($this->added) {
            return;
        }
        $request = $event->getRequest();
        $route = $request->getAttribute('route');
        if (!$route instanceof Route || $route->getOption('_identifier') !== self::SITE_SETTINGS_ROUTE) {
            return;
        }

        try {
            $site = $this->siteFinder->getSiteByIdentifier((string)($request->getQueryParams()['site'] ?? ''));
        } catch (SiteNotFoundException) {
            return;
        }
        if (!$site->getSettings()->has(self::SET_SETTING_KEY)) {
            return;
        }

        try {
            $trialUrl = $this->uriBuilder->buildUriFromRoute(
                PremiumStrip::LICENSE_MODULE_ROUTE,
                PremiumStrip::TRIAL_PARAMETERS,
                UriBuilder::SHAREABLE_URL
            ) . PremiumStrip::LICENSE_FREE_SECTION_ANCHOR;
        } catch (RouteNotFoundException) {
            return;
        }

        $this->pageRenderer->addCssFile(PremiumStrip::STYLESHEET);
        $this->pageRenderer->getJavaScriptRenderer()->addJavaScriptModuleInstruction(
            JavaScriptModuleInstruction::create(self::JAVASCRIPT_MODULE, 'insertPremiumStrip')
                ->invoke(null, $this->premiumStrip->render($trialUrl), self::SETTINGS_CATEGORY)
        );
        $this->added = true;
    }
}
