<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 16:31
 */

namespace Wakup;


class Guarantee
{
    private $productPlans;

    /**
     * @return GuaranteePlan[] List of guarantee plans for a given
     */
    public function getProductPlans(): array
    {
        return $this->productPlans;
    }

    /**
     * @param GuaranteePlan[] $productPlan List of guarantee plans for a given
     */
    public function setPlanProducto(array $productPlan): void
    {
        $this->productPlans = $productPlan;
    }



}