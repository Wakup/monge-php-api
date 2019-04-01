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
    private $price, $count, $sku, $taxRate, $warrantyPlan;

    /**
     * CartProduct constructor.
     * @param $sku string Product SKU
     * @param $price float Product unit price including taxes
     * @param $taxRate float Applied tax rate for product expressed in percent
     * @param $typeId int Product type identifier. Uses the TYPE_ID_* constants for available values
     * @param $count int Amount of products of the same type & price
     * @param $warrantyPlan Warranty plan linked with the products
     */
    public function __construct(string $sku, float $price = 0, float $taxRate = 0, int $count = 1, ?WarrantyPlan $warrantyPlan = null)
    {
        $this->price = $price;
        $this->count = $count;
        $this->sku = $sku;
        $this->warrantyPlan = $warrantyPlan;
        $this->taxRate = $taxRate;
    }

    /**
     * @return float Product unit price
     */
    public function getPrice() : float
    {
        return $this->price;
    }

    /**
     * @return int Amount of products of the same type & price
     */
    public function getCount() : int
    {
        return $this->count;
    }

    /**
     * @return string Product SKU
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @return float Obtains the total price as result of multiplying the unit price (including taxes) by the quantity
     */
    public function getTotalPrice() : float
    {
        return $this->getPrice() * $this->getCount();
    }

    /**
     * @return float Obtains the total price as result of multiplying the unit price (without taxes) by the quantity
     */
    public function getTotalPriceWithoutTax() : float
    {
        return $this->getPriceWithoutTax() * $this->getCount();
    }

    /**
     * @return float Applied tax rate for product
     */
    public function getTaxRate() : float
    {
        return $this->taxRate;
    }

    /**
     * @return float Obtains the unit price before applying taxes
     */
    public function getPriceWithoutTax() : float
    {
        return $this->getTotalPrice() / (1 + $this->getTaxRate() / 100);
    }

    /**
     * @return float Obtains the tax amount per unit
     */
    public function getTaxAmount() : float
    {
        return $this->getPrice() - $this->getPriceWithoutTax();
    }

    /**
     * @return bool Returns true if the product has a warranty plan assigned
     */
    public function hasWarranty() : bool
    {
        return $this->getWarrantyPlan() != null;
    }

    /**
     * @return float|null Obtains the total warranty price by multiplying the warranty unit price by the product quantity
     */
    public function getWarrantyPlanTotalPrice() : ?float
    {
        return $this->getWarrantyPlan() != null ? $this->getWarrantyPlan()->getPrice() * $this->getCount() : null;
    }

    /**
     * @return WarrantyPlan Warranty plan linked with the products
     */
    public function getWarrantyPlan(): ?WarrantyPlan
    {
        return $this->warrantyPlan;
    }

}