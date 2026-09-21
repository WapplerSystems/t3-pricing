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
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'hideTable' => true,
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'plan' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'attribute' => [
            'label' => $ll . 'value.attribute',
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
            ',
        ],
    ],
];
