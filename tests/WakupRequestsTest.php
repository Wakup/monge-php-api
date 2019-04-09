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

final class WakupRequestsTest extends TestCase
{

    private static function getClient() : \Wakup\Client
    {
        return new Wakup\Client();
    }

    public function testGetWakupPaginatedAttributesValue() : void
    {
        $this->assertInstanceOf(
            Wakup\PaginatedAttributes::class,
            static::getClient()->getPaginatedAttributes()
        );
    }

    public function testGetWakupPaginatedCategoriesValue() : void
    {
        $this->assertInstanceOf(
            Wakup\PaginatedCategories::class,
            static::getClient()->getPaginatedCategories()
        );
    }

    public function testGetWakupPaginatedProductsValue() : void
    {
        $pagination = static::getClient()->getPaginatedProducts();
        $this->assertInstanceOf(\Wakup\PaginatedProducts::class, $pagination);
        foreach ($pagination->getProducts() as $product) {
            $this->assertInstanceOf(\Wakup\Product::class, $product);
            $this->assertIsString($product->getSku());
        }
    }

    public function testGetWakupNearestStoresValue() : void
    {
        $pagination = static::getClient()->getNearestStores(9, -82, 0, 10);
        $this->assertInstanceOf(\Wakup\PaginatedStores::class, $pagination);
        foreach ($pagination->getStores() as $store) {
            $this->assertInstanceOf(\Wakup\Store::class, $store);
            $this->assertIsString($store->getSku());
            $this->assertIsString($store->getWarehouseId());
            $this->assertIsString($store->getName());
            $this->assertIsString($store->getAddress());
            $this->assertIsFloat($store->getLatitude());
            $this->assertIsFloat($store->getLongitude());
        }
    }

}