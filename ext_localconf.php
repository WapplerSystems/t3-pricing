<?php

declare(strict_types=1);

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pricing',
    'Table',
    [
        \WapplerSystems\Pricing\Controller\TableController::class => 'show',
    ],
    // Die Schalter laufen im Browser, es gibt nichts Uncachebares.
    []
);
