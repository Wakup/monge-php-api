<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-20
 * Time: 13:36
 */

namespace Wakup;


class Product
{
    private $sku, $stock, $price, $info, $images;

    /**
     * @return string Product unique SKU
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @param string $sku Product unique SKU
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return int Available product units
     */
    public function getStock() : int
    {
        return $this->stock;
    }

    /**
     * @param int $stock Available product stock units
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return ProductPrice Product price information. Will be null if there is no changes since last request
     */
    public function getPrice() : ?ProductPrice
    {
        return $this->price;
    }

    /**
     * @param ProductPrice $price Product price information. Will be null if there is no changes since last request
     */
    public function setPrice(?ProductPrice $price): void
    {
        $this->price = $price;
    }

    /**
     * @return ProductInfo Product detailed info. Will be null if there is no changes since last request
     */
    public function getInfo() : ?ProductInfo
    {
        return $this->info;
    }

    /**
     * @param ProductInfo $info Product detailed info. Will be null if there is no changes since last request
     */
    public function setInfo(?ProductInfo $info): void
    {
        $this->info = $info;
    }

    /**
     * @return ProductImage[] Product images. Will be null if images has no changes since last update
     */
    public function getImages() : ?array
    {
        return $this->images;
    }

    /**
     * @param ProductImage[] $images Product images. Will be null if images has no changes since last update
     */
    public function setImages(?array $images): void
    {
        $this->images = $images;
    }


}