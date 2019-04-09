<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:42
 */

namespace Wakup;


class PaginatedStores extends PaginatedResults
{
    private $stores;

    /**
     * @return Store[] List of obtained categories
     */
    public function getStores() : array
    {
        return $this->stores;
    }

    /**
     * @param Store[] $stores
     */
    public function setStores(array $stores): void
    {
        $this->stores = $stores;
    }
}