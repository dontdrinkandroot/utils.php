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

    /**
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }


}