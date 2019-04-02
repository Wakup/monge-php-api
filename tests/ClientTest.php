<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-21
 * Time: 20:15
 */

declare(strict_types=1);

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{

    private static function getClient() : \Wakup\Client
    {
        return new Wakup\Client();
    }

    private function getTestUser() : \Wakup\User
    {
        return new \Wakup\User('01-0730-0179', \Wakup\User::ID_TYPE_TAX_ID,
            'Ana', 'Isabel', 'Ramirez', 'Ramirez',
            '1408804', '1365853', 'pruebas09@gmail.com');
    }

    /**
     * @group Wakup
     */
    public function testGetWakupPaginatedAttributesValue() : void
    {
        $this->assertInstanceOf(
            \Wakup\PaginatedAttributes::class,
            static::getClient()->getPaginatedAttributes()
        );
    }

    /**
     * @group Wakup
     */
    public function testGetWakupPaginatedCategoriesValue() : void
    {
        $this->assertInstanceOf(
            Wakup\PaginatedCategories::class,
            static::getClient()->getPaginatedCategories()
        );
    }

    /**
     * @group Wakup
     */
    public function testGetWakupPaginatedProductsValue() : void
    {
        $this->assertInstanceOf(
            \Wakup\PaginatedProducts::class,
            static::getClient()->getPaginatedProducts()
        );
    }

    /**
     * @group Wakup
     */
    public function testGetUserCreditInfo() : void
    {
        $clientInfo = static::getClient()->getUserCreditInfo("02-0448-0419");
        $this->assertInstanceOf(\Wakup\UserCreditInfo::class, $clientInfo);
        $this->assertIsInt($clientInfo->getCreditLineId());
        $this->assertIsInt($clientInfo->getAccountId());
        $this->assertIsInt($clientInfo->getAccountStatusId());
        $this->assertIsInt($clientInfo->getPersonId());
        $this->assertIsFloat($clientInfo->getAvailableCreditFee());
        $this->assertIsFloat($clientInfo->getAvailableCreditLine());
    }

    public function testGetWarrantyPlans() : void
    {
        $results = static::getClient()->getWarrantyPlans('100331', 1000);
        $this->assertIsArray($results);
        foreach ($results as $plan) {
            $this->assertInstanceOf(\Wakup\WarrantyPlan::class, $plan);
            $this->assertIsString($plan->getSku());
            $this->assertIsString($plan->getDescription());
            $this->assertIsInt($plan->getTerm());
            $this->assertIsFloat($plan->getPrice());
            $this->assertIsFloat($plan->getTaxAmount());
            $this->assertIsFloat($plan->getPriceWithoutTax());
            $this->assertEquals($plan->getPrice(), $plan->getPriceWithoutTax() + $plan->getTaxAmount());
        }
    }

    public function testGetUserFinancialPromotions() : void
    {
        $results = static::getClient()->getFinancialPromotions(145896, ['152950','146859']);
        $this->assertIsArray($results);
        foreach ($results as $promotion) {
            $this->assertInstanceOf(\Wakup\FinancialPromocion::class, $promotion);
            $this->assertIsInt($promotion->getId());
            $this->assertIsString($promotion->getName());
        }
    }

    public function testGetUserFinancialScenarios() : void
    {
        $cart = new \Wakup\Cart([new \Wakup\CartProduct('135360', 21900)]);
        $results = static::getClient()->getFinancialScenarios(145896, 302, 1, $cart);
        $this->assertIsArray($results);
        foreach ($results as $item) {
            $this->assertInstanceOf(\Wakup\FinancialScenario::class, $item);
        }
    }

    public function testGetStoresStock() : void
    {
        $cart = new \Wakup\Cart([new \Wakup\CartProduct('100331')]);
        $stores = ['C212', 'C002'];
        $results = static::getClient()->getStoresStock($stores, $cart);
        foreach ($results as $item) {
            $this->assertInstanceOf(\Wakup\StoreStock::class, $item);
            $this->assertIsString($item->getStoreId());
            $this->assertIsInt($item->getWarehouseId());
            $this->assertIsArray($item->getItems());
            foreach ($cart->getProducts() as $product) {
                // Ensure that requested products are returned
                $this->assertArrayHasKey($product->getSku(), $item->getItems());
            }
        }
    }

    public function testReserveStoreStock() : void
    {
        $cart = new \Wakup\Cart([new \Wakup\CartProduct('100331')]);
        $result = static::getClient()->reserveOrderStock('C002', 1001, $cart);
        $this->assertIsString($result);
        $this->reservationId = $result;
    }

    public function testCancelStoreStockReservation() : void
    {
        $cart = new \Wakup\Cart([new \Wakup\CartProduct('100331')]);
        $reservationId = static::getClient()->reserveOrderStock('C002', 1001, $cart);
        $result = static::getClient()->cancelOrderStockReservation($reservationId);
        $this->assertIsBool($result);
    }

    public function testProcessOrder() : void
    {
        $warranty = new \Wakup\WarrantyPlan('100331', 12, 'Extragarantia', 100000);
        $product = new \Wakup\CartProduct('100331', 10000, 13, 1, $warranty);
        $result = static::getClient()->processOrder(
            new \Wakup\Order(
                $this->getTestUser(),
                'order01',
                new \Wakup\Cart([$product]),
                new \Wakup\Store('C002', '1001', 'Shop name', 'Address', 0, 0),
                \Wakup\Order::PAYMENT_METHOD_CREDIT_CARD));
        $this->assertIsBool($result);
    }

}