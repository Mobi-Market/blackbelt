<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseResponse;
use stdClass;

class BaseTokenResponse extends BaseResponse
{
    public $grantType;
    public $TTL;
    public $baseURL;

    public function __construct(stdClass $response)
    {
        $this->grantType = $response->grantType;
        $this->TTL = $response->TTL;
        $this->baseURL = $response->baseURL;

        parent::__construct($response);
    }
}
