<?php


namespace Net\Dontdrinkandroot\Utils\Path;


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
     * @return Path
     */
    function prepend(DirectoryPath $path);

    /**
     * @return Path[]
     */
    function collectPaths();

    /**
     * @return string
     */
    function toAbsoluteUrlString();

    /**
     * @return string
     */
    function toRelativeUrlString();

    /**
     * @return string
     */
    function toAbsoluteFileString();

    /**
     * @return string
     */
    function toRelativeFileString();

    /**
     * @return bool
     */
    function isFilePath();

    /**
     * @return bool
     */
    function isDirectoryPath();

} 