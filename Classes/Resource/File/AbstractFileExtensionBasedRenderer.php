<?php

namespace TYPO3\CMS\Document\Resource\File;


use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface;

abstract class AbstractFileExtensionBasedRenderer implements FileRendererInterface
{

    /**
     * Fileextension this renderer can handle
     * @var string
     */
    protected $fileExtension = null;

    public function __construct()
    {
        if ($this->fileExtension === null) {
            $shortName = (new \ReflectionClass($this))->getShortName();
            $this->fileExtension = strtolower(substr($shortName, 0, strlen($shortName) - 12));
        }
    }

    /**
     * Returns the priority of the renderer
     * This way it is possible to define/overrule a renderer
     * for a specific file type/context.
     *
     * For example create a video renderer for a certain storage/driver type.
     *
     * Should be between 1 and 100, 100 is more important than 1
     *
     * @return int
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * Check if given File(Reference) can be rendered
     *
     * @param FileInterface $file File or FileReference to render
     * @return bool
     */
    public function canRender(FileInterface $file)
    {
        if (($this->fileExtension !== null) && (strtolower($file->getExtension()) === $this->fileExtension)) {
            return true;
        }
        return false;
    }

    /**
     * Render for given File(Reference) HTML output
     *
     * @param FileInterface $file
     * @param int|string $width TYPO3 known format; examples: 220, 200m or 200c
     * @param int|string $height TYPO3 known format; examples: 220, 200m or 200c
     * @param array $options
     * @param bool $usedPathsRelativeToCurrentScript See $file->getPublicUrl()
     * @return string
     */
    abstract public function render(FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false);
}