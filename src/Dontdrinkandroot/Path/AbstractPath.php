<?php


namespace Dontdrinkandroot\Path;

abstract class AbstractPath implements Path
{

    /**
     * @var DirectoryPath
     */
    protected $parentPath;

    /**
     * {@inheritdoc}
     */
    public function hasParentPath()
    {
        return (null !== $this->parentPath);
    }

    /**
     * {@inheritdoc}
     */
    public function getParentPath()
    {
        return $this->parentPath;
    }

    /**
     * {@inheritdoc}
     */
    public function collectPaths()
    {
        if (!$this->hasParentPath()) {
            return [$this];
        }

        return array_merge($this->getParentPath()->collectPaths(), [$this]);
    }

    /**
     * {@inheritdoc}
     */
    public function isFilePath()
    {
        return !$this->isDirectoryPath();
    }

    /**
     * {@inheritdoc}
     */
    public function toAbsoluteUrlString()
    {
        return $this->toAbsoluteString('/');
    }

    /**
     * {@inheritdoc}
     */
    public function toRelativeUrlString()
    {
        return $this->toRelativeString('/');
    }

    /**
     * {@inheritdoc}
     */
    public function toAbsoluteFileSystemString()
    {
        return $this->toAbsoluteString(DIRECTORY_SEPARATOR);
    }

    /**
     * {@inheritdoc}
     */
    public function toRelativeFileSystemString()
    {
        return $this->toRelativeString(DIRECTORY_SEPARATOR);
    }

    /**
     * @param DirectoryPath $path
     */
    public function setParentPath(DirectoryPath $path)
    {
        $this->parentPath = $path;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toAbsoluteString();
    }
}
