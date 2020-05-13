<?php

namespace MobiMarket\BlackBelt\Responses;

use MobiMarket\BlackBelt\Responses\DownloadReportResponse;
use stdClass;

class DownloadPDFReportResponse extends DownloadReportResponse
{
    public $pdfData;

    public function __construct(stdClass $response)
    {
        $this->pdfData = $response->data;
    }
}
