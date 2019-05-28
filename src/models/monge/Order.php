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

    /**
     * @var
     */
    private $reservationId;

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
     * @var PaymentInfo $paymentInfo
     */
    private $paymentInfo;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var ContactPreferences User contact preferences to receive order status updates
     */
    private $contactPreferences;

    /**
     * Order constructor.
     * @param User $user User that makes the order
     * @param string $orderNumber Magento identifier for current order
     * @param string $reservationId Identifier for stock reservation obtained on reserveOrderStock method
     * @param Cart $cart Products added to cart by the user
     * @param Store $store Store that will be the pick-up point of the order
     * @param ContactPreferences $contactPreferences User contact preferences to receive order status updates
     * @param PaymentInfo $paymentInfo Information about the payment method selected by the user
     */
    public function __construct(User $user, string $orderNumber, string $reservationId, Cart $cart, Store $store,
                                ContactPreferences $contactPreferences, PaymentInfo $paymentInfo)
    {
        $this->user = $user;
        $this->orderNumber = $orderNumber;
        $this->cart = $cart;
        $this->store = $store;
        $this->paymentInfo = $paymentInfo;
        $this->contactPreferences = $contactPreferences;
        $this->reservationId = $reservationId;
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
     * @return PaymentInfo
     */
    public function getPaymentInfo(): PaymentInfo
    {
        return $this->paymentInfo;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return ContactPreferences
     */
    public function getContactPreferences(): ContactPreferences
    {
        return $this->contactPreferences;
    }

    /**
     * @return string
     */
    public function getReservationId() : string
    {
        return $this->reservationId;
    }


}