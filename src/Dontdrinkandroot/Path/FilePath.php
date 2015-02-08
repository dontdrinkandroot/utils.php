<?php


namespace Dontdrinkandroot\Path;

use Dontdrinkandroot\Utils\StringUtils;

class FilePath extends AbstractPath
{

    protected $fileName;

    protected $extension;

    public function __construct($name)
    {
        if (empty($name)) {
            throw new \Exception('Name must not be empty');
        }

        if (strpos($name, '/') !== false) {
            throw new \Exception('Name must not contain /');
        }

        $this->fileName = $name;
        $lastDotPos = strrpos($name, '.');
        if (false !== $lastDotPos && $lastDotPos > 0) {
            $this->fileName = substr($name, 0, $lastDotPos);
            $this->extension = substr($name, $lastDotPos + 1);
        }

        $this->parentPath = new DirectoryPath();
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        $name = $this->fileName;
        if (null !== $this->extension) {
            $name .= '.' . $this->extension;
        }

        return $name;
    }

    /**
     * @deprecated
     * @inheritdoc
     */
    public function toAbsoluteUrlString()
    {
        return $this->toAbsoluteString('/');
    }

    /**
     * @deprecated
     * @inheritdoc
     */
    public function toRelativeUrlString()
    {
        return $this->toRelativeString('/');
    }

    /**
     * @deprecated
     * @inheritdoc
     */
    public function toAbsoluteFileString()
    {
        return $this->toAbsoluteString(DIRECTORY_SEPARATOR);
    }

    /**
     * @deprecated
     * @inheritdoc
     */
    public function toRelativeFileString()
    {
        return $this->toRelativeString(DIRECTORY_SEPARATOR);
    }

    /**
     * @inheritdoc
     */
    function toRelativeString($separator = '/')
    {
        return $this->parentPath->toRelativeString($separator) . $this->getName();
    }

    /**
     * @inheritdoc
     */
    function toAbsoluteString($separator = '/')
    {
        return $this->parentPath->toAbsoluteString($separator) . $this->getName();
    }

    /**
     * @inheritdoc
     */
    public function prepend(DirectoryPath $path)
    {
        return FilePath::parse($path->toAbsoluteUrlString() . $this->toAbsoluteUrlString());
    }

    /**
     * @inheritdoc
     */
    public function isDirectoryPath()
    {
        return false;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $pathString
     * @param string $separator
     *
     * @return FilePath
     * @throws \Exception
     */
    public static function parse($pathString, $separator = '/')
    {
        if (empty($pathString)) {
            throw new \Exception('Path String must not be empty');
        }

        if (StringUtils::getLastChar($pathString) === $separator) {
            throw new \Exception('Path String must not end with ' . $separator);
        }

        $directoryPart = null;
        $filePart = $pathString;
        $lastSlashPos = strrpos($pathString, $separator);
        if (false !== $lastSlashPos) {
            $directoryPart = substr($pathString, 0, $lastSlashPos + 1);
            $filePart = substr($pathString, $lastSlashPos + 1);
        }

        $filePath = new FilePath($filePart);

        if (null !== $directoryPart) {
            $filePath->setParentPath(DirectoryPath::parse($directoryPart, $separator));
        }

        return $filePath;
    }
}
