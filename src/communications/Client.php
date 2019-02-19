<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:44
 */

namespace Wakup;


class Client extends HttpClient
{

    /**
     * Obtains the paginated list of product attributes registered on Wakup catalogue manager
     *
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedAttributes Product attributes list with pagination information
     * @throws WakupException
     */
    public function getPaginatedAttributes($page = 0, $perPage = 25) : PaginatedAttributes
    {
        $responseObj = new PaginatedAttributes();
        $this->launchGetRequest('catalog/attributes', ['page' => $page, 'perPage' => $perPage], $responseObj);
        return $responseObj;
    }

    /**
     * Obtains the paginated list of product categories registered on Wakup catalogue manager
     *
     * @param int $page Page to request. First page is 0
     * @param int $perPage Number of results to obtain per request. Default is 25.
     * @return PaginatedCategories Product categories list with pagination information
     * @throws WakupException
     */
    public function getPaginatedCategories($page = 0, $perPage = 25) : PaginatedCategories
    {
        $responseObj = new PaginatedCategories();
        $this->launchGetRequest('catalog/categories', ['page' => $page, 'perPage' => $perPage], $responseObj);
        return $responseObj;
    }



}