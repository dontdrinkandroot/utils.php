<?php

namespace Dontdrinkandroot\Pagination;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class PaginatedResult
{
    private Pagination $pagination;

    private array $results;

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
