<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:42
 */

namespace Wakup;


class PaginatedProducts extends PaginatedResults
{
    private $products, $deletedProducts;

    /**
     * @return Product[] List of obtained categories
     */
    public function getProducts() : array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @return string[] List of SKU of deleted products since last request
     */
    public function getDeletedProducts() : array
    {
        return $this->deletedProducts;
    }

    /**
     * @param string[] $deletedProducts List of SKU of deleted products since last request
     */
    public function setDeletedProducts(array $deletedProducts): void
    {
        $this->deletedProducts = $deletedProducts;
    }



}