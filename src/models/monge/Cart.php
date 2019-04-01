<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-21
 * Time: 18:46
 */

namespace Wakup;


class Cart
{


    /**
     * @var CartProduct[]
     */
    private $products;

    /**
     * Cart constructor.
     * @param CartProduct[] $products List of products inside the cart
     */
    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    /**
     * @return CartProduct[] List of products inside the cart
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param CartProduct[] $products List of products inside the cart
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @return float Obtains the total price of all the products in the cart, excluding warranty plans
     */
    public function getProductsPrice() :float
    {
        $price = 0.0;
        foreach ($this->getProducts() as $product)
        {
            $price += $product->getTotalPrice();
        }
        return $price;
    }


}