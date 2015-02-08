<?php


namespace Dontdrinkandroot\Path;

abstract class AbstractPath implements Path
{

    /**
     * @var DirectoryPath
     */
    protected $parentPath;

    /**
     * @inheritdoc
     */
    public function hasParentPath()
    {
        return (null !== $this->parentPath);
    }

    /**
     * @inheritdoc
     */
    public function getParentPath()
    {
        return $this->parentPath;
    }

    /**
     * @inheritdoc
     */
    public function collectPaths()
    {
        if (!$this->hasParentPath()) {
            return array($this);
        }

        return array_merge($this->getParentPath()->collectPaths(), array($this));
    }

    /**
     * @inheritdoc
     */
    public function isFilePath()
    {
        return !$this->isDirectoryPath();
    }

    public function setParentPath(DirectoryPath $path)
    {
        $this->parentPath = $path;
    }

    public function __toString()
    {
        return $this->toAbsoluteUrlString();
    }
}
