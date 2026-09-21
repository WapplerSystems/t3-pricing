<?php

declare(strict_types=1);

$ll = 'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pricing_domain_model_plan',
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
        'searchFields' => 'title,subtitle,description',
        'hideTable' => true,
        'iconfile' => 'EXT:pricing/Resources/Public/Icons/plan.svg',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'columns' => [
        'pricing_table' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'title' => [
            'label' => $ll . 'plan.title',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'subtitle' => [
            'label' => $ll . 'plan.subtitle',
            'description' => $ll . 'plan.subtitle.hint',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
            ],
        ],
        'eyebrow' => [
            'label' => $ll . 'plan.eyebrow',
            'description' => $ll . 'plan.eyebrow.hint',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],
        'description' => [
            'label' => $ll . 'plan.description',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 40,
            ],
        ],

        'favourite' => [
            'label' => $ll . 'plan.favourite',
            'description' => $ll . 'plan.favourite.hint',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'badge' => [
            'label' => $ll . 'plan.badge',
            'description' => $ll . 'plan.badge.hint',
            'displayCond' => 'FIELD:favourite:>:0',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'placeholder' => 'Beliebt',
            ],
        ],

        'select_link' => [
            'label' => $ll . 'plan.selectLink',
            'description' => $ll . 'plan.selectLink.hint',
            'config' => [
                'type' => 'link',
                'size' => 40,
            ],
        ],
        'select_label' => [
            'label' => $ll . 'plan.selectLabel',
            'description' => $ll . 'plan.selectLabel.hint',
            'displayCond' => 'FIELD:select_link:REQ:true',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
            ],
        ],

        'price_note' => [
            'label' => $ll . 'plan.priceNote',
            'description' => $ll . 'plan.priceNote.hint',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
            ],
        ],

        'prices' => [
            'label' => $ll . 'plan.prices',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_pricing_domain_model_price',
                'foreign_field' => 'plan',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'collapseAll' => true,
                    'useSortable' => true,
                    'newRecordLinkAddTitle' => true,
                    'levelLinksPosition' => 'bottom',
                ],
            ],
        ],
        'attribute_values' => [
            'label' => $ll . 'plan.attributeValues',
            'description' => $ll . 'plan.attributeValues.hint',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_pricing_domain_model_value',
                'foreign_field' => 'plan',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'collapseAll' => false,
                    'useSortable' => false,
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
                    title, subtitle, eyebrow, description,
                --div--;' . $ll . 'tab.prices,
                    prices, price_note,
                --div--;' . $ll . 'tab.attributes,
                    attribute_values,
                --div--;' . $ll . 'tab.highlight,
                    favourite, badge, select_link, select_label,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid, l10n_parent, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
            ',
        ],
    ],
];
