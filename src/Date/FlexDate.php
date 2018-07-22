<?php

namespace Dontdrinkandroot\Date;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class FlexDate
{
    const PRECISION_YEAR = 'year';
    const PRECISION_MONTH = 'month';
    const PRECISION_DAY = 'day';
    const PRECISION_NONE = 'none';

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

    public function __construct(?int $year = null, ?int $month = null, ?int $day = null)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(?int $month): void
    {
        $this->month = $month;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(?int $day): void
    {
        $this->day = $day;
    }

    public function hasValue(): bool
    {
        return null !== $this->year || null !== $this->month || null !== $this->day;
    }

    public function isCompleteDate(): bool
    {
        return null !== $this->year && null !== $this->month && null !== $this->day;
    }

    public function isValid(): bool
    {
        try {
            $this->assertValid();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function assertValid(): bool
    {
        if (null !== $this->day && null === $this->month) {
            throw new \Exception('Day set, but no month');
        }

        if (null !== $this->month && null === $this->year) {
            throw new \Exception('Month, but no year');
        }

        return true;
    }

    public function isValidDate(): bool
    {
        return checkdate($this->month, $this->day, $this->year);
    }

    public function toDateTime(): \DateTime
    {
        $dateTime = new \DateTime();
        $inferredYear = $this->year !== null ? $this->year : 0;
        $inferredMonth = $this->month !== null ? $this->month : 1;
        $inferredDay = $this->day !== null ? $this->day : 1;
        $dateTime->setDate($inferredYear, $inferredMonth, $inferredDay);

        return $dateTime;
    }

    public function __toString(): string
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

    public static function fromString(string $dateString): FlexDate
    {
        $flexDate = new FlexDate();
        if (empty($dateString)) {
            return $flexDate;
        }

        $parts = explode('-', $dateString);
        $numParts = count($parts);
        if ($numParts > 0) {
            $flexDate->setYear((int)$parts[0]);
        }
        if ($numParts > 1) {
            $flexDate->setMonth((int)$parts[1]);
        }
        if ($numParts > 2) {
            $flexDate->setDay((int)$parts[2]);
        }

        return $flexDate;
    }

    public function getPrecision(): string
    {
        if (null !== $this->day) {
            return self::PRECISION_DAY;
        }

        if (null !== $this->month) {
            return self::PRECISION_MONTH;
        }

        if (null !== $this->year) {
            return self::PRECISION_YEAR;
        }

        return self::PRECISION_NONE;
    }
}
