<?php


namespace Dontdrinkandroot\Pagination;

class Pagination
{

    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $total;

    /**
     * @param int $currentPage
     * @param int $perPage
     * @param int $total
     */
    public function __construct($currentPage, $perPage, $total)
    {
        if ($currentPage < 1) {
            throw new \InvalidArgumentException('CurrentPage must be greater than 0');
        }

        if ($perPage < 1) {
            throw new \InvalidArgumentException('PerPage mustbe greater than 0');
        }

        if ($total < 0) {
            throw new \InvalidArgumentException('Total must be greater equals 0');
        }

        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getTotalPages()
    {
        if ($this->total == 0) {
            return 0;
        }

        return (int)(($this->total - 1) / $this->perPage + 1);
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }
}
