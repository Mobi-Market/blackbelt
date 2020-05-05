<?php

namespace MobiMarket\BlackBelt\Requests;

use Illuminate\Support\Carbon;
use MobiMarket\BlackBelt\Exceptions\InvalidReportTypeException;
use MobiMarket\BlackBelt\Exceptions\NotArrayOfStringsException;
use MobiMarket\BlackBelt\Requests\BaseRequest;

class ImeiSearchRequest extends BaseRequest
{
    public $reportType;
    public $dateFrom;
    public $dateTo;
    public $imei;
    public $multiSite = false;
    public $customField;

    private $validReportsTypes = [
        'datawipe',
        'analyst',
        'OTA-analyst',
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

    public function setImei(string $imei): void
    {
        $this->imei = $imei;
    }

    public function setDateFrom(Carbon $date, string $carbonFormat = 'toDateString'): void
    {
        $this->dateFrom = $date->{$carbonFormat}();
    }

    public function setDateTo(Carbon $date, string $carbonFormat = 'toDateString'): void
    {
        $this->dateTo = $date->{$carbonFormat}();
    }

    public function setMultiSite(bool $multiSite = false): void
    {
        $this->multiSite = $multiSite;
    }
    /**
     * custom fields - must be key value pairs of strings. key being field to search and value being value to search for in field
     */
    public function setCustomField(array $fields): void
    {
        foreach ($fields as $key => $value) {
            if (!is_string($key) || !is_string($value)) {
                throw new NotArrayOfStringsException("Array index '{$key}:{$value}' is not a string");
            }
        }

        $this->customField = $fields;
    }
}
