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

    const WAKUP_ENDPOINT = 'http://ecommerce.wakup.net:9000/';
    const MONGE_ENDPOINT = 'http://ecommerce.grupomonge-ti.com:{$port}/api/v1.0/';


    /**
     * @var \GuzzleHttp\Client
     */
    var $wakupClient;

    /**
     * @var \GuzzleHttp\Client
     */
    var $mongeClient;

    /**
     * @var \JsonMapper
     */
    var $jsonMapper;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->wakupClient = new \GuzzleHttp\Client();
        $this->mongeClient = new \GuzzleHttp\Client();
        $this->jsonMapper = new \JsonMapper();
        $this->jsonMapper->bStrictNullTypes = false;
    }

    /**
     * Obtains the authentication headers for wakup requests
     * @return array Array of headers
     */
    protected function getWakupHeaders() : array
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
        return $this->launchRequest('GET', $path, $queryParams, $headers, '', $responseObject);
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
            $response = $this->wakupClient->request($method, self::WAKUP_ENDPOINT . $path,
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

    /**
     * @return mixed Returns the obtained JSON object
     * @throws WakupException
     */
    protected function launchMongeRequest(int $port, string $path, array $jsonBody, $responseObject = null)
    {
        try {
            $body = json_encode($jsonBody);
            $url = strtr(self::MONGE_ENDPOINT, array('{$port}' => $port)).$path;
            $response = $this->wakupClient->request('POST', $url,
                ['Content-Type' => 'application-json', 'body' => $body]);
            $responseWrapper = json_decode($response->getBody());
            $obj = $responseWrapper['response'];
            $this->jsonMapper->map($obj, $responseObject);
            return $obj;
        } catch (\JsonMapper_Exception $e) {
            throw new WakupException($e->getMessage());
        } catch (GuzzleException $e) {
            throw new WakupException($e->getMessage());
        }
    }

}