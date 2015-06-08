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

    /**
     * @return bool
     */
    public function hasValue()
    {
        return null !== $this->year || null !== $this->month || null !== $this->day;
    }

    /**
     * @return bool
     */
    public function isCompleteDate()
    {
        return null !== $this->year && null !== $this->month && null !== $this->day;
    }

    /**
     * @return bool
     */
    public function isValidDate()
    {
        return checkdate($this->month, $this->day, $this->year);
    }

    /**
     * @¶eturn \DateTime
     */
    public function toDateTime()
    {
        $dateTime = new \DateTime();
        $inferredYear = $this->year !== null ? $this->year : 0;
        $inferredMonth = $this->month !== null ? $this->month : 1;
        $inferredDay = $this->day !== null ? $this->day : 1;
        $dateTime->setDate($inferredYear, $inferredMonth, $inferredDay);

        return $dateTime;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $string = '';
        if (null !== $this->year) {
            $string .= $this->year;
        }
        if (null !== $this->month) {
            $string .= '-';
            $string .= str_pad($this->month, 2, '0', STR_PAD_LEFT);
        }
        if (null !== $this->day) {
            $string .= '-';
            $string .= str_pad($this->day, 2, '0', STR_PAD_LEFT);
        }

        return $string;
    }
}