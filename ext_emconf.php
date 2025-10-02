<?php

$EM_CONF['ns_google_sitekit'] = [
    'title' => 'Google Site Kit Integration for TYPO3',
    'description' => "Integrate Google tools like Analytics, Search Console, Google Ads, AdSense, and Tag Manager into your TYPO3 site—without writing any code. Track user behavior, enhance SEO, and optimize your website’s performance with a single extension.",
    'category' => 'be',
    'author' => 'Team T3Planet',
    'author_company' => 'T3Planet',
    'author_email' => 'info@t3planet.de',
    'state' => 'stable',
    'uploadfolder' => 1,
    'createDirs' => '',
    'version' => '1.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-13.4.99'
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

