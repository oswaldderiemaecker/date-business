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
        $this->dateBusiness = new DateBusiness();
    }

    public function testDateBusinessExtendsDateTime()
    {
        $this->assertInstanceOf('\DateTime', $this->dateBusiness);
    }

    public function testNewInstanceIsToday()
    {
        $this->assertSame(date('Y-m-d'), $this->dateBusiness->format('Y-m-d'));
    }

    public function testIsValidBusinessDayOnMonday()
    {
        $this->dateBusiness->setDate(2014, 3, 10);
        $this->assertTrue($this->dateBusiness->isBusinessDay());
    }
}
