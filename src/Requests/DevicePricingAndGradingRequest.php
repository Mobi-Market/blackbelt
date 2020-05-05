<?php

namespace MobiMarket\BlackBelt\Requests;

use MobiMarket\BlackBelt\Requests\BaseRequest;

class DevicePricingAndGradingRequest extends BaseRequest
{
    public $imei;
    public $os;
    public $productType;
    public $manufacturer;
    public $model;
    public $modelNumber;

    public function setImei(string $imei): void
    {
        $this->imei = $imei;
    }

    public function setOs(string $os): void
    {
        $this->os = $os;
    }

    public function setProductType(string $productType): void
    {
        $this->productType = $productType;
    }

    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function setModelNumber(string $modelNumber): void
    {
        $this->modelNumber = $modelNumber;
    }
}
