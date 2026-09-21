<?php

declare(strict_types=1);

$ll = 'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pricing_domain_model_table',
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
        'searchFields' => 'title,description',
        'iconfile' => 'EXT:pricing/Resources/Public/Icons/table.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'title' => [
            'label' => $ll . 'table.title',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'description' => [
            'label' => $ll . 'table.description',
            'description' => $ll . 'table.description.hint',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 40,
            ],
        ],

        'tax_mode' => [
            'label' => $ll . 'table.taxMode',
            'description' => $ll . 'table.taxMode.hint',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . 'table.taxMode.net', 'value' => 'net'],
                    ['label' => $ll . 'table.taxMode.gross', 'value' => 'gross'],
                ],
                'default' => 'net',
            ],
        ],
        'tax_rate' => [
            'label' => $ll . 'table.taxRate',
            'description' => $ll . 'table.taxRate.hint',
            'displayCond' => 'FIELD:tax_mode:=:net',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'size' => 10,
                'default' => 0,
                'range' => ['lower' => 0, 'upper' => 100],
            ],
        ],
        'tax_switchable' => [
            'label' => $ll . 'table.taxSwitchable',
            'description' => $ll . 'table.taxSwitchable.hint',
            'displayCond' => 'FIELD:tax_mode:=:net',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'currency_switchable' => [
            'label' => $ll . 'table.currencySwitchable',
            'description' => $ll . 'table.currencySwitchable.hint',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'period_switchable' => [
            'label' => $ll . 'table.periodSwitchable',
            'description' => $ll . 'table.periodSwitchable.hint',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'select_label' => [
            'label' => $ll . 'table.selectLabel',
            'description' => $ll . 'table.selectLabel.hint',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'placeholder' => 'Auswählen',
            ],
        ],

        'plans' => [
            'label' => $ll . 'table.plans',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_pricing_domain_model_plan',
                'foreign_field' => 'pricing_table',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'collapseAll' => true,
                    'useSortable' => true,
                    'showSynchronizationLink' => false,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'newRecordLinkAddTitle' => true,
                    'levelLinksPosition' => 'bottom',
                ],
            ],
        ],
        'groups' => [
            'label' => $ll . 'table.groups',
            'description' => $ll . 'table.groups.hint',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_pricing_domain_model_group',
                'foreign_field' => 'pricing_table',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'collapseAll' => true,
                    'useSortable' => true,
                    'newRecordLinkAddTitle' => true,
                    'levelLinksPosition' => 'bottom',
                ],
            ],
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general,
                    title, description,
                --div--;' . $ll . 'tab.plans,
                    plans,
                --div--;' . $ll . 'tab.attributes,
                    groups,
                --div--;' . $ll . 'tab.prices,
                    tax_mode, tax_rate, tax_switchable, currency_switchable, period_switchable, select_label,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid, l10n_parent, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
            ',
        ],
    ],
];
