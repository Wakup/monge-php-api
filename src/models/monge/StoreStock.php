<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-26
 * Time: 16:42
 */

namespace Wakup;


class StoreStock
{
    private $store, $items;

    /**
     * StoreStock constructor.
     * @param $store Store Store linked to the products stock
     * @param $items array Associative array where the key is the product SKU and the value represents the stock count
     */
    public function __construct($store, $items)
    {
        $this->store = $store;
        $this->items = $items;
    }

    /**
     * @return Store Store linked to the products stock
     */
    public function getStore(): Store
    {
        return $this->store;
    }

    /**
     * @param Store $store Store linked to the products stock
     */
    public function setStore(Store $store): void
    {
        $this->store = $store;
    }

    /**
     * @return SkuStock[] List of stock info for requested products
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param SkuStock[] $items List of stock info for requested products
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Obtains the stock count of the product with the given SKU
     * @param string $sku SKU of the product to obtain stock from
     * @return int|null Stock count for the given SKU or null if product is not found
     */
    public function getSkuStock(string $sku) : ?int
    {
        $count = null;
        foreach ($this->getItems() as $skuItem) {
            if ($skuItem->getSku() == $sku) {
                $count = $skuItem->getStock();
            }
        }
        return $count;
    }


}