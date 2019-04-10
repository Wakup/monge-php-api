<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-04-09
 * Time: 20:18
 */

namespace Wakup;


class SkuStock
{

    private $sku, $stock;

    /**
     * @return string Product SKU
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @return int Stock count for linked product SKU
     */
    public function getStock() : int
    {
        return $this->stock;
    }

    /**
     * @param string $sku Product SKU
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @param int $stock Stock count for linked product SKU
     */
    public function setCantidad(int $stock): void
    {
        $this->stock = $stock;
    }

}