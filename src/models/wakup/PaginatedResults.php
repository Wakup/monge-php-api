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
    public function hasMore() : bool
    {
        return $this->hasMore;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    /**
     * @param int $totalResults
     */
    public function setTotalResults(int $totalResults): void
    {
        $this->totalResults = $totalResults;
    }

    /**
     * @param int $totalPages
     */
    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }

    /**
     * @param bool $hasMore
     */
    public function setHasMore(bool $hasMore): void
    {
        $this->hasMore = $hasMore;
    }


}