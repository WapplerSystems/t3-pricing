<?php

declare(strict_types=1);

$ll = 'LLL:EXT:pricing/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pricing_domain_model_group',
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
        'iconfile' => 'EXT:pricing/Resources/Public/Icons/group.svg',
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
            'label' => $ll . 'group.title',
            'config' => [
                'type' => 'input',
                'size' => 40,
                'eval' => 'trim',
                'required' => true,
            ],
        ],
        'layout' => [
            'label' => $ll . 'group.layout',
            'description' => $ll . 'group.layout.hint',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => $ll . 'group.layout.list', 'value' => 'list'],
                    ['label' => $ll . 'group.layout.pairs', 'value' => 'pairs'],
                ],
                'default' => 'list',
            ],
        ],
        'in_card' => [
            'label' => $ll . 'group.inCard',
            'description' => $ll . 'group.inCard.hint',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],
        'in_matrix' => [
            'label' => $ll . 'group.inMatrix',
            'description' => $ll . 'group.inMatrix.hint',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 1,
            ],
        ],

        'attributes' => [
            'label' => $ll . 'group.attributes',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_pricing_domain_model_attribute',
                'foreign_field' => 'attribute_group',
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
                    title, layout, in_card, in_matrix,
                --div--;' . $ll . 'tab.attributes,
                    attributes,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid, l10n_parent, l10n_diffsource,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
            ',
        ],
    ],
];
