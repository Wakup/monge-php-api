<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-18
 * Time: 18:36
 */

namespace Wakup;

use GuzzleHttp\Exception\GuzzleException;

class HttpClient
{

    const ENDPOINT = 'http://ecommerce.wakup.net:9000/';

    /**
     * @var \GuzzleHttp\Client
     */
    var $httpClient;

    /**
     * @var \JsonMapper
     */
    var $jsonMapper;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->httpClient = new \GuzzleHttp\Client();
        $this->jsonMapper = new \JsonMapper();
        $this->jsonMapper->bStrictNullTypes = false;
    }

    /**
     * Obtains the authentication headers for wakup requests
     * @return array Array of headers
     */
    protected function getWakupHeaders() :array
    {
        return ['API-Token' => '66145878-9b0f-415f-ac1b-f10c6306face'];
    }

    /**
     * @param string $path Path for the request. Will be appended to the endpoint
     * @param array $queryParams Query parameters to be included on URL for GET Requests
     * @param array $headers Request headers
     * @param null $responseObject Object to parse JSON result to. Ignored if null
     * @return mixed Returns the obtained JSON object
     * @throws WakupException
     */
    protected function launchGetRequest(string $path, array $queryParams, array $headers, $responseObject = null)
    {
        return $this->launchRequest('GET', $path, $queryParams,  $headers, '', $responseObject);
    }

    /**
     * @param string $method HTTP request method (GET, POST, PUT, DELETE)
     * @param string $path Path for the request. Will be appended to the endpoint
     * @param array $queryParams Query parameters to be included on URL for GET Requests
     * @param array $headers Request headers
     * @param string $body Request body
     * @param null $responseObject Object to parse JSON result to. Ignored if null
     * @return mixed Returns the obtained JSON object
     * @throws WakupException
     */
    private function launchRequest(string $method, string $path, array $queryParams, array $headers, string $body, $responseObject = null)
    {
        try {
            $response = $this->httpClient->request($method, self::ENDPOINT . $path,
                ['query' => $queryParams, 'body' => $body, 'headers' => $headers]);
            $obj = json_decode($response->getBody());
            $this->jsonMapper->map($obj, $responseObject);
            return $obj;
        } catch (\JsonMapper_Exception $e) {
            throw new WakupException($e->getMessage());
        } catch (GuzzleException $e) {
            throw new WakupException($e->getMessage());
        }
    }

}