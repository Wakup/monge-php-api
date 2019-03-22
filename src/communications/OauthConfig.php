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
     * @param $tenant
     * @param $clientId
     * @param $clientSecret
     * @param $resource
     */
    public function __construct($tenant, $clientId, $clientSecret, $resource)
    {
        $this->tenant = $tenant;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->resource = $resource;
    }

}