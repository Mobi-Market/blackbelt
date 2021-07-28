<?php

namespace MobiMarket\BlackBelt\Responses\Entities;

use stdClass;
use Illuminate\Support\Carbon;

class ImeiSearchDeviceReportEntity
{
    public $id;
    public $date;
    public $status;
    public $userName;

    public function __construct(stdClass $data)
    {
        $this->id           = $data->id;
        $this->imei         = Carbon::parse($data->date);
        $this->status       = $data->status;
        $this->userName     = $data->userName;
    }
}
