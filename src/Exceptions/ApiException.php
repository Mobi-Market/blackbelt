<?php

namespace MobiMarket\BlackBelt\Exceptions;

use Exception;
use MobiMarket\BlackBelt\Exceptions\BaseBlackBeltException;

class ApiException extends BaseBlackBeltException
{
    public function __construct(string $message, int $code = 8802)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code);
    }
}
