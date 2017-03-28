<?php

if (file_exists(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('document') . '/Resources/Private/PHP/vendor/autoload.php')) {
    require_once \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('document') . '/Resources/Private/PHP/vendor/autoload.php';
}

$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'tx_document_spreadsheet',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:document/Resources/Public/Images/document-spreadsheet.svg']
);
$iconRegistry->registerIcon(
    'tx_document_text',
    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
    ['source' => 'EXT:document/Resources/Public/Images/document-text.svg']
);

$fileExtensions = [
    'csv'
];

/** @var \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry $fileRendererRegistry */
$fileRendererRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::class
);

foreach ($fileExtensions as $extension) {
    $className = 'TYPO3\\CMS\\Document\\Resource\\File\\' . ucfirst($extension) . 'FileRenderer';
    #if (class_exists($className)) {
        $fileRendererRegistry->registerRendererClass($className);
    #}
}