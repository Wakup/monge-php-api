<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-12
 * Time: 14:16
 */

namespace Wakup;


use kamermans\OAuth2\Signer\ClientCredentials\PostFormData;

class MicrosoftSigner extends PostFormData
{

    var $resource;

    /**
     * MicrosoftSigner constructor.
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct();
        $this->resource = $resource;
    }


    public function sign($request, $clientId, $clientSecret)
    {
        $parentRequest = parent::sign($request, $clientId, $clientSecret);
        // Include resource on request body
        parse_str($parentRequest->getBody(), $data);
        $data['resource'] = $this->resource;

        $body_stream = \GuzzleHttp\Psr7\stream_for(http_build_query($data, '', '&'));
        return $parentRequest->withBody($body_stream);
    }


}