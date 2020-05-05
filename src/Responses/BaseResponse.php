<?php

namespace MobiMarket\BlackBelt\Responses;

use stdClass;

class BaseResponse
{
    public $transactionId;
    public $code;
    public $status;
    public $description;

    public function __construct(stdClass $response): void
    {
        $this->transactionId = $response->transactionID;
        $this->code = $response->code;
        $this->status = $response->status;
        $this->description = $response->description;
    }
}
