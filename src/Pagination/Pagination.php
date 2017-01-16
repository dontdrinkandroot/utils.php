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

    public function __construct(int $currentPage, int $perPage, int $total)
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

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getTotalPages(): int
    {
        if ($this->total == 0) {
            return 0;
        }

        return (int)(($this->total - 1) / $this->perPage + 1);
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
