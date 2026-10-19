<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Pricing tables',
    'description' => 'Plan cards, comparison table and compact rows from one data model. Currency, billing period and net/gross switches without page reload, highlighted plan, translatable, accessible.',
    'category' => 'plugin',
    'author' => 'Sven Wappler',
    'author_email' => 'typo3@wappler.systems',
    'author_company' => 'WapplerSystems',
    'state' => 'beta',
    'version' => '0.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '14.0.0-14.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
