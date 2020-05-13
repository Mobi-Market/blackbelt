<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseTokenResponse;
use stdClass;

class AccessTokenResponse extends BaseTokenResponse
{
    public $accessToken;

    public function __construct(stdClass $response)
    {
        $this->accessToken = $response->accessToken;

        parent::__construct($response);
    }
}
