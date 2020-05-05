<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\BaseResponse;
use stdClass;

class DownloadReportResponse extends BaseResponse
{
    public $report;

    public function __construct(stdClass $response): void
    {
        $this->report = simplexml_load_string($response->reportXML);

        parent::__construct($response);
    }
}
