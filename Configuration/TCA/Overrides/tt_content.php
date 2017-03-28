<?php

$GLOBALS['TCA']['tt_content']['columns']['table_display_sheets'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:document/Resources/Private/Language/locallang.xlf:table_display_sheets',
    'config' => [
        'type' => 'select',
        'renderType' => 'selectMultipleSideBySide',
        'itemsProcFunc' => 'TYPO3\CMS\Document\Tca\Items\ExtractSheets->processItems',
        'minitems' => 1,
        'items' => [
        ],
        'exclusiveKeys' => '-1,-2'
    ],
    'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:xls,xlsx,ods'
];
$GLOBALS['TCA']['tt_content']['columns']['table_display_images'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:document/Resources/Private/Language/locallang.xlf:table_display_images',
    'config' => [
        'type' => 'check',
    ],
    'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:xls,xlsx,ods'
];
$GLOBALS['TCA']['tt_content']['columns']['table_display_colors'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:document/Resources/Private/Language/locallang.xlf:table_display_colors',
    'config' => [
        'type' => 'check',
    ],
    'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:xls,xlsx,ods'
];


$GLOBALS['TCA']['tt_content']['types']['document_spreadsheet'] = [
    'showitem' => '
               --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                 media,
                 table_display_sheets,
               --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                 table_display_images,
                 table_display_colors,
                 --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.table_layout;tablelayout,
               --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                 --palette--;;hidden,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
               --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended',

    'columnsOverrides' => [
        'media' => [
            'config' => [
                'overrideChildTca' => [
                    'columns' => [
                        'uid_local' => [
                            'config' => [
                                'appearance' => [
                                    'elementBrowserAllowed' => 'csv,xlsx,xls,ods,slk',
                                    'disallowedFileExtensions' => ''
                                ]
                            ]
                        ]
                    ]
                ],
                'appearance' => [
                    'headerThumbnail' => false,
                    'fileUploadAllowed' => true,
                    'collapseAll' => false,
                ],
                'maxitems' => 1,
                'filter' => [
                    0 => [
                        'parameters' => [
                            'allowedFileExtensions' => 'csv,xlsx,xls,ods,slk',
                            'disallowedFileExtensions' => ''
                        ]
                    ]
                ]
            ]
        ],
        'cols' => [
            'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:csv'
        ],
        'table_header_position' => [
            'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:csv'
        ],
        'table_tfoot' => [
            'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:csv'
        ],
        'table_class' => [
            'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:csv'
        ],
    ]
];

$GLOBALS['TCA']['tt_content']['types']['document_text'] = [
    'showitem' => '
               --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                 media,
               --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
               --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                 --palette--;;hidden,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
               --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended',
    'columnsOverrides' => [
        'media' => [
            'config' => [
                'overrideChildTca' => [
                    'columns' => [
                        'uid_local' => [
                            'config' => [
                                'appearance' => [
                                    'elementBrowserAllowed' => 'docx,odt',
                                    'disallowedFileExtensions' => ''
                                ]
                            ]
                        ]
                    ]
                ],
                'appearance' => [
                    'headerThumbnail' => false,
                    'fileUploadAllowed' => true,
                    'collapseAll' => false,
                ],
                'maxitems' => 1,
                'filter' => [
                    0 => [
                        'parameters' => [
                            'allowedFileExtensions' => 'docx,odt',
                            'disallowedFileExtensions' => ''
                        ]
                    ]
                ]
            ]
        ],
    ]
];

$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:document/Resources/Private/Language/locallang.xlf:document_spreadsheet_title',
    'document_spreadsheet',
    'tx_document_spreadsheet'
];
$GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'][] = [
    'LLL:EXT:document/Resources/Private/Language/locallang.xlf:document_text_title',
    'document_text',
    'tx_document_text'
];
