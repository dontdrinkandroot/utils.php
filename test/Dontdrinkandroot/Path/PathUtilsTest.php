<?php


namespace Dontdrinkandroot\Path;

class PathUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testDiff()
    {
        $this->assertEquals('', PathUtils::getPathDiff(new DirectoryPath(), new DirectoryPath()));
        $this->assertEquals(
            '../d/',
            PathUtils::getPathDiff(DirectoryPath::parse('a/b/c/'), DirectoryPath::parse('a/b/d/'))
        );
        $this->assertEquals(
            '../../../d/e/f/',
            PathUtils::getPathDiff(DirectoryPath::parse('a/b/c/'), DirectoryPath::parse('d/e/f/'))
        );
        $this->assertEquals('../', PathUtils::getPathDiff(new DirectoryPath('test'), new DirectoryPath()));
        $this->assertEquals('test/', PathUtils::getPathDiff(new DirectoryPath(), new DirectoryPath('test')));
        $this->assertEquals('../b/', PathUtils::getPathDiff(new DirectoryPath('a'), new DirectoryPath('b')));
        $this->assertEquals('', PathUtils::getPathDiff(new FilePath('a.txt'), new DirectoryPath()));
        $this->assertEquals('a.txt', PathUtils::getPathDiff(new DirectoryPath(), new FilePath('a.txt')));
        $this->assertEquals('b.txt', PathUtils::getPathDiff(new FilePath('a.txt'), new FilePath('b.txt')));
        $this->assertEquals('c/b.txt', PathUtils::getPathDiff(new FilePath('a.txt'), FilePath::parse('c/b.txt')));
        $this->assertEquals('../b.txt', PathUtils::getPathDiff(FilePath::parse('c/a.txt'), new FilePath('b.txt')));
    }
}
