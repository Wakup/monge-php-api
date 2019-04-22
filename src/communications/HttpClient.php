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
use Wakup\Requests\Request;

class HttpClient
{

    /**
     * @var \GuzzleHttp\Client
     */
    var $defaultClient;

    /**
     * @var \GuzzleHttp\Client
     */
    var $mongeClient;

    /**
     * @var \GuzzleHttp\Client
     */
    var $azureClient;

    /**
     * @var Config
     */
    var $config;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->config = $this->getConfig();
        $this->defaultClient = new \GuzzleHttp\Client();
        $this->mongeClient =  $this->getOauthClient($this->config->mongeOauthConfig);
        $this->azureClient =  $this->getOauthClient($this->config->azureOauthConfig);
    }

    private function getConfig() : Config
    {
        // TODO take config as parameter
        return new Config(
            'http://ecommerce.wakup.net:9000/',
            '66145878-9b0f-415f-ac1b-f10c6306face',
            335,
            'http://ecommerce.grupomonge-ti.com:{$port}/api/v1.0/', 'CR',
            212, 8004, 260, 188,
            new OauthConfig(
                '98048920-81ec-49aa-aa1a-1403f8889145',
                '321eac47-bafb-4243-8b48-641a39940b20',
                '&=]h/!+7.0!D!*4]%^^}@.^=',
                '377e25ef-7261-4fc9-85b6-1269ccff02a8'
            ),
            new OauthConfig(
                'grupomongetvdev.onmicrosoft.com',
                '58d597dd-59d9-48f6-8404-cd77f5ae4765',
                'sOHaAAB5uKmuLcsJNLZH9x/NVFwdcPMiu7QMgunRk28=',
                'https://graph.windows.net'
            ),
            'https://grupomongetvdev.b2clogin.com/grupomongetvdev.onmicrosoft.com/oauth2/v2.0/token',
            '532ada02-78e6-40f5-8075-10d5d671bb1a'
            );
    }

    private function getOauthClient(OauthConfig $config) : \GuzzleHttp\Client
    {
        // Authorization client - this is used to request OAuth access tokens
        $reauth_client = new \GuzzleHttp\Client([
            // URL for access_token request
            'base_uri' => "https://login.microsoftonline.com/{$config->tenant}/oauth2/token",
        ]);
        $reauth_config = [
            "client_id" => $config->clientId,
            "client_secret" => $config->clientSecret,
            "resource" => $config->resource, // optional
            "state" => time(), // optional
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
        $oauth = new OAuth2Middleware($grant_type);
        $oauth->setClientCredentialsSigner(new MicrosoftSigner($reauth_config['resource']));
        $oauth->setAccessTokenSigner(new BearerAuth());
        // TODO Include persistance

        $stack = HandlerStack::create();
        $stack->push($oauth);

        return new \GuzzleHttp\Client([
            'handler' => $stack,
            'auth'    => 'oauth',
        ]);
    }

}