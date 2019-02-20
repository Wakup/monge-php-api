<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-20
 * Time: 18:47
 */

namespace Wakup;


class ProductPrice
{
    var $priceWithVat, $priceWithoutVat, $vat;

    /**
     * @return float Product price with VAT applied
     */
    public function getPriceWithVat() : float
    {
        return $this->priceWithVat;
    }

    /**
     * @param float $priceWithVat Product price with VAT applied
     */
    public function setPriceWithVat(float $priceWithVat): void
    {
        $this->priceWithVat = $priceWithVat;
    }

    /**
     * @return float Product price without VAT
     */
    public function getPriceWithoutVat() : float
    {
        return $this->priceWithoutVat;
    }

    /**
     * @param float $priceWithoutVat Product price without VAT
     */
    public function setPriceWithoutVat(float $priceWithoutVat): void
    {
        $this->priceWithoutVat = $priceWithoutVat;
    }

    /**
     * @return float VAT expressed as percent
     */
    public function getVat() : float
    {
        return $this->vat;
    }

    /**
     * @param float $vat VAT expressed as percent
     */
    public function setVat(float $vat): void
    {
        $this->vat = $vat;
    }


}