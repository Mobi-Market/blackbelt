<?php

namespace MobiMarket\BlackBelt\Responses\Entity;

use stdClass;
use MobiMarket\BlackBelt\Responses\Entity\ImeiSearchDeviceReportEntity;

class ImeiSearchDeviceEntity
{
    public $id;
    public $imei;
    public $serialNumber;
    public $reports;

    public function __construct(stdClass $data): void
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
