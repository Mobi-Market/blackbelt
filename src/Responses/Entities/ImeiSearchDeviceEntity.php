<?php

namespace MobiMarket\BlackBelt\Responses\Entities;

use stdClass;
use MobiMarket\BlackBelt\Responses\Entities\ImeiSearchDeviceReportEntity;

class ImeiSearchDeviceEntity
{
    public $id;
    public $imei;
    public $serialNumber;
    public $reports;

    public function __construct(stdClass $data)
    {
        $this->id           = $data->id;
        $this->imei         = $data->imei;
        $this->serialNumber = $data->serialNumber;
        $this->reports      = [];

        foreach ($data->report as $r) {
            $this->reports[] = new ImeiSearchDeviceReportEntity($r);
        }
    }
}
