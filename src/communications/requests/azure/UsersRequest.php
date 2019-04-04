<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-25
 * Time: 13:28
 */

namespace Wakup\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Wakup\Config;
use Wakup\WakupException;

class UsersRequest extends JsonRequest
{

    private $responseObjectType;

    public function __construct(Config $config, Client $client, string $method, $headers = [], array $params = [],
                                $jsonBody = null, $responseObjectType = null, ?string $userId = null)
    {
        $body = $jsonBody != null ? json_encode($jsonBody) : null;
        $url = "https://graph.windows.net/{$config->azureOauthConfig->tenant}/users";
        if ($userId != null) $url .= "/{$userId}";
        $mergerHeaders = array_merge(['Content-Type' => 'application/json', 'api-version' => '1.6'], $headers);
        parent::__construct($config, $client, $method, $url, $params, $mergerHeaders, $body);
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
        $result = null;
        if ($parsedJson != null) {
            if (is_string($this->responseObjectType) && property_exists($parsedJson, 'value') && is_array($parsedJson->value)) {
                $result = $this->getJsonMapper()->mapArray($parsedJson->value, array(), $this->responseObjectType);
            } else if (is_object($parsedJson) && is_object($this->responseObjectType)) {
                $result = $this->getJsonMapper()->map($parsedJson, $this->responseObjectType);
            }
        }
        return $result;
    }

    public function onRequestException(\Exception $e)
    {
        if ($e instanceof ClientException) {
            $response = $e->getResponse();
            $jsonBody = json_decode($response->getBody()->__toString());
            if (property_exists($jsonBody, 'odata.error')) {
                throw new WakupException(new \Exception($jsonBody->{'odata.error'}->message->value));
            }
        }
        return parent::onRequestException($e);
    }
}