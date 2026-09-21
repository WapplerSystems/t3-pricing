<?php

declare(strict_types=1);

$ll = 'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pricing_domain_model_attribute',
        'label' => 'title',
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
        'searchFields' => 'title',
        'hideTable' => true,
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'attribute_group' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'title' => [
            'label' => $ll . 'attribute.title',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'value_type' => [
            'label' => $ll . 'attribute.valueType',
            'description' => $ll . 'attribute.valueType.hint',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . 'attribute.valueType.check', 'value' => 'check'],
                    ['label' => $ll . 'attribute.valueType.number', 'value' => 'number'],
                    ['label' => $ll . 'attribute.valueType.text', 'value' => 'text'],
                    ['label' => $ll . 'attribute.valueType.percent', 'value' => 'percent'],
                ],
                'default' => 'check',
            ],
        ],
        'unit' => [
            'label' => $ll . 'attribute.unit',
            'description' => $ll . 'attribute.unit.hint',
            'displayCond' => 'FIELD:value_type:IN:number,percent',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
            ],
        ],
        'footnote' => [
            'label' => $ll . 'attribute.footnote',
            'description' => $ll . 'attribute.footnote.hint',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general,
                    title, value_type, unit, footnote,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid, l10n_parent, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
            ',
        ],
    ],
];
