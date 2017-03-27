<?php

namespace TYPO3\CMS\Document\DataProcessing;


use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\CsvUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class DocumentSpreadsheetProcessor implements DataProcessorInterface
{

    /**
     * Process content object data
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    )
    {
        $referenceConfiguration = $processorConfiguration['references.'];
        $processedData['tableMaximumColumns'] = $cObj->stdWrapValue('tableMaximumColumns', $referenceConfiguration);
        $processedData['tableFirstRowIsHeader'] = $cObj->stdWrapValue('tableFirstRowIsHeader', $referenceConfiguration);
        $processedData['tableLastRowIsFooter'] = $cObj->stdWrapValue('tableLastRowIsFooter', $referenceConfiguration);


        /** @var \TYPO3\CMS\Core\Resource\FileReference $file */
        foreach ($processedData['files'] as $key => $file) {
            $processedData['tableTitle'] = $file->getTitle();
            $processedData['tableDescription'] = $file->getDescription();
            if ($file->getExtension() === 'csv') {
                $processedData['tableData'] = CsvUtility::csvToArray(
                    $file->getContents(),
                    $file->getProperty('table_delimiter'),
                    $file->getProperty('table_enclosure'),
                    $processedData['tableMaximumColumns']
                );
                if ($processedData['tableFirstRowIsHeader']) {
                    $processedData['tableHeader'] = array_shift($processedData['tableData']);
                }
                if ($processedData['tableLastRowIsFooter']) {
                    $processedData['tableFooter'] = array_pop($processedData['tableData']);
                }
            } else {

            }
        }

        return $processedData;
    }
}