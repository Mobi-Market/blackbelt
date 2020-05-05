<?php

namespace MobiMarket\BlackBelt\Requests;

use MobiMarket\BlackBelt\Exceptions\InvalidReportTypeException;
use MobiMarket\BlackBelt\Requests\BaseRequest;

class AuthTokenRequest extends BaseRequest
{
    public $clientKey;
    public $clientSecret;

    public function __construct(string $deviceId, string $clientKey, string $clientSecret): void
    {
        $this->clientKey = $clientKey;
        $this->clientSecret = $clientSecret;

        parent::__construct($deviceId);
    }
}
