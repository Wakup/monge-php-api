<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-18
 * Time: 18:36
 */

namespace Wakup;

use GuzzleHttp\Exception\GuzzleException;

// Oauth2
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\Signer\AccessToken\BearerAuth;
use kamermans\OAuth2\Signer\ClientCredentials\PostFormData;

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
        $this->jsonMapper = new \JsonMapper();
        $this->jsonMapper->bStrictNullTypes = false;
        $this->initMongeClient();
    }

    private function initMongeClient()
    {
        // Authorization client - this is used to request OAuth access tokens
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => 'https://login.microsoftonline.com/98048920-81ec-49aa-aa1a-1403f8889145/oauth2/token',
        ]);
        $reauth_config = [
            "client_id" => "321eac47-bafb-4243-8b48-641a39940b20",
            "client_secret" => "&=]h/!+7.0!D!*4]%^^}@.^=",
            "resource" => "377e25ef-7261-4fc9-85b6-1269ccff02a8", // optional
            "state" => time(), // optional
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
        $oauth = new OAuth2Middleware($grant_type);
        $oauth->setClientCredentialsSigner(new MicrosoftSigner($reauth_config['resource']));
        $oauth->setAccessTokenSigner(new BearerAuth());

        $stack = HandlerStack::create();
        $stack->push($oauth);

        $this->mongeClient = new \GuzzleHttp\Client([
            'handler' => $stack,
            'auth'    => 'oauth',
        ]);
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
            $response = $this->mongeClient->request('POST', $url,
                ['headers' => ['Content-Type' => 'application/json; charset=utf-8'], 'body' => $body]);
            $responseWrapper = json_decode($response->getBody());
            $obj = $responseWrapper->response;
            $this->jsonMapper->map($obj, $responseObject);
            return $obj;
        } catch (\JsonMapper_Exception $e) {
            throw new WakupException($e->getMessage());
        } catch (GuzzleException $e) {
            throw new WakupException($e->getMessage());
        }
    }

}