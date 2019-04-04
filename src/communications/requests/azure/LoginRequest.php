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
use GuzzleHttp\Exception\GuzzleException;
use Wakup\Config;

class LoginRequest extends JsonRequest
{

    public function __construct(Config $config, Client $client, string $username, string $password)
    {
        $url = $config->azureLoginUrl;
        $queryParams = ['p' => 'b2c_1_ropc'];
        $headers = ['Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8'];
        $params = [
            'username' => $username,
            'password' => $password,
            'grant_type' => 'password',
            'scope' => "openid {$config->azureLoginClientId} offline_access",
            'client_id' => $config->azureLoginClientId,
            'response_type' => 'token id_token',
        ];
        $body = http_build_query($params);
        parent::__construct($config, $client, 'POST', $url, $queryParams, $headers, $body);
    }

    /**
     * @param $parsedJson
     * @return bool
     */
    function onResponseProcess($parsedJson) : bool
    {
        return true;
    }

    public function onRequestException(\Exception $e)
    {
        if ($e instanceof ClientException) {
            $response = $e->getResponse();
            // Check if error is produced by invalid credentials
            if ($response->getStatusCode() == 400) {
                $jsonBody = json_decode($response->getBody()->__toString());
                if ($jsonBody->error == 'access_denied') {
                    return false;
                }
            }
        }
        return parent::onRequestException($e);
    }

}