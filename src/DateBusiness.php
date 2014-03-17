<?php

namespace Intl;

use DateTime;

class DateBusiness extends DateTime
{
    /**
     * @return bool
     */
    public function isBusinessDay()
    {
        if ($this->format('N') < 6) {
            return true;
        }

        return false;
    }
}
