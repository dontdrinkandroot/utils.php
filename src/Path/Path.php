<?php


namespace Dontdrinkandroot\Path;

interface Path
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function hasParentPath();

    /**
     * @return DirectoryPath
     */
    public function getParentPath();

    /**
     * @param DirectoryPath $path
     *
     * @return Path
     */
    public function prepend(DirectoryPath $path);

    /**
     * @return Path[]
     */
    public function collectPaths();

    /**
     * @return string
     */
    public function toAbsoluteUrlString();

    /**
     * @return string
     */
    public function toRelativeUrlString();

    /**
     * @return string
     */
    public function toAbsoluteFileSystemString();

    /**
     * @return string
     */
    public function toRelativeFileSystemString();

    /**
     * @param string $separator
     *
     * @return string
     */
    public function toRelativeString($separator = '/');

    /**
     * @param string $separator
     *
     * @return string
     */
    public function toAbsoluteString($separator = '/');

    /**
     * @return bool
     */
    public function isFilePath();

    /**
     * @return bool
     */
    public function isDirectoryPath();
}
