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

class WakupRequest extends JsonRequest
{

    private $responseObjectType;

    public function __construct(Config $config, Client $client, $responseObjectType, string $path, array $params, int $page = 0, int $perPage = 25)
    {
        $url = $config->wakupEndpoint.$path;
        $queryParams = array_merge($params, ['page' => $page, 'perPage' => $perPage]);
        $headers = ['API-Token' => $config->wakupApiToken];
        parent::__construct($config, $client, 'GET', $url, $queryParams, $headers);
        $this->responseObjectType = $responseObjectType;
    }

    /**
     * @param $parsedJson
     * @return object
     * @throws \JsonMapper_Exception
     */
    function onResponseProcess($parsedJson)
    {
        return $this->getJsonMapper()->map($parsedJson, $this->responseObjectType);
    }

}