<?php

declare(strict_types=1);

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Pricing',
    'Table',
    'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:plugin.table',
    'EXT:pricing/Resources/Public/Icons/table.svg',
    'plugins'
);

$GLOBALS['TCA']['tt_content']['types']['pricing_table']['showitem'] = '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        --palette--;;general,
        --palette--;;headers,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin,
        pi_flexform,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
        --palette--;;frames,
        --palette--;;appearanceLinks,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
        --palette--;;language,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
        --palette--;;hidden,
        --palette--;;access,
';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:pricing/Configuration/FlexForms/Table.xml',
    'pricing_table'
);
