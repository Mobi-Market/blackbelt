<?php

namespace MobiMarket\BlackBelt\Requests;

class BaseRequest
{
    public $deviceID;

    public function setDeviceId(string $deviceId): void
    {
        $this->deviceID = $deviceId;
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
