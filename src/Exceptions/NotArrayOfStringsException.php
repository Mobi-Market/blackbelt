<?php

/*
 * This file is part of Lifeboat.
 * (c) Mobi-Market <info@mobi-market.co.uk>
 * This source file is proprietary and no license is given for its use outside
 * Mobi-Market.
 */

namespace MobiMarket\BlackBelt\Exceptions;

use MobiMarket\BlackBelt\Exceptions\BaseBlackBeltException;

class NotArrayOfStringsException extends BaseBlackBeltException
{
    public function __construct(string $message)
    {
        // make sure everything is assigned properly
        parent::__construct($message, 8802);
    }
}
