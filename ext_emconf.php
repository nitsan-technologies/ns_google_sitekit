<?php

$EM_CONF['ns_google_sitekit'] = [
    'title' => 'Site Kit by Google for TYPO3',
    'description' => "Know what's going on with your TYPO3 site? How users visit and interact with your pages? Get Every Insights with single click button of Popular Google Tools including Google Analytics, Search Console, Google Ads & AdSense, and Tag Manager to your TYPO3 site without coding. Improve your website's performance and SEO.",
    'category' => 'be',
    'author' => 'T3: Navdeepsinh Jethwa T3: Vishal Solanki',
    'author_company' => 'T3Planet // NITSAN',
    'author_email' => 'sanjay@nitsan.in',
    'state' => 'stable',
    'uploadfolder' => 1,
    'createDirs' => '',
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-12.5.99'
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

