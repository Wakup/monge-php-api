<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 17:44
 */

namespace Wakup;


class PaginatedResults
{
    private $page, $perPage, $totalResults, $totalPages, $hasMore;


    /**
     * @return int Current page number
     */
    public function getPage() : int
    {
        return $this->page;
    }

    /**
     * @return int Results requested per page
     */
    public function getPerPage() : int
    {
        return $this->perPage;
    }

    /**
     * @return int Total obtained results
     */
    public function getTotalResults() : int
    {
        return $this->totalResults;
    }

    /**
     * @return int Total obtained pages
     */
    public function getTotalPages() : int
    {
        return $this->totalPages;
    }

    /**
     * @return bool Returns true if there is more pages to fetch
     */
    public function getHasMore() : bool
    {
        return $this->hasMore;
    }


}