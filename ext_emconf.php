<?php

$EM_CONF['ns_google_sitekit'] = [
    'title' => 'Official Google Site Kit for TYPO3',
    'description' => "Connect Google Analytics, Search Console, PageSpeed Insights, and Tag Manager to your TYPO3 site without coding. Improve your website's performance and SEO with the Official Google Site Kit.",
    'category' => 'be',
    'author' => 'T3: Navdeepsinh Jethwa T3: Vishal Solanki',
    'author_company' => 'T3Planet // NITSAN',
    'author_email' => 'sanjay@nitsan.in',
    'state' => 'stable',
    'uploadfolder' => 1,
    'createDirs' => '',
    'version' => '1.0.0',
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

