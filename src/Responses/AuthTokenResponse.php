<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseTokenResponse;
use stdClass;

class AuthTokenResponse extends BaseTokenResponse
{
    public $authToken;

    public function __construct(stdClass $response): void
    {
        $this->authToken = $response->authToken;

        parent::__construct($response);
    }
}
