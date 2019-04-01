<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-27
 * Time: 17:35
 */

namespace Wakup;


class Order
{

    const PAYMENT_METHOD_PAYPAL = 'PAY';
    const PAYMENT_METHOD_CREDIT_CARD = 'TAR';
    const PAYMENT_METHOD_FLEXIPAGO = 'FLE';

    /**
     * @var string Magento identifier for current order
     */
    private $orderNumber;

    /**
     * @var Cart $cart
     */
    private $cart;
    /**
     * @var Store $store
     */
    private $store;
    /**
     * @var string $paymentMethod
     */
    private $paymentMethod;

    /**
     * Order constructor.
     * @param Cart $cart
     * @param Store $store
     * @param string $paymentMethod
     */
    public function __construct(string $orderNumber, Cart $cart, Store $store, string $paymentMethod)
    {
        $this->orderNumber = $orderNumber;
        $this->cart = $cart;
        $this->store = $store;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    /**
     * @return Cart
     */
    public function getCart() : Cart
    {
        return $this->cart;
    }

    /**
     * @return Store
     */
    public function getStore(): Store
    {
        return $this->store;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }


}