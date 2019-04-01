<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 16:31
 */

namespace Wakup;


class Warranty
{
    private $productPlans;

    /**
     * @return WarrantyPlan[] List of warranty plans for a given
     */
    public function getProductPlans(): array
    {
        return $this->productPlans;
    }

    /**
     * @param WarrantyPlan[] $productPlan List of warranty plans for a given
     */
    public function setPlanProducto(array $productPlan): void
    {
        $this->productPlans = $productPlan;
    }



}