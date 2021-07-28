<?php

namespace MobiMarket\BlackBelt;

use GuzzleHttp\Client;
use MobiMarket\BlackBelt\Exceptions\ApiException;
use MobiMarket\BlackBelt\Requests\AccessTokenRequest;
use MobiMarket\BlackBelt\Requests\AuthTokenRequest;
use MobiMarket\BlackBelt\Requests\BaseRequest;
use MobiMarket\BlackBelt\Requests\DownloadReportRequest;
use MobiMarket\BlackBelt\Responses\AccessTokenResponse;
use MobiMarket\BlackBelt\Responses\AuthTokenResponse;
use Psr\Http\Message\ResponseInterface;
use stdClass;
use Illuminate\Support\Facades\Cache;
use MobiMarket\BlackBelt\Requests\CheckUserRequest;
use MobiMarket\BlackBelt\Requests\DevicePricingAndGradingRequest;
use MobiMarket\BlackBelt\Requests\ImeiSearchRequest;
use MobiMarket\BlackBelt\Responses\CheckUserResponse;
use MobiMarket\BlackBelt\Responses\DevicePricingAndGradingResponse;
use MobiMarket\BlackBelt\Responses\ImeiSearchResponse;
use MobiMarket\BlackBelt\Responses\DownloadPDFReportResponse;
use MobiMarket\BlackBelt\Responses\DownloadXMLReportResponse;

class BlackBelt
{
    /**
     * URL and enpoints for API
     */
    public const BASE_URL                  = 'https://api.blackbeltdefence.com';
    public const ENDPOINT_AUTH_TOKEN       =  'api/v1/auth-token';
    public const ENDPOINT_ACCESS_TOKEN     =  'api/v1/access-token';
    public const ENDPOINT_UPLOAD_REPORT    =  'api/v1/upload-report';
    public const ENDPOINT_DOWNLOAD_REPORT  =  'api/v1/download-report';
    public const ENDPOINT_CHECK_USER       =  'api/v1/check-user';
    public const ENDPOINT_GET_IMEI         =  'api/v1/get-imei';
    public const ENDPOINT_GET_PRICE        =  'api/v2/get-price';

    public const CACHE_KEY                 = 'BB_ACCESS_TOKEN';

    private $clientKey;
    private $clientSecret;
    private $authenticated = false;

    private $accessTokenCache;
    private $sessionKey;
    private $guzzleClient;

    private $options = [
        'base_uri'  => self::BASE_URL,
        'timeout'   => 10.0,
    ];

    private $headers =  [
        'Content-Type'  => 'application/json',
        'Accept'        => 'application/json',
    ];

    public function __construct(string $clientKey, string $clientSecret, float $timeout)
    {
        $this->clientKey            = $clientKey;
        $this->clientSecret         = $clientSecret;
        $this->options['timeout']   = $timeout;
        $this->accessTokenCache     = $this->getCachedAccessToken();
        $this->sessionKey           = md5(time());
    }

    /**
     * returns a guzzle client. if one is not setup it creates a new one
     */
    public function getClient(): Client
    {
        if (null === $this->guzzleClient) {
            $this->guzzleClient = null;
            $this->guzzleClient = new Client($this->options);
        }

        return $this->guzzleClient;
    }
    /**
     * Sets the authorisation header for the request
     */
    public function setAuthorisationHeader(string $grantType, string $token): void
    {
        $this->headers['Authorization'] = "{$grantType} {$token}";
    }
    /**
     * removes the authorisation header from the Guzzle Client options
     */
    public function clearAuthorisationHeader(): void
    {
        if (true === isset($this->headers['Authorization'])) {
            unset($this->headers['Authorization']);
        }
    }
    /**
     * makes a post request to the given endpoint
     *
     * @return stdClass|GuzzleHttp\Psr7\Response
     */
    public function makePostRequest(
        string $endpoint,
        BaseRequest $request,
        bool $dontRefresh = false,
        bool $returnRaw = false
    ) {
        // check cache TTL
        if (false === $dontRefresh) {
            if (true === $this->checkCacheExpired()) {
                $this->authenticated = false;
            }

            if (false === $this->authenticated) {
                $this->authenticate();
            }
        }

        $request->setDeviceId($this->sessionKey);
        $response = $this->getClient()->post($endpoint, [
            'json'          => ['request' => $request->toArray()],
            'headers'       => $this->headers,
        ]);

        if (true === $returnRaw) {
            return $response;
        }

        $decodedResponse = json_decode($response->getBody());
        $decodedResponse = $decodedResponse->response;

        if (
            in_array($decodedResponse->code, [204, 208])
            && false === $dontRefresh
        ) {
            // bad token retry
            $this->authenticated = false;
            return $this->makePostRequest($endpoint, $request, true);
        }

        if (200 > $decodedResponse->code) {
            throw new ApiException("{$decodedResponse->status}: {$decodedResponse->description}", $decodedResponse->code);
        }

        return $decodedResponse;
    }
    /**
     * gets a token from BlackBelt API
     */
    public function getAuthToken(AuthTokenRequest $request): AuthTokenResponse
    {
        $response = $this->makePostRequest(static::ENDPOINT_AUTH_TOKEN, $request, true);

        return new AuthTokenResponse($response);
    }
    /**
     * fetch an access token from the API
     */
    public function getAccessToken(AccessTokenRequest $request): AccessTokenResponse
    {
        $response = $this->makePostRequest(static::ENDPOINT_ACCESS_TOKEN, $request, true);

        return new AccessTokenResponse($response);
    }
    /**
     * Performs authorisation logic
     */
    public function authenticate(): void
    {
        // clear any previous authorisation headers
        $this->clearAuthorisationHeader();
        // build new AuthRequest and get initial AuthResponse
        $authRequest = new AuthTokenRequest($this->clientKey, $this->clientSecret);
        $authResponse = $this->getAuthToken($authRequest);
        // set authorisation header with auth Token
        $this->setAuthorisationHeader($authResponse->grantType, $authResponse->authToken);
        // get Access Token and cache it
        $accessRequest = new AccessTokenRequest($this->sessionKey);
        $accessResponse = $this->getAccessToken($accessRequest);

        // set authorisation header with access token
        $this->setAuthorisationHeader($accessResponse->grantType, $accessResponse->accessToken);
        $this->saveTokenCache($accessResponse, 60 * 59);
    }
    /**
     * save accessTokenResponse for $TTL
     */
    public function saveTokenCache(AccessTokenResponse $response, int $ttl): void
    {
        $this->authenticated = true;
        $this->accessTokenCache = $response;
        Cache::put(static::CACHE_KEY, $this->accessTokenCache, $ttl);
    }
    /**
     * check if the cached AccessTokenResponse has expired
     */
    public function checkCacheExpired(): bool
    {
        if (null === $this->accessTokenCache) {
            return true;
        }

        return false;
    }
    /**
     * gets the access token from the cache implementation
     */
    public function getCachedAccessToken(): ?AccessTokenResponse
    {
        return Cache::get(static::CACHE_KEY);
    }
    /**
     * makes a xml report download request.
     * @throws ApiException
     */
    public function downloadXMLReport(DownloadReportRequest $request): DownloadXMLReportResponse
    {
        $request->setReportFormat(DownloadReportRequest::FORMAT_XML);
        $response = $this->makePostRequest(static::ENDPOINT_DOWNLOAD_REPORT, $request);
        return new DownloadXMLReportResponse($response);
    }
    /**
     * makes a pdf report download request.
     * @throws ApiException
     */
    public function downloadPDFReport(DownloadReportRequest $request): DownloadPDFReportResponse
    {
        $request->setReportFormat(DownloadReportRequest::FORMAT_PDF);

        /**
         * @var \GuzzleHttp\Psr7\Response
         */
        $response = $this->makePostRequest(static::ENDPOINT_DOWNLOAD_REPORT, $request, false, true);

        $r = new stdClass();
        $r->data = $response->getBody()->getContents();
        return new DownloadPDFReportResponse($r);
    }
    /**
     * checks for an IMEI
     * @throws ApiException
     */
    public function imeiSearch(ImeiSearchRequest $request): ImeiSearchResponse
    {
        $response = $this->makePostRequest(static::ENDPOINT_GET_IMEI, $request);

        return new ImeiSearchResponse($response);
    }
    /**
     * checks a user is valid in BlackBelt
     * @throws ApiException
     */
    public function checkUser(CheckUserRequest $request): CheckUserResponse
    {
        $response = $this->makePostRequest(static::ENDPOINT_CHECK_USER, $request);

        return new CheckUserResponse($response);
    }

    public function getDevicePricingAndGrading(DevicePricingAndGradingRequest $request): DevicePricingAndGradingResponse
    {
        $response = $this->makePostRequest(static::ENDPOINT_GET_PRICE, $request);

        return new DevicePricingAndGradingResponse($response);
    }
}
