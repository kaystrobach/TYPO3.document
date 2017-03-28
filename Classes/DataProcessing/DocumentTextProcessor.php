<?php

namespace TYPO3\CMS\Document\DataProcessing;


use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Writer\HTML;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class DocumentTextProcessor implements DataProcessorInterface
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
        /** @var \TYPO3\CMS\Core\Resource\FileReference $file */
        foreach ($processedData['files'] as $key => $file) {
            $this->renderDocument($file, $processedData);
        }
        return $processedData;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\FileReference $file
     */
    protected function renderDocument(FileReference $file, &$processedData)
    {
        $originalFileForLocalProcessing = $file->getForLocalProcessing(true);
        $writerTempFileName = GeneralUtility::tempnam('document-html');

        /** @var \PhpOffice\PhpWord\PhpWord $objPhpWord */
        $objPhpWord = IOFactory::load($originalFileForLocalProcessing);
        /** @var HTML $objWriter */
        $objWriter = IOFactory::createWriter($objPhpWord, 'HTML');
        $objWriter->save($writerTempFileName);
        $processedData['renderedDocument'] = file_get_contents($writerTempFileName);

        unlink($writerTempFileName);
        unlink($originalFileForLocalProcessing);
    }
}