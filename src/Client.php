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
    /**
     * Obtains the paginated list of product attributes registered on Wakup catalogue manager
     *
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedAttributes Product attributes list with pagination information
     * @throws GuzzleException Exce
     * @throws \JsonMapper_Exception
     */
    public function getPaginatedAttributes($page = 0, $perPage = 25) : PaginatedAttributes
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://ecommerce.wakup.net:9000/catalog/attributes',
            ['query' => ['page' => $page, 'perPage' => $perPage]]);
        $obj = json_decode($response->getBody());
        $mapper = new \JsonMapper();
        $response = new PaginatedAttributes();
        $mapper->map($obj, $response);
        return $response;
    }

}