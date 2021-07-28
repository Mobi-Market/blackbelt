<?php

namespace MobiMarket\BlackBelt\Requests;

use MobiMarket\BlackBelt\Exceptions\InvalidReportTypeException;
use MobiMarket\BlackBelt\Requests\BaseRequest;

class DownloadReportRequest extends BaseRequest
{
    public const TYPE_DATAWIPE = 'datawipe';
    public const TYPE_ANALYST  = 'analyst';
    public const TYPE_OTA      = 'OTA-analyst';
    public const FORMAT_PDF    = 'pdf';
    public const FORMAT_XML    = 'xml';

    public $reportType;
    public $reportFormat;
    public $imei;
    public $serialNumber;
    public $reportId;

    /**
     * @throws InvalidReportTypeException
     */
    public function setReportType(string $reportType): void
    {
        if (!in_array($reportType, [static::TYPE_ANALYST, static::TYPE_DATAWIPE, static::TYPE_OTA])) {
            throw new InvalidReportTypeException("Report `{$reportType}` is not a valid report type.");
        }

        $this->reportType = $reportType;
    }
    /**
     * @throws InvalidReportTypeException
     */
    public function setReportFormat(string $reportFormat): void
    {
        if (!in_array($reportFormat, [static::FORMAT_PDF, static::FORMAT_XML])) {
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
