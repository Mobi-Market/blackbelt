<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseResponse;
use stdClass;

class DevicePricingAndGradingResponse extends BaseResponse
{
    public $deviceName;
    public $imei;
    public $os;
    public $testAvailable;
    public $gradesAvailable;
    public $pricingData;
    public $pricingVarients;

    public function __construct(stdClass $response)
    {
        $this->deviceName       = $response->deviceName;
        $this->imei             = $response->imei;
        $this->os               = $response->os;
        $this->testAvailable    = explode(',', $response->testAvailable);
        $this->gradesAvailable  = $response->gradesAvailable;
        $this->pricingData      = $response->pricingData;
        $this->pricingVarients  = $response->pricingVarients;

        parent::__construct($response);
    }
}
