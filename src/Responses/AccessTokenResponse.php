<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseTokenResponse;
use stdClass;

class AccessTokenResponse extends BaseTokenResponse
{
    public $authToken;

    public function __construct(stdClass $response): void
    {
        $this->accessToken = $response->authToken;

        parent::__construct($response);
    }
}
