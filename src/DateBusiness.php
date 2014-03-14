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
        return true;
    }
}
