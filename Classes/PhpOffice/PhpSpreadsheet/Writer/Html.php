<?php

namespace TYPO3\CMS\Document\PhpOffice\PhpSpreadsheet\Writer;


class Html extends \PhpOffice\PhpSpreadsheet\Writer\Html
{
    /**
     * Generate CSS styles.
     *
     * @param bool $generateSurroundingHTML Generate surrounding HTML tags? (&lt;style&gt; and &lt;/style&gt;)
     *
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     *
     * @return string
     */
    public function generateStyles($generateSurroundingHTML = true)
    {
        $css = parent::generateStyles($generateSurroundingHTML);
        $css = preg_replace(
            [
                '/font-family:[^;]*;/i',
                '/font-size:[^;]*;/i',
            ],
            [
                '',
                ''
            ],
            $css
        );
        return $css;
    }
}