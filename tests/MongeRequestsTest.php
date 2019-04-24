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

final class MongeRequestsTest extends TestCase
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
        $cart = $this->getTestCart(['135360']);
        $results = static::getClient()->getFinancialScenarios(145896, 302, 1, $cart);
        $this->assertIsArray($results);
        foreach ($results as $item) {
            $this->assertInstanceOf(\Wakup\FinancialScenario::class, $item);
        }
    }

    public function testGetStoresStock() : void
    {
        $stores = ['C212', 'C002'];
        $results = static::getClient()->getStoresStock($stores, $this->getTestCart());
        foreach ($results as $item) {
            $this->assertInstanceOf(\Wakup\StoreIdStock::class, $item);
            $this->assertIsString($item->getStoreId());
            $this->assertIsInt($item->getWarehouseId());
            $this->assertIsArray($item->getItems());
            foreach ($item->getItems() as $skuStock) {
                $this->assertIsString($skuStock->getSku());
                $this->assertIsInt($skuStock->getStock());
            }
        }
    }

    public function testGetNearestStoresStock() : void
    {
        $results = static::getClient()->getNearestStoresStock($this->getTestCart(), 9, -82);
        $this->assertIsArray($results);
        $lastDistance = 0;
        foreach ($results as $storeStock) {
            $this->assertInstanceOf(\Wakup\StoreStock::class, $storeStock);
            $this->assertIsArray($storeStock->getItems());
            foreach ($storeStock->getItems() as $skuStock) {
                $this->assertIsString($skuStock->getSku());
                $this->assertIsInt($skuStock->getStock());
            }
            # Validate store
            $store = $storeStock->getStore();
            $this->assertInstanceOf(\Wakup\Store::class, $store);
            # Warehouse ID should be set
            $this->assertIsString($storeStock->getStore()->getWarehouseId());
            # Should be ordered by distance
            $this->assertGreaterThanOrEqual($lastDistance, $store->getDistanceInMiles(),
                'Stores should be ordered by distance');
            $lastDistance = $store->getDistanceInMiles();
        }
    }

    public function testReserveStoreStock() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_STORE;
        $result = static::getClient()->reserveOrderStock($orderType,  $this->getTestStore(), $this->getTestCart());
        $this->assertIsString($result);
    }

    public function testCancelStoreStockReservation() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_STORE;
        $reservationId = static::getClient()->reserveOrderStock($orderType,  $this->getTestStore(), $this->getTestCart());
        $result = static::getClient()->cancelOrderStockReservation($orderType, $reservationId);
        $this->assertIsBool($result);
    }

    public function testReserveCentralStock() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_CENTRAL;
        $result = static::getClient()->reserveOrderStock($orderType,  $this->getTestStore(), $this->getTestCart());
        $this->assertIsString($result);
    }

    public function testCancelCentralStockReservation() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_CENTRAL;
        $reservationId = static::getClient()->reserveOrderStock($orderType,  $this->getTestStore(), $this->getTestCart());
        $result = static::getClient()->cancelOrderStockReservation($orderType, $reservationId);
        $this->assertIsBool($result);
    }

    public function testConfirmCentralStockReservation() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_CENTRAL;
        $cart = $this->getTestCart();
        $reservationId = static::getClient()->reserveOrderStock($orderType,  $this->getTestStore(), $cart);
        $result = static::getClient()->confirmOrderStockReservation($orderType, $reservationId, $cart);
        $this->assertIsBool($result);
    }

    public function testProcessOrder() : void
    {
        $result = static::getClient()->processOrder(
            new \Wakup\Order(
                $this->getTestUser(),
                'order01',
                $this->getTestCart(),
                $this->getTestStore(),
                \Wakup\Order::PAYMENT_METHOD_CREDIT_CARD));
        $this->assertIsBool($result);
    }

    // Private helper methods
    private function getTestStore(string $storeId = 'C002'): \Wakup\Store
    {
        return new \Wakup\Store($storeId, '1001', 'Shop name', 'Address', 0, 0);
    }

    private function getTestCartProduct(string $sku = '100331') : \Wakup\CartProduct
    {
        $warranty = new \Wakup\WarrantyPlan($sku, 12, 'Extragarantia', 100000);
        return new \Wakup\CartProduct($sku, 10000, 13, 1, $warranty);
    }

    private function getTestCart($skuArray = ['100331']) : \Wakup\Cart
    {
        $products = [];
        foreach ($skuArray as $sku) {
            array_push($products, $this->getTestCartProduct($sku));
        }
        return new \Wakup\Cart($products);
    }
}