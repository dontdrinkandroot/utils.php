<?php


namespace Dontdrinkandroot\Path;

interface Path
{

    /**
     * @return string
     */
    function getName();

    /**
     * @return bool
     */
    function hasParentPath();

    /**
     * @return DirectoryPath
     */
    function getParentPath();

    /**
     * @param DirectoryPath $path
     *
     * @return Path
     */
    function prepend(DirectoryPath $path);

    /**
     * @return Path[]
     */
    function collectPaths();

    /**
     * @deprecated
     * @return string
     */
    function toAbsoluteUrlString();

    /**
     * @deprecated
     * @return string
     */
    function toRelativeUrlString();

    /**
     * @deprecated
     * @return string
     */
    function toAbsoluteFileString();

    /**
     * @deprecated
     * @return string
     */
    function toRelativeFileString();

    /**
     * @param string $separator
     *
     * @return string
     */
    function toRelativeString($separator = '/');

    /**
     * @param string $separator
     *
     * @return string
     */
    function toAbsoluteString($separator = '/');

    /**
     * @return bool
     */
    function isFilePath();

    /**
     * @return bool
     */
    function isDirectoryPath();
}