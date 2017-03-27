<?php

$GLOBALS['TCA']['sys_file_metadata']['columns']['table_delimiter'] = [
    'label' => 'LLL:EXT:document/Resources/Private/Language/locallang.xlf:table_delimiter',
    'config' => [
        'type' => 'input',
        'placeholder' => ';',
        'eval' => 'null',
        'default' => ';',
        'mode' => 'useOrOverridePlaceholder',
        'valuePicker' => [
            'items' => [
                [ ';', ';', ],
                [ ',', ',', ],
                [ '|', '|', ],
            ],
        ],
        'max' => 1,
    ],
    'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:csv:txt'
];
$GLOBALS['TCA']['sys_file_metadata']['columns']['table_enclosure'] = [
    'label' => 'LLL:EXT:document/Resources/Private/Language/locallang.xlf:table_enclosure',
    'config' => [
        'type' => 'input',
        'placeholder' => '"',
        'eval' => 'null',
        'default' => '"',
        'mode' => 'useOrOverridePlaceholder',
        'valuePicker' => [
            'items' => [
                [ '"', '"', ],
                [ '\'', '\'', ],
            ],
        ],
        'max' => 1,
    ],
    'displayCond' => 'USER:TYPO3\CMS\Document\Tca\DisplayCondition\FileExtensionCondition->match:csv:txt'
];
foreach ($GLOBALS['TCA']['sys_file_metadata']['types'] as $key => $type) {
    $GLOBALS['TCA']['sys_file_metadata']['types'][$key]['showitem'] .= ','
        . '--div--;LLL:EXT:document/Resources/Private/Language/locallang.xlf:rendering_options,'
        . 'table_delimiter, table_enclosure';
}