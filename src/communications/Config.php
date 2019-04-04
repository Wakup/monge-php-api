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
        $wakupEndpoint, $wakupApiToken,
        $mongeEndpoint, $mongeCountryCode, $mongeShopCode, $mongeChannelCode, $mongeCurrencyId;

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
     * @param $mongeEndpoint
     * @param $mongeCountryCode
     * @param $mongeShopCode
     * @param $mongeChannelCode
     * @param $mongeCurrencyId
     * @param OauthConfig $azureOauthConfig
     * @param OauthConfig $mongeOauthConfig
     * @param string $azureLoginUrl
     * @param string $azureLoginClientId
     */
    public function __construct($wakupEndpoint, $wakupApiToken,
                                $mongeEndpoint, $mongeCountryCode, $mongeShopCode, $mongeChannelCode, $mongeCurrencyId,
                                OauthConfig $mongeOauthConfig, OauthConfig $azureOauthConfig,
                                string $azureLoginUrl, string $azureLoginClientId)
    {
        $this->wakupEndpoint = $wakupEndpoint;
        $this->wakupApiToken = $wakupApiToken;
        $this->mongeEndpoint = $mongeEndpoint;
        $this->mongeCountryCode = $mongeCountryCode;
        $this->mongeShopCode = $mongeShopCode;
        $this->mongeChannelCode = $mongeChannelCode;
        $this->mongeCurrencyId = $mongeCurrencyId;
        $this->azureOauthConfig = $azureOauthConfig;
        $this->mongeOauthConfig = $mongeOauthConfig;
        $this->azureLoginUrl = $azureLoginUrl;
        $this->azureLoginClientId = $azureLoginClientId;
    }


}