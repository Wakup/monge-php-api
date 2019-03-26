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
    private $storeId, $warehouseId, $items;

    /**
     * @return string Store identifier
     */
    public function getStoreId(): string
    {
        return $this->storeId;
    }

    /**
     * @param string $storeId Store identifier
     */
    public function setTienda(string $storeId): void
    {
        $this->storeId = $storeId;
    }

    /**
     * @return int Identifier for store warehouse
     */
    public function getWarehouseId(): int
    {
        return $this->warehouseId;
    }

    /**
     * @param int $warehouseId Identifier for store warehouse
     */
    public function setBodega(int $warehouseId): void
    {
        $this->warehouseId = $warehouseId;
    }

    /**
     * @return array Associative array where the key is the product SKU and the value represents the stock count
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items Associative array where the key is the product SKU and the value represents the stock count
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function setArticulos(array $itemArray)
    {
        $this->items = [];
        foreach ($itemArray as $item) {
            $this->items[$item->sku] = $item->cantidad;
        }
        return $this->items;
    }





}