<?php

declare(strict_types=1);

$ll = 'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pricing_domain_model_price',
        'label' => 'amount',
        'label_alt' => 'currency,period',
        'label_alt_force' => true,
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
    /* Translatable, so that a translated plan keeps its prices: Extbase looks up
       the children of a translated record by that record's own uid. Amount,
       currency and period stay tied to the default language. */
    'columns' => [
        'plan' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'currency' => [
            'label' => $ll . 'price.currency',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'EUR €', 'value' => 'EUR'],
                    ['label' => 'CHF', 'value' => 'CHF'],
                    ['label' => 'USD $', 'value' => 'USD'],
                    ['label' => 'GBP £', 'value' => 'GBP'],
                ],
                'default' => 'EUR',
            ],
        ],
        'period' => [
            'label' => $ll . 'price.period',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . 'price.period.month', 'value' => 'month'],
                    ['label' => $ll . 'price.period.year', 'value' => 'year'],
                    ['label' => $ll . 'price.period.once', 'value' => 'once'],
                    ['label' => $ll . 'price.period.custom', 'value' => 'custom'],
                ],
                'default' => 'month',
            ],
        ],
        'unit_label' => [
            'label' => $ll . 'price.unitLabel',
            'description' => $ll . 'price.unitLabel.hint',
            'displayCond' => 'FIELD:period:=:custom',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],

        'amount' => [
            'label' => $ll . 'price.amount',
            'l10n_mode' => 'exclude',
            'displayCond' => 'FIELD:on_request:=:0',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
            ],
        ],

        'on_request' => [
            'label' => $ll . 'price.onRequest',
            'l10n_mode' => 'exclude',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'on_request_label' => [
            'label' => $ll . 'price.onRequestLabel',
            'description' => $ll . 'price.onRequestLabel.hint',
            'displayCond' => 'FIELD:on_request:>:0',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'placeholder' => $ll . 'price.onRequest',
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general,
                    currency, period, unit_label, amount, on_request, on_request_label, hidden,
                    sys_language_uid, l10n_parent, l10n_diffsource,
            ',
        ],
    ],
];
