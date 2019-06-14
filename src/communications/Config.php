<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-22
 * Time: 18:57
 */

namespace Wakup;


use Monolog\Logger;

class Config
{
    var $azureLoginUrl, $azureLoginClientId,
        $wakupEndpoint, $wakupApiToken, $wakupCompanyId,
        $mongeEndpoint, $mongeCountryCode, $mongeShopCode, $mongeWarehouseCode, $mongeChannelCode, $mongeCurrencyId;

    /**
     * @var OauthConfig
     */
    var $azureOauthConfig;

    /**
     * @var OauthConfig
     */
    var $mongeOauthConfig;

    /**
     * @var Logger
     */
    var $logger;

    /**
     * Config constructor.
     * @param $logger Logger
     * @param $wakupEndpoint string Endpoint for requests to Wakup API
     * @param $wakupApiToken string API Token for requests to Wakup API
     * @param $wakupCompanyId int Wakup company identifier
     * @param $mongeEndpoint string Endpoint for requests to Monge API
     * @param $mongeCountryCode string ISO Country code for Monge API requests
     * @param $mongeShopCode int Shop code identifier for monge API requests
     * @param $mongeWarehouseCode string Warehouse identifier for
     * @param $mongeChannelCode
     * @param $mongeCurrencyId
     * @param OauthConfig $azureOauthConfig
     * @param OauthConfig $mongeOauthConfig
     * @param string $azureLoginUrl
     * @param string $azureLoginClientId
     */
    public function __construct(Logger $logger, string $wakupEndpoint, string $wakupApiToken, int $wakupCompanyId,
                                $mongeEndpoint, $mongeCountryCode, $mongeShopCode, $mongeWarehouseCode,
                                $mongeChannelCode, $mongeCurrencyId,
                                OauthConfig $mongeOauthConfig, OauthConfig $azureOauthConfig,
                                string $azureLoginUrl, string $azureLoginClientId)
    {
        $this->logger = $logger;
        $this->wakupEndpoint = $wakupEndpoint;
        $this->wakupApiToken = $wakupApiToken;
        $this->wakupCompanyId = $wakupCompanyId;
        $this->mongeEndpoint = $mongeEndpoint;
        $this->mongeCountryCode = $mongeCountryCode;
        $this->mongeShopCode = $mongeShopCode;
        $this->mongeWarehouseCode = $mongeWarehouseCode;
        $this->mongeChannelCode = $mongeChannelCode;
        $this->mongeCurrencyId = $mongeCurrencyId;
        $this->azureOauthConfig = $azureOauthConfig;
        $this->mongeOauthConfig = $mongeOauthConfig;
        $this->azureLoginUrl = $azureLoginUrl;
        $this->azureLoginClientId = $azureLoginClientId;
    }


}