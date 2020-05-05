<?php

namespace MobiMarket\BlackBelt\Exceptions;

use MobiMarket\BlackBelt\Exceptions\BaseBlackBeltException;

class InvalidReportTypeException extends BaseBlackBeltException
{
    public function __construct(string $message)
    {
        // make sure everything is assigned properly
        parent::__construct($message, 8801);
    }
}
