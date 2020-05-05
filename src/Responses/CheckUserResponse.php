<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseResponse;
use stdClass;

class CheckUserResponse extends BaseResponse
{
    public $userStatus;

    public function __construct(stdClass $response): void
    {
        $this->userStatus = $response->userStatus;

        parent::__construct($response);
    }
}
