<?php

namespace TYPO3\CMS\Document\Tca\DisplayCondition;


use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class FileExtensionCondition
{
    /**
     * @param array $parameter
     * @return bool
     */
    public function match($parameter) : bool
    {
        $fileRecord = $this->getFileRecord($parameter);



        if ($fileRecord !== null) {
            if (isset($parameter['conditionParameters'][0])) {
                $allowedExtensions = explode(',', $parameter['conditionParameters'][0]);
                if (in_array($fileRecord['extension'], $allowedExtensions)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function getFileRecord($parameter)
    {
        $fileRecord = null;
        if (isset($parameter['record']['file'][0])) {
            // handle sys_file_meta_data
            $fileRecord = BackendUtility::getRecord(
                'sys_file',
                $parameter['record']['file'][0]
            );
        } elseif (isset($parameter['record']['media'])) {
            $fileMetadata = BackendUtility::getRecord(
                'sys_file_reference',
                $parameter['record']['media']
            );
            $fileRecord = BackendUtility::getRecord(
                'sys_file',
                $fileMetadata['uid_local']
            );
        } else {
            print_r($fileRecord);
            die();
        }



        return $fileRecord;
    }
}