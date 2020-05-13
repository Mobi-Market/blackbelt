<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseResponse;
use stdClass;

class DownloadReportResponse extends BaseResponse
{
    public $report;

    public function __construct(stdClass $response)
    {
        if (isset($response->report)) {
            $this->report = simplexml_load_string($response->report);
        }

        parent::__construct($response);
    }
}
