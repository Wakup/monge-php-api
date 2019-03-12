<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-12
 * Time: 09:47
 */

namespace Wakup;


class Stock
{

    var $onlineStock, $storesStock;

    /**
     * @return int Stock available on distribution center for the product
     */
    public function getOnlineStock() : ?int
    {
        return $this->onlineStock;
    }

    /**
     * @param int $onlineStock Stock available on distribution center for the product
     */
    public function setOnlineStock(?int $onlineStock): void
    {
        $this->onlineStock = $onlineStock;
    }

    /**
     * @return int Total sum of product stock on physical stores
     */
    public function getStoresStock() : ?int
    {
        return $this->storesStock;
    }

    /**
     * @param int $storesStock Total sum of product stock on physical stores
     */
    public function setStoresStock(?int $storesStock): void
    {
        $this->storesStock = $storesStock;
    }



}