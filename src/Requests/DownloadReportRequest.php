<?php

namespace MobiMarket\BlackBelt\Requests;

use MobiMarket\BlackBelt\Exceptions\InvalidReportTypeException;
use MobiMarket\BlackBelt\Requests\BaseRequest;

class DownloadReportRequest extends BaseRequest
{
    public $reportType;
    public $reportFormat;
    public $imei;
    public $serialNumber;
    public $reportId;

    private $validReportsTypes = [
        'datawipe',
        'analyst',
        'OTA-analyst',
    ];

    private $validReportsFormats = [
        'pdf',
        'xml',
    ];
    /**
     * @throws InvalidReportTypeException 
     */
    public function setReportType(string $reportType): void
    {
        if (!in_array($reportType, $this->validReportsTypes)) {
            throw new InvalidReportTypeException("Report `{$reportType}` is not a valid report type.");
        }

        $this->reportType = $reportType;
    }
    /**
     * @throws InvalidReportTypeException 
     */
    public function setReportFormat(string $reportFormat = 'xml'): void
    {
        if (!in_array($reportFormat, $this->validReportsFormats)) {
            throw new InvalidReportTypeException("Report Format `{$reportFormat}` is not a valid report format.");
        }

        $this->reportFormat = $reportFormat;
    }

    public function setImei(string $imei): void
    {
        $this->imei = $imei;
    }

    public function setSerialNumber(string $serialNumber): void
    {
        $this->serialNumber = $serialNumber;
    }

    public function setReportId(string $reportId): void
    {
        $this->reportId = $reportId;
    }
}
