<?php

declare(strict_types=1);

namespace MobiMarket\BlackBelt;

use Illuminate\Support\Facades\Facade;

/**
 * @method object getClient()
 * @method object setAuthorisationHeader(string $grantType, string $token)
 * @method object clearAuthorisationHeader()
 * @method object makePostRequest(string $endpoint, BaseRequest $request, bool $dontRefresh = false)
 * @method object getAuthToken(AuthTokenRequest $request)
 * @method object getAccessToken(AccessTokenRequest $request)
 * @method object authenticate()
 * @method object downloadReport(DownloadReportRequest $request)
 * @method object imeiSearch(ImeiSearchRequest $request)
 * @method object checkUser(CheckUserRequest $request)
 * @method object getDevicePricingAndGrading(DevicePricingAndGradingRequest $request)
 */
class BlackBeltFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BlackBelt::class;
    }
}
