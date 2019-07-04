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
require_once __DIR__ . '/ParentRequestsTest.php';

final class MongeRequestsTest extends ParentRequestsTest
{

    public function testGetUserCreditInfo() : void
    {
        $clientInfo = static::getClient()->getUserCreditInfo("01-0882-0710");
        $this->assertInstanceOf(\Wakup\UserCreditInfo::class, $clientInfo);
        $this->assertIsInt($clientInfo->getCreditLineId());
        $this->assertIsInt($clientInfo->getAccountId());
        $this->assertIsInt($clientInfo->getAccountStatusId());
        $this->assertIsInt($clientInfo->getPersonId());
        $this->assertIsFloat($clientInfo->getAvailableCreditFee());
        $this->assertIsFloat($clientInfo->getAvailableCreditLine());
    }

    public function testGetNullUserCreditInfo() : void
    {
        $clientInfo = static::getClient()->getUserCreditInfo("01-0111-0210");
        $this->assertNull($clientInfo);
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

    public function testGeneraDocumentos() : void
    {
        $results = static::getClient()->generaDocumentos('7826C298-059D-4D01-8222-FFFF0D2D087F');
        $this->assertIsArray($results);
    }

    public function testEnviarToken() : void
    {
        $results = static::getClient()->EnviarToken( "Email","UsuarioTV@grupomonge.com", 0, "00-1234-0121", 0);
        $this->assertIsArray($results);
    }

    public function testValidarToken() : void
    {
        $results = static::getClient()->ValidarToken( 0,"00-1234-0121", "");
        $this->assertIsArray($results);
    }

    public function testPreAutorizacion() : void
    {
        $results = static::getClient()->PreAutorizacion( 188,
         830.0,
         260,
         66459,
         0,
         415688,
         1,
         10001,
         "C002",
         20000.0,
         "1",
         3,
            "1234445",
         "23455",
         0.0,
         0.0,
         "CLIENTE_ECOMMERCE"
        );

        $this->assertIsArray($results);
    }

    public function testGetUserFinancialPromotions() : void
    {
        $clientInfo = static::getClient()->getUserCreditInfo("06-0363-0273");
        $cart = $this->getTestCart(['152950','146859']);
        $results = static::getClient()->getFinancialPromotions($clientInfo, $cart);
        $this->assertIsArray($results);
        foreach ($results as $promotion) {
            $this->assertInstanceOf(\Wakup\FinancialPromotion::class, $promotion);
            $this->assertIsInt($promotion->getId());
            $this->assertIsString($promotion->getName());
        }
    }

    public function testGetUserFinancialScenarios() : void
    {
        $clientInfo = static::getClient()->getUserCreditInfo("06-0363-0273");
        $cart = $this->getTestCart(['135360']);
        $results = static::getClient()->getFinancialScenarios($clientInfo, 1, $cart);
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
        $results = static::getClient()->getNearestStoresStock($this->getTestCart(['152420']), 9, -82);
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

    public function testProcessCreditCardOrder() : void
    {
        $paymentInfo = \Wakup\PaymentInfo::creditCard('1200540043', '01452841');
        $result = static::getClient()->processOrder(
            new \Wakup\Order(
                $this->getTestUser(),
                'order01',
                'reservation01',
                $this->getTestCart(),
                $this->getTestStore(),
                $this->getTestContactPreferences(),
                $paymentInfo
            ));
        $this->assertIsBool($result);
    }

    public function testProcessFinancedOrder() : void
    {
        $taxId = '06-0219-0901';
        $clientInfo = static::getClient()->getUserCreditInfo($taxId);
        $cart = $this->getTestCart();
        $promotion = static::getClient()->getFinancialPromotions($clientInfo, $cart)[0];
        $scenario = static::getClient()->getFinancialScenarios($clientInfo, $promotion->getId(), $cart)[0];
        $paymentInfo = \Wakup\PaymentInfo::onCredit($promotion, $scenario, $clientInfo);
        $result = static::getClient()->processOrder(
            new \Wakup\Order(
                $this->getTestUser($taxId),
                'order01',
                'reservation01',
                $this->getTestCart(),
                $this->getTestStore(),
                $this->getTestContactPreferences(),
                $paymentInfo
            ));
        $this->assertIsBool($result);
    }

    public function testCompleteCreditCardCentralOrder() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_CENTRAL;
        $taxId = '06-0219-0901';
        $store = $this->getTestStore('C002');
        $user = $this->getTestUser($taxId);
        $cart = $this->getTestCart();
        $reservationId = static::getClient()->reserveOrderStock($orderType,  $store, $cart);
        $reservationResult = static::getClient()->confirmOrderStockReservation($orderType, $reservationId, $cart);

        $paymentInfo = \Wakup\PaymentInfo::creditCard('1200540043', '01452841');
        $result = static::getClient()->processOrder(
            new \Wakup\Order(
                $user,
                '20190605/02',
                $reservationId,
                $cart,
                $store,
                $this->getTestContactPreferences(),
                $paymentInfo
            ));
        $this->assertIsBool($result);
    }

    public function testCompleteCreditCardStoreOrder() : void
    {
        $orderType = \Wakup\Client::ORDER_TYPE_STORE;
        $taxId = '06-0219-0901';
        $cart = $this->getTestCart();
        $stores = static::getClient()->getNearestStoresStock($cart, 10.0160092, -84.2173331, 50);
        foreach ($stores as $storeStock) {
            $valid = true;
            # Find a store with enough stock
            foreach ($storeStock->getItems() as $skuStock) {
                if ($skuStock->getStock() == 0) {
                    foreach ($cart->getProducts() as $cartProduct) {
                        if ($cartProduct->getSku() == $skuStock->getSku()) {
                            $valid = $valid && $cartProduct->getCount() <= $skuStock->getStock();
                            break;
                        }
                    }
                    if (!$valid) break;
                }
            }
            if ($valid) {
                $store = $storeStock->getStore();
                break;
            }

        }
        if ($store == null) {
            throw new Exception('Not enough stock found for cart');
        }
        $user = $this->getTestUser($taxId);
        $reservationId = static::getClient()->reserveOrderStock($orderType,  $store, $cart);
        $reservationResult = static::getClient()->confirmOrderStockReservation($orderType, $reservationId, $cart);

        $paymentInfo = \Wakup\PaymentInfo::creditCard('1200540043', '01452841');
        $result = static::getClient()->processOrder(
            new \Wakup\Order(
                $user,
                'orderTest01',
                $reservationId,
                $cart,
                $store,
                $this->getTestContactPreferences(),
                $paymentInfo
            ));
        $this->assertIsBool($result);
    }

    // Private helper methods
    private function getTestStore(string $storeId = 'C002'): \Wakup\Store
    {
        return new \Wakup\Store($storeId, '1001', 'Shop name', 'Address', '11801',
            'San José', 'San José', 'Costa Rica', '4032-4703', 10.0160092, -84.2173331);
    }

    private function getTestCartProduct(string $sku = '100331') : \Wakup\CartProduct
    {
        $warranty = new \Wakup\WarrantyPlan($sku, 12, 'Extragarantia', 100000);
        return new \Wakup\CartProduct($sku, 10000, 13, rand(1, 5), $warranty);
    }

    private function getTestCart($skuArray = ['145326']) : \Wakup\Cart
    {
        $products = [];
        foreach ($skuArray as $sku) {
            array_push($products, $this->getTestCartProduct($sku));
        }
        return new \Wakup\Cart($products);
    }

    private function getTestContactPreferences() : \Wakup\ContactPreferences
    {
        return new \Wakup\ContactPreferences(false, false, true, 'testemail@mail.com', '8324-8614');
    }

    private function getTestUser($tax_id='01-0730-0179') : \Wakup\User
    {
        return new \Wakup\User($tax_id, \Wakup\User::ID_TYPE_TAX_ID,
            'Ana', 'Isabel', 'Ramirez', 'Ramirez',
            'pruebas09@gmail.com');
    }
}