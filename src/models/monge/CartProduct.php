<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-21
 * Time: 18:46
 */

namespace Wakup;


class CartProduct
{
    private $typeId, $price, $count, $sku;

    const TYPE_ID_PRODUCT = 1;
    const TYPE_ID_GUARANTEE = 3;

    /**
     * CartProduct constructor.
     * @param $sku string Product SKU
     * @param $price float Product unit price
     * @param $typeId int Product type identifier. Uses the TYPE_ID_* constants for available values
     * @param $count int Amount of products of the same type & price
     */
    public function __construct(string $sku, float $price = 0, int $typeId = self::TYPE_ID_PRODUCT, int $count = 1)
    {
        $this->typeId = $typeId;
        $this->price = $price;
        $this->count = $count;
        $this->sku = $sku;
    }


    /**
     * @return int Product type identifier. Uses the TYPE_ID_* constants for available values
     */
    public function getTypeId() : int
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId Product type identifier. Uses the TYPE_ID_* constants for available values
     */
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    /**
     * @return float Product unit price
     */
    public function getPrice() : float
    {
        return $this->price;
    }

    /**
     * @param float $price Product unit price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int Amount of products of the same type & price
     */
    public function getCount() : int
    {
        return $this->count;
    }

    /**
     * @param int $count Amount of products of the same type & price
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return string Product SKU
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @param string $sku Product SKU
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return float Obtains the total price as result of multiplying the unit price by the quantity
     */
    public function getTotalPrice() : float
    {
        return $this->getPrice() * $this->getCount();
    }



}