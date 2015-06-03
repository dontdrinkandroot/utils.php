<?php

namespace Dontdrinkandroot\Date;

class FlexDateTest extends \PHPUnit_Framework_TestCase
{

    public function testValidDate()
    {
        $flexDate = new FlexDate();
        $this->assertFalse($flexDate->isValidDate());

        $flexDate = new FlexDate(2015, 1, 3);
        $this->assertTrue($flexDate->isValidDate());

        $flexDate = new FlexDate(2015, 2, 30);
        $this->assertFalse($flexDate->isValidDate());
    }

    public function testHasValue()
    {
        $flexDate = new FlexDate();
        $this->assertFalse($flexDate->hasValue());

        $flexDate->setYear(2015);
        $this->assertTrue($flexDate->hasValue());
    }

    public function testIsCompleteDate()
    {
        $flexDate = new FlexDate();
        $this->assertFalse($flexDate->isCompleteDate());

        $flexDate->setYear(2015);
        $this->assertFalse($flexDate->isCompleteDate());

        $flexDate->setMonth(3);
        $this->assertFalse($flexDate->isCompleteDate());

        $flexDate->setDay(3);
        $this->assertTrue($flexDate->isCompleteDate());
    }

    public function testToString()
    {
        $flexDate = new FlexDate();
        $this->assertEquals('', $flexDate->__toString());

        $flexDate->setYear(2015);
        $this->assertEquals('2015', $flexDate->__toString());

        $flexDate->setMonth(3);
        $this->assertEquals('2015-03', $flexDate->__toString());

        $flexDate->setDay(3);
        $this->assertEquals('2015-03-03', $flexDate->__toString());
    }

    public function testToDateTime()
    {
        $flexDate = new FlexDate();
        $dateTime = $flexDate->toDateTime();
        $this->assertEquals('00000101', $dateTime->format('Ymd'));

        $flexDate->setYear(2015);
        $dateTime = $flexDate->toDateTime();
        $this->assertEquals('20150101', $dateTime->format('Ymd'));

        $flexDate->setMonth(3);
        $dateTime = $flexDate->toDateTime();
        $this->assertEquals('20150301', $dateTime->format('Ymd'));

        $flexDate->setDay(3);
        $dateTime = $flexDate->toDateTime();
        $this->assertEquals('20150303', $dateTime->format('Ymd'));
    }
}
