<?php

namespace TYPO3\CMS\Document\Tca\Items;

use PhpOffice\PhpSpreadsheet\IOFactory;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ExtractSheets
{

    /**
     * @param array $params
     * @param TcaSelectItems $config
     * @return mixed
     */
    public function processItems(&$params, $config)
    {
        $row = $params['row'];
        $file = $this->getFileRecord($row['uid']);

        if ($file === null) {
            return $params;
        }

        /** @var  TcaSelectItems $itemsObject */;
        $originalFileForLocalProcessing = $file->getForLocalProcessing(true);
        try {
            $objPHPExcel = IOFactory::load($originalFileForLocalProcessing);

            $sheets = $objPHPExcel->getAllSheets();
            foreach ($sheets as $key => $sheet) {
                $params['items'][] = [
                    $sheet->getTitle(),
                    $key
                ];
            }

        } catch (\Exception $e) {
            // ignore
        }


        unlink($originalFileForLocalProcessing);
        return $params;
    }

    /**
     * @param $contentElementUid
     * @return \TYPO3\CMS\Core\Resource\File
     */
    public function getFileRecord($contentElementUid)
    {
        $fileMetadata = BackendUtility::getRecordsByField(
            'sys_file_reference',
            'uid_foreign',
            $contentElementUid
        );
        if (isset($fileMetadata[0]['uid_local'])) {
            $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
            $file = $resourceFactory->getFileObject($fileMetadata[0]['uid_local']);
            return $file;
        }
        return null;
    }
}