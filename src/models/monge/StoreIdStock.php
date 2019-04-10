<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-26
 * Time: 16:42
 */

namespace Wakup;


class StoreIdStock
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
     * @return SkuStock[] List of stock info for requested products
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param SkuStock[] $items List of stock info for requested products
     */
    public function setArticulos(array $items)
    {
        $this->items = $items;
    }

}