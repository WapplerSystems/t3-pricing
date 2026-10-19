<?php

declare(strict_types=1);

$ll = 'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pricing_domain_model_value',
        'label' => 'attribute',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'translationSource' => 'l10n_source',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'hideTable' => true,
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    /* Translatable like the prices: the text ("unlimited") is translated,
       feature and check come from the default language. */
    'columns' => [
        'plan' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'attribute' => [
            'label' => $ll . 'value.attribute',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_pricing_domain_model_attribute',
                'foreign_table_where' => ' ORDER BY tx_pricing_domain_model_attribute.sorting',
                'itemsProcFunc' => \WapplerSystems\Pricing\Tca\AttributeItems::class . '->build',
                'default' => 0,
            ],
        ],

        'included' => [
            'label' => $ll . 'value.included',
            'l10n_mode' => 'exclude',
            'description' => $ll . 'value.included.hint',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'value' => [
            'label' => $ll . 'value.value',
            'description' => $ll . 'value.value.hint',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general,
                    attribute, included, value, hidden,
                    sys_language_uid, l10n_parent, l10n_diffsource,
            ',
        ],
    ],
];
