<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 15:25
 */

namespace Wakup;


class WarrantyPlan
{
    private $sku, $term, $description, $price, $preSelected;

    /**
     * WarrantyPlan constructor.
     * @param $sku string Warranty SKU
     * @param $term int Duration of the warranty in months
     * @param $description string Internal description
     * @param $price float Unit price of the warranty
     */
    public function __construct($sku, $term, $description, $price)
    {
        $this->sku = $sku;
        $this->term = $term;
        $this->description = $description;
        $this->price = $price;
    }


    /**
     * @return string Warranty SKU
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @param string $sku Warranty SKU
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return int Duration of the warranty in months
     */
    public function getTerm() : int
    {
        return $this->term;
    }

    /**
     * @param int $term Duration of the warranty in months
     */
    public function setPlazo(int $term): void
    {
        $this->term = $term;
    }

    /**
     * @return string Internal description
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description Internal description
     */
    public function setDescripcion(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float Unit price of the warranty
     */
    public function getPrice() : float
    {
        return $this->price;
    }

    /**
     * @param float $totalPrice Total price of the warranty
     */
    public function setPrecioTotal(float $totalPrice): void
    {
        $this->price = $totalPrice;
    }

    /**
     * @return bool Defines if the warranty must be selected by default
     */
    public function getPreSelected() : bool
    {
        return $this->preSelected;
    }

    /**
     * @param bool $preSelected Defines if the warranty must be selected by default
     */
    public function setPlazoPreterminado(bool $preSelected): void
    {
        $this->preSelected = $preSelected;
    }




}