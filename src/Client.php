<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:44
 */

namespace Wakup;


use GuzzleHttp\Exception\GuzzleException;

class Client
{

    public function getPaginatedAttributes(int $page = 0, int $perPage = 25) : PaginatedAttributes
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://ecommerce.wakup.net:9000/catalog/attributes');
        $body = $response->getBody();
        $obj = json_decode($body);
        $mapper = new \JsonMapper();
        $response = new PaginatedAttributes();
        $mapper->map($obj, $response);
        return $response;
    }

}