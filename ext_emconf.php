<?php

$EM_CONF['ns_google_sitekit'] = [
    'title' => 'Official Site Kit by Google for TYPO3',
    'description' => "Know what's going on with your TYPO3 site? How users visit and interact with your pages? Get Every Insights of Popular Google Tools including Google Analytics, Search Console, Google Ads & AdSense, and Tag Manager to your TYPO3 site without coding. Improve your website's performance and SEO.",
    'category' => 'be',
    'author' => 'T3: Navdeepsinh Jethwa',
    'author_company' => 'T3Planet // NITSAN',
    'author_email' => 'sanjay@nitsan.in',
    'state' => 'stable',
    'uploadfolder' => 1,
    'createDirs' => '',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-12.5.99',
            'ns_license' => '1.0.0-12.1.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'NITSAN\\NsGoogleSitekit\\' => 'Classes'
        ],
    ],

];

