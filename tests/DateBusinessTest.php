<?php

namespace Intl;

class DateBusinessTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateBusiness
     */
    protected $dateBusiness;

    public function setUp()
    {
        error_reporting(-1);
        $this->dateBusiness = new DateBusiness();
        $this->dateBusiness->setStaticHolidays(array(
            '01-01',
            '05-01',
            '12-25',
            '12-26',
        ));
        $this->dateBusiness->setVariableHolidays(array(
            '2014-04-18',
            '2014-04-20',
            '2014-04-21',
        ));
    }

    public function testDateBusinessExtendsDateTime()
    {
        $this->assertInstanceOf('\DateTime', $this->dateBusiness);
    }

    public function testNewInstanceIsToday()
    {
        $this->assertSame(date('Y-m-d'), $this->dateBusiness->format('Y-m-d'));
    }

    public function testIsBusinessDayReturnsTrueOnMonday()
    {
        $this->dateBusiness->setDate(2014, 3, 10);
        $this->assertTrue($this->dateBusiness->isBusinessDay());
    }

    public function testIsBusinessDayReturnsFalseOnSaturday()
    {
        $this->dateBusiness->setDate(2014, 3, 15);
        $this->assertFalse($this->dateBusiness->isBusinessDay());
    }

    public function testIsBusinessDayReturnsFalseOnTargetHoliday()
    {
        $this->dateBusiness->setDate(2014, 1, 1); // Wednesday
        $this->assertFalse($this->dateBusiness->isBusinessDay());
    }

    public function testIsHolidayReturnsTrueOnNewYear()
    {
        $this->dateBusiness->setDate(2014, 1, 1);
        $this->assertTrue($this->dateBusiness->isHoliday());
    }

    public function testIsHolidayReturnsFalseOnTheDayAfterNewYear()
    {
        $this->dateBusiness->setDate(2014, 1, 2);
        $this->assertFalse($this->dateBusiness->isHoliday());
    }

    public function testIsHolidayReturnsTrueOnVariableHoliday()
    {
        $this->dateBusiness->setDate(2014, 4, 18);
        $this->assertTrue($this->dateBusiness->isHoliday());
    }

    public function testAddOneDayReturnsNextBusinessDay()
    {
        $this->dateBusiness->setDate(2014, 1, 2);
        $targetDate = $this->dateBusiness->addBusinessDay(1);

        $this->assertSame('2014-01-03', $targetDate->format('Y-m-d'));
    }

    public function testAddWorksOverEasternHolidays()
    {
        $this->dateBusiness->setDate(2014, 4, 18);
        $targetDate = $this->dateBusiness->addBusinessDay(2);

        $this->assertSame('2014-04-23', $targetDate->format('Y-m-d'));
    }

    public function testNextAddsOneBusinessDay()
    {
        $this->dateBusiness->setDate(2014, 4, 17);
        $targetDate = $this->dateBusiness->nextBusinessDay();

        $this->assertSame('2014-04-22', $targetDate->format('Y-m-d'));
    }

    public function testSubOneDayReturnsPreviousBusinessDay()
    {
        $this->dateBusiness->setDate(2014, 1, 3);
        $targetDate = $this->dateBusiness->subBusinessDays(1);

        $this->assertSame('2014-01-02', $targetDate->format('Y-m-d'));
    }

    public function testSubWorksOverEasternHolidays()
    {
        $this->dateBusiness->setDate(2014, 4, 23);
        $targetDate = $this->dateBusiness->subBusinessDays(2);

        $this->assertSame('2014-04-17', $targetDate->format('Y-m-d'));
    }

    public function testPrevSubstractsOneBusinessDay()
    {
        $this->dateBusiness->setDate(2014, 4, 22);
        $targetDate = $this->dateBusiness->previousBusinessDay();

        $this->assertSame('2014-04-17', $targetDate->format('Y-m-d'));
    }
}
