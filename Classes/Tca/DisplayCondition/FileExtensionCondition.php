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
        $fileRecord = BackendUtility::getRecord(
            'sys_file',
            $parameter['record']['file'][0]
        );
        if ($fileRecord !== null) {
            if (in_array($fileRecord['extension'], $parameter['conditionParameters'])) {
                return true;
            }
        }
        return false;
    }
}