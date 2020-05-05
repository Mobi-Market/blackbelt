<?php

namespace MobiMarket\BlackBelt\Responses\Entity;

use stdClass;
use Illuminate\Support\Carbon;

class ImeiSearchDeviceReportEntity
{
    public $id;
    public $date;
    public $status;
    public $userName;

    public function __construct(stdClass $data): void
    {
        $this->id           = $data->id;
        $this->imei         = Carbon::parse($data->date);
        $this->status       = $data->status;
        $this->userName     = $data->userName;
    }
}
