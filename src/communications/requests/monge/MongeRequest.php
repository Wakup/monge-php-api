<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-25
 * Time: 13:28
 */

namespace Wakup\Requests;

use GuzzleHttp\Client;
use Wakup\Config;
use Wakup\WakupException;

class MongeRequest extends JsonRequest
{

    private $responseObjectType;

    public function __construct(Config $config, Client $client, $responseObjectType, string $path, int $port, $jsonBody,
                                bool $includeCountryCode = true, $method = 'POST')
    {
        $mergedBody = $includeCountryCode ? array_merge($jsonBody, ['pais' => $config->mongeCountryCode]) : $jsonBody;
        $body = json_encode($mergedBody);
        $url = strtr($config->mongeEndpoint, array('{$port}' => $port)).$path;
        $headers = ['Content-Type' => 'application/json-patch+json'];
        parent::__construct($config, $client, $method, $url, [], $headers, $body);
        $this->responseObjectType = $responseObjectType;
    }

    /**
     * @param $parsedJson
     * @return object
     * @throws \JsonMapper_Exception
     * @throws WakupException
     */
    function onResponseProcess($parsedJson)
    {
        if ($parsedJson->currentException) {
            // Raise exception if returned on response details
            throw new WakupException(new \Exception($parsedJson->currentException));
        } else {
            $obj = $parsedJson->response;
            $result = $obj;
            if (is_string($this->responseObjectType) && is_array($parsedJson->response)) {
                $result = $this->getJsonMapper()->mapArray($obj, array(), $this->responseObjectType);
            } else if (is_object($parsedJson) && is_object($this->responseObjectType)) {
                $result = $this->getJsonMapper()->map($obj, $this->responseObjectType);
            }
            return $result;
        }
    }

}