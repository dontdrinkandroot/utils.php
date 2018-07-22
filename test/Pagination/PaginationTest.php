<?php

namespace Dontdrinkandroot\Pagination;

use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testInvalid()
    {
        try {
            new Pagination(-1, 0, 0);
            $this->fail("Exception expected");
        } catch (\InvalidArgumentException $e) {
            /* Expected */
        }

        try {
            new Pagination(1, 0, 0);
            $this->fail("Exception expected");
        } catch (\InvalidArgumentException $e) {
            /* Expected */
        }

        try {
            new Pagination(1, 1, -1);
            $this->fail("Exception expected");
        } catch (\InvalidArgumentException $e) {
            /* Expected */
        }
    }

    public function testGetTotalPages()
    {
        $pagination = new Pagination(1, 1, 0);
        $this->assertEquals(0, $pagination->getTotalPages());

        $pagination = new Pagination(1, 1, 1);
        $this->assertEquals(1, $pagination->getTotalPages());

        $pagination = new Pagination(1, 1, 2);
        $this->assertEquals(2, $pagination->getTotalPages());

        $pagination = new Pagination(1, 2, 2);
        $this->assertEquals(1, $pagination->getTotalPages());
    }

    public function testGetCurrentPage()
    {
        $pagination = new Pagination(1, 2, 3);
        $this->assertEquals(1, $pagination->getCurrentPage());

        $pagination = new Pagination(42, 2, 3);
        $this->assertEquals(42, $pagination->getCurrentPage());
    }

    public function testGetTotal()
    {
        $pagination = new Pagination(1, 2, 42);
        $this->assertEquals(42, $pagination->getTotal());
    }
}
