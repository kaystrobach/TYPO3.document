<?php

namespace TYPO3\CMS\Document\DataProcessing;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\CsvUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
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
        $processedData['tableDisplayColors'] = $cObj->stdWrapValue('tableDisplayColors', $referenceConfiguration);
        $processedData['tableDisplayImages'] = $cObj->stdWrapValue('tableDisplayImages', $referenceConfiguration);
        $processedData['tableSheetsToRender'] = GeneralUtility::trimExplode(
            ',',
            $cObj->cObjGetSingle($referenceConfiguration['tableSheetsToRender'], $referenceConfiguration['tableSheetsToRender.'])
        );

        /** @var \TYPO3\CMS\Core\Resource\FileReference $file */
        foreach ($processedData['files'] as $key => $file) {
            $processedData['tableTitle'] = $file->getTitle();
            $processedData['tableDescription'] = $file->getDescription();
            if ($file->getExtension() === 'csv') {
                $this->renderCsvData($file, $processedData);
            } else {
                $this->renderSpreadsheet($file, $processedData);
            }
        }

        return $processedData;
    }

    protected function renderCsvData(FileReference $file, &$processedData)
    {
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
    }

    protected function renderSpreadsheet(FileReference $file, &$processedData)
    {
        if (count($processedData['tableSheetsToRender']) === 0) {
            return;
        }

        $originalFileForLocalProcessing = $file->getForLocalProcessing(true);
        $writerTempFileName = GeneralUtility::tempnam('document-html');

        $objPHPExcel = IOFactory::load($originalFileForLocalProcessing);
        /** @var Html $objWriter */
        $objWriter = new \TYPO3\CMS\Document\PhpOffice\PhpSpreadsheet\Writer\Html($objPHPExcel);
        $objWriter->generateSheetData();
        $objWriter->setUseInlineCss(false);
        if ($processedData['tableDisplayImages']) {
            $objWriter->setEmbedImages(true);
            $objWriter->setImagesRoot(sys_get_temp_dir());
        }

        $objWriter->save($writerTempFileName);


        foreach ($processedData['tableSheetsToRender'] as $sheetNumber) {
            try {
                $objWriter->setSheetIndex($sheetNumber);
                $objWriter->save($writerTempFileName);
                $processedData['renderedSheets'][] = [
                    'title' => $objPHPExcel->getSheet($sheetNumber)->getTitle(),
                    //'content' => file_get_contents($writerTempFileName)
                    'content' => $objWriter->generateSheetData(),
                    'styles' => $processedData['tableDisplayColors'] ? $objWriter->generateStyles(false) : '',
                ];
            } catch (\Exception $e) {
                // ignore
            }

        }

        //$processedData['renderedTable'] = file_get_contents($writerTempFileName);

        unlink($writerTempFileName);
        unlink($originalFileForLocalProcessing);
    }
}