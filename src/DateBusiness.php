<?php

namespace Intl;

use DateInterval;
use DateTime;
use UnexpectedValueException;

class DateBusiness extends DateTime
{
    /**
     * @var array
     */
    private $staticHolidays = array();

    /**
     * @var array
     */
    private $variableHolidays = array();

    /**
     * @return bool
     */
    public function isBusinessDay()
    {
        if ($this->format('N') > 5) {
            return false;
        }

        if ($this->isHoliday()) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isHoliday()
    {
        if (in_array($this->format('m-d'), $this->staticHolidays)) {
            return true;
        }

        if (in_array($this->format('Y-m-d'), $this->variableHolidays)) {
            return true;
        }

        return false;
    }

    /**
     * Adds an amount of business days to a DateBusiness object
     * @param int $days
     * @throws UnexpectedValueException
     * @return DateBusiness
     */
    public function addBusinessDay($days)
    {
        $this->validateDays($days);

        $i = 0;
        $targetDate = clone $this;
        $interval = new DateInterval('P1D');

        while ($i < $days) {
            $targetDate->add($interval);

            if (!$targetDate->isBusinessDay()) {
                ++$days;
            }
            ++$i;
        }

        return $targetDate;
    }

    /**
     * Adds an amount of business days to a DateBusiness object
     * @param int $days
     * @throws UnexpectedValueException
     * @return DateBusiness
     */
    public function subBusinessDays($days)
    {
        $this->validateDays($days);

        $i = 0;
        $targetDate = clone $this;
        $interval = new DateInterval('P1D');

        while ($i < $days) {
            $targetDate->sub($interval);

            if (!$targetDate->isBusinessDay()) {
                ++$days;
            }

            ++$i;
        }

        return $targetDate;
    }

    /**
     * @throws UnexpectedValueException
     * @return DateBusiness
     */
    public function nextBusinessDay()
    {
        return $this->addBusinessDay(1);
    }

    /**
     * @throws UnexpectedValueException
     * @return DateBusiness
     */
    public function previousBusinessDay()
    {
        return $this->subBusinessDays(1);
    }

    /**
     * @param array $variableHolidays
     */
    public function setVariableHolidays(array $variableHolidays)
    {
        $this->variableHolidays = $variableHolidays;
    }

    /**
     * @param array $staticHolidays
     */
    public function setStaticHolidays(array $staticHolidays)
    {
        $this->staticHolidays = $staticHolidays;
    }

    /**
     * @param int $days
     * @throws UnexpectedValueException
     */
    private function validateDays($days)
    {
        if (!is_int($days)) {
            throw new UnexpectedValueException('Parameter "days" must be of type integer.');
        }
    }
}
