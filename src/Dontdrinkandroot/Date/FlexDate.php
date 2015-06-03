<?php


namespace Dontdrinkandroot\Date;

class FlexDate
{

    /**
     * @var int|null
     */
    protected $year;

    /**
     * @var int|null
     */
    protected $month;

    /**
     * @var int|null
     */
    protected $day;

    /**
     * @param int|null $year
     * @param int|null $month
     * @param int|null $day
     */
    public function __construct($year = null, $month = null, $day = null)
    {

        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * @return int|null
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int|null
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int|null $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return int|null
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int|null $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }
}
