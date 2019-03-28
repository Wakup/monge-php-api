<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 15:25
 */

namespace Wakup;


class GuaranteePlan
{
    private $sku, $term, $description, $unitPrice, $totalPrice, $vatAmount, $preSelected;

    /**
     * @return string Guarantee SKU
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * @param string $sku Guarantee SKU
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return int Duration of the guarantee in months
     */
    public function getTerm() : int
    {
        return $this->term;
    }

    /**
     * @param int $term Duration of the guarantee in months
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
     * @return float Unit price of the guarantee
     */
    public function getUnitPrice() : float
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice Unit price of the guarantee
     */
    public function setPrecioUnitario(float $unitPrice): void
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return float Total price of the guarantee
     */
    public function getTotalPrice() : float
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice Total price of the guarantee
     */
    public function setPrecioTotal(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return float Amount of applied taxes
     */
    public function getVatAmount() : float
    {
        return $this->vatAmount;
    }

    /**
     * @param float $vatAmount Amount of applied taxes
     */
    public function setMontoIva(float $vatAmount): void
    {
        $this->vatAmount = $vatAmount;
    }

    /**
     * @return bool Defines if the guarantee must be selected by default
     */
    public function getPreSelected() : bool
    {
        return $this->preSelected;
    }

    /**
     * @param bool $preSelected Defines if the guarantee must be selected by default
     */
    public function setPlazoPreterminado(bool $preSelected): void
    {
        $this->preSelected = $preSelected;
    }




}