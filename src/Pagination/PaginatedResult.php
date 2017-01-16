<?php

namespace Dontdrinkandroot\Pagination;

class PaginatedResult
{
    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var array
     */
    private $results;

    public function __construct(Pagination $pagination, array $results)
    {
        $this->pagination = $pagination;
        $this->results = $results;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function getResults(): array
    {
        return $this->results;
    }
}
