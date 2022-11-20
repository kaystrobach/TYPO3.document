<?php

namespace TYPO3\CMS\Document\Tca\Items;

use PhpOffice\PhpSpreadsheet\IOFactory;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaSelectItems;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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

        /** @var  TcaSelectItems $itemsObject */
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
        $connection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('sys_file_reference');
        $fileMetadata = $connection->select(
            ['*'],
            'sys_file_reference',
            [
                'uid_foreign' => $contentElementUid
            ]
        )->getIterator()->fetchAllAssociative();

        if (isset($fileMetadata[0]['uid_local'])) {
            $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
            return $resourceFactory->getFileObject($fileMetadata[0]['uid_local']);
        }
        return null;
    }
}