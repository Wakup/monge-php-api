<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-22
 * Time: 13:47
 */

namespace Wakup;

class OauthConfig
{
    var $tenant, $clientId, $clientSecret, $resource;

    /**
     * OauthConfig constructor.
     * @param $tenant string
     * @param $clientId string
     * @param $clientSecret string
     * @param $resource string
     */
    public function __construct(string $tenant, string $clientId, ?string $clientSecret=null, ?string $resource=null)
    {
        $this->tenant = $tenant;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->resource = $resource;
    }

}