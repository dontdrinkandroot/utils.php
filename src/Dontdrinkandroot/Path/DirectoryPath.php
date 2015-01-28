<?php


namespace Dontdrinkandroot\Path;

use Dontdrinkandroot\Utils\StringUtils;

class DirectoryPath extends AbstractPath
{

    protected $name;

    public function __construct($name = null)
    {
        if (strpos($name, '/') !== false) {
            throw new \Exception('Name must not contain /');
        }

        if (!empty($name)) {
            $this->name = $name;
            $this->parentPath = new DirectoryPath();
        }
    }

    /**
     * @param string $name
     *
     * @return DirectoryPath
     * @throws \Exception Thrown if appending directory name fails.
     */
    public function appendDirectory($name)
    {
        if (empty($name)) {
            throw new \Exception('Name must not be empty');
        }

        if (strpos($name, '/') !== false) {
            throw new \Exception('Name must not contain /');
        }

        $directoryPath = new DirectoryPath($name);
        $directoryPath->setParentPath($this);

        return $directoryPath;
    }

    /**
     * @param string $name
     *
     * @return FilePath
     * @throws \Exception Thrown if appending file name fails.
     */
    public function appendFile($name)
    {
        if (empty($name)) {
            throw new \Exception('Name must not be empty');
        }

        if (strpos($name, '/') !== false) {
            throw new \Exception('Name must not contain /');
        }

        $filePath = new FilePath($name);
        $filePath->setParentPath($this);

        return $filePath;
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
     * {@inheritdoc}
     */
    public function toRelativeString($separator = '/')
    {
        if (null === $this->parentPath) {
            return '';
        }

        return $this->parentPath->toRelativeString() . $this->name . $separator;
    }

    /**
     * @inheritdoc
     */
    public function toAbsoluteString($separator = '/')
    {
        if (null === $this->parentPath) {
            return $separator;
        }

        return $this->parentPath->toAbsoluteString() . $this->name . $separator;
    }

    /**
     * @inheritdoc
     */
    public function prepend(DirectoryPath $path)
    {
        return DirectoryPath::parse($path->toAbsoluteUrlString() . $this->toAbsoluteUrlString());
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    public function isRoot()
    {
        return null === $this->parentPath && null === $this->name;
    }

    /**
     * @param string $pathString
     * @param string $separator
     *
     * @return DirectoryPath
     * @throws \Exception
     */
    public static function parse($pathString, $separator = '/')
    {
        if (empty($pathString)) {
            return new DirectoryPath();
        }

        if (!(StringUtils::getLastChar($pathString) === $separator)) {
            throw new \Exception('Path String must end with ' . $separator);
        }

        return self::parseDirectoryPath($pathString, new DirectoryPath(), $separator);
    }

    /**
     * @inheritdoc
     */
    function isDirectoryPath()
    {
        return true;
    }

    public function appendPathString($pathString)
    {
        $lastPath = $this;

        $filePart = null;
        $lastSlashPos = strrpos($pathString, '/');
        $directoryPart = $pathString;
        if ($lastSlashPos === false) {
            $directoryPart = null;
        }
        if (!StringUtils::endsWith($pathString, '/')) {
            $filePart = $pathString;
            if (false !== $lastSlashPos) {
                $directoryPart = substr($pathString, 0, $lastSlashPos + 1);
                $filePart = substr($pathString, $lastSlashPos + 1);
            }
        }

        $directoryPath = self::parseDirectoryPath($directoryPart, $lastPath);

        if (null !== $filePart) {
            $filePath = new FilePath($filePart);
            $filePath->setParentPath($directoryPath);

            return $filePath;
        }

        return $directoryPath;
    }

    protected static function parseDirectoryPath($pathString, DirectoryPath $rootPath, $separator = '/')
    {
        $lastPath = $rootPath;
        if (null !== $pathString) {
            $parts = explode($separator, $pathString);
            foreach ($parts as $part) {
                $trimmedPart = trim($part);
                if ($trimmedPart === '..') {
                    if (!$lastPath->hasParentPath()) {
                        throw new \Exception('Exceeding root level');
                    }
                    $lastPath = $lastPath->getParentPath();
                } else {
                    if ($trimmedPart !== "" && $trimmedPart !== '.') {
                        $directoryPath = new DirectoryPath($trimmedPart);
                        if (null !== $lastPath) {
                            $directoryPath->setParentPath($lastPath);
                        }
                        $lastPath = $directoryPath;
                    }
                }
            }
        }

        return $lastPath;
    }
}