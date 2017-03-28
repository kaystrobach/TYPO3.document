<?php

$GLOBALS['TCA']['tt_content']['columns']['table_display_sheets'] = [
    'exclude' => 1,
    'label' => 'LLL:EXT:document/Resources/Private/Language/locallang.xlf:table_display_sheets',
    'config' => [
        'type' => 'select',
        //'renderType' => 'selectCheckBox',
        'renderType' => 'selectMultipleSideBySide',
        'itemsProcFunc' => 'TYPO3\CMS\Document\Tca\Items\ExtractSheets->processItems',
        'minitems' => 1,
        'items' => [
        ],
        'exclusiveKeys' => '-1,-2'
    ],
    'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:xls:xlsx:xml:ods'
];

$GLOBALS['TCA']['tt_content']['types']['document_spreadsheet'] = [
    'showitem' => '--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                 media,
                 table_display_sheets,
               --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                 --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.table_layout;tablelayout,

               --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
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
                                    'elementBrowserAllowed' => 'csv,xlsx,xls,xml,ods',
                                    'disallowedFileExtensions' => ''
                                ]
                            ]
                        ]
                    ]
                ],
                'appearance' => [
                    'headerThumbnail' => false
                ],
                'maxitems' => 1,
                'filter' => [
                    0 => [
                        'parameters' => [
                            'allowedFileExtensions' => 'csv,xlsx,xls,xml,ods',
                            'disallowedFileExtensions' => ''
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$GLOBALS['TCA']['tt_content']['types']['document_text'] = [
    'showitem' => '--palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.general;general,
                 media,
               --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.visibility;visibility,
                 --palette--;LLL:EXT:cms/locallang_ttc.xlf:palette.access;access,
               --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.extended',
    'overrideChildTca' => [
        'columns' => [
            'uid_local' => [
                'config' => [
                    'appearance' => [
                        'elementBrowserAllowed' => 'csv,xlsx,xls',
                    ]
                ]
            ]
        ]
    ],
    'columnsOverrides' => [
        'media' => [
            'config' => [
                'maxitems' => 1,
                'filter' => [
                    0 => [
                        'parameters' => [
                            'allowedFileExtensions' => 'csv,xlsx,xls',
                            'disallowedFileExtensions' => ''
                        ]
                    ]
                ],
                'appearance' => [
                    'headerThumbnail' => false
                ],
            ]
        ]
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
