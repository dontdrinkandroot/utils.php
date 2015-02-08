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
     * @deprecated
     * @return string
     */
    public function toAbsoluteUrlString();

    /**
     * @deprecated
     * @return string
     */
    public function toRelativeUrlString();

    /**
     * @deprecated
     * @return string
     */
    public function toAbsoluteFileString();

    /**
     * @deprecated
     * @return string
     */
    public function toRelativeFileString();

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
