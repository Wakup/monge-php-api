<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-22
 * Time: 18:57
 */

namespace Wakup;


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
     * Config constructor.
     * @param $wakupEndpoint
     * @param $wakupApiToken
     * @param $wakupCompanyId
     * @param $mongeEndpoint
     * @param $mongeCountryCode
     * @param $mongeShopCode
     * @param $mongeWarehouseCode
     * @param $mongeChannelCode
     * @param $mongeCurrencyId
     * @param OauthConfig $azureOauthConfig
     * @param OauthConfig $mongeOauthConfig
     * @param string $azureLoginUrl
     * @param string $azureLoginClientId
     */
    public function __construct(string $wakupEndpoint, string $wakupApiToken, int $wakupCompanyId,
                                $mongeEndpoint, $mongeCountryCode, $mongeShopCode, $mongeWarehouseCode,
                                $mongeChannelCode, $mongeCurrencyId,
                                OauthConfig $mongeOauthConfig, OauthConfig $azureOauthConfig,
                                string $azureLoginUrl, string $azureLoginClientId)
    {
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