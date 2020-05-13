<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseResponse;
use MobiMarket\BlackBelt\Responses\Entity\ImeiSearchDeviceEntity;
use stdClass;

class ImeiSearchResponse extends BaseResponse
{
    public $devices = [];

    public function __construct(stdClass $response)
    {
        $this->report = simplexml_load_string($response->reportXML);
        foreach ($this->report->devices->device as $device) {
            $this->devices[] = new ImeiSearchDeviceEntity($device);
        }
        parent::__construct($response);
    }
}
