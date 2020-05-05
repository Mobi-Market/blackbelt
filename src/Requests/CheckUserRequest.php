<?php

namespace MobiMarket\BlackBelt\Requests;

use MobiMarket\BlackBelt\Requests\BaseRequest;

class CheckUserRequest extends BaseRequest
{
    public $userName;

    public function setUserName(string $username): void
    {
        $this->userName = $username;
    }
}
