<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    'mod {
     wizards.newContentElement.wizardItems.extra {
       elements {
         document_spreadsheet {
           iconIdentifier = tx_document_spreadsheet
           title = LLL:EXT:document/Resources/Private/Language/locallang.xlf:document_spreadsheet_title
           description = LLL:EXT:document/Resources/Private/Language/locallang.xlf:document_spreadsheet_description
           tt_content_defValues {
             CType = document_spreadsheet
           }
         }
         document_text {
           iconIdentifier = tx_document_text
           title = LLL:EXT:document/Resources/Private/Language/locallang.xlf:document_text_title
           description = LLL:EXT:document/Resources/Private/Language/locallang.xlf:document_text_description
           tt_content_defValues {
             CType = document_text
           }
         }
       }
       show = *
     }
    }'
);
