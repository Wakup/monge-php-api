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

final class WakupRequestsTest extends ParentRequestsTest
{

    public function testGetWakupPaginatedAttributesValue() : void
    {
        $pagination = static::getClient()->getPaginatedAttributes();
        $this->assertInstanceOf(Wakup\PaginatedAttributes::class, $pagination);
        foreach ($pagination->getAttributes() as $attribute) {
            $this->assertIsString($attribute->getIdentifier());
            $this->assertIsString($attribute->getName());
            $this->assertIsString($attribute->getType());
            $this->assertIsBool($attribute->getVisible());
            $this->assertIsBool($attribute->getFilterable());
            $this->assertIsBool($attribute->getTranslatable());
            $this->assertIsBool($attribute->getMandatory());
        }
    }

    public function testGetWakupPaginatedCategoriesValue() : void
    {
        $pagination = static::getClient()->getPaginatedCategories();
        $this->assertInstanceOf(Wakup\PaginatedCategories::class, $pagination);
        foreach ($pagination->getCategories() as $category) {
            $this->assertIsString($category->getIdentifier());
            $this->assertIsString($category->getName());
            $this->assertIsArray($category->getAttributes());
            foreach ($category->getAttributes() as $categoryAttribute) {
                $this->assertIsString($categoryAttribute->getIdentifier());
                $this->assertIsInt($categoryAttribute->getOrder());
            }
        }
    }

    public function testGetWakupPaginatedProductsValue() : void
    {
        $lastUpdate = new DateTime(date('Y-m-d H:i:s', strtotime('-1 day')));
        $pagination = static::getClient()->getPaginatedProducts($lastUpdate, 0, 100);
        $this->assertInstanceOf(\Wakup\PaginatedProducts::class, $pagination);
        foreach ($pagination->getProducts() as $product) {
            $this->assertInstanceOf(\Wakup\Product::class, $product);
            $this->assertIsString($product->getSku());
            $info = $product->getInfo();
            if ($info != null) {
                $this->assertInstanceOf(\Wakup\ProductInfo::class, $info);
                $this->assertIsString($info->getName());
                #$this->assertIsString($info->getDescription());
                $this->assertIsString($info->getShortDescription());
                $this->assertIsArray($info->getShortDescriptionItems());
                $this->assertIsString($info->getCategory());
                $this->assertIsArray($info->getRelatedProducts());
                $this->assertIsArray($info->getRequiredProducts());
                $this->assertIsBool($info->isActive());
                $this->assertIsBool($info->hasWarrantyPlans());
                $this->assertIsBool($info->isVisibleIndividually());
            }
        }
    }

    public function testGetWakupNearestStoresValue() : void
    {
        $pagination = static::getClient()->getNearestStores(9, -82, 0, 10);
        $this->assertInstanceOf(\Wakup\PaginatedStores::class, $pagination);
        $lastDistance = 0;
        foreach ($pagination->getStores() as $store) {
            $this->assertInstanceOf(\Wakup\Store::class, $store);
            $this->assertIsString($store->getSku());
            $this->assertIsString($store->getName());
            $this->assertIsString($store->getAddress());
            $this->assertIsString($store->getPostCode());
            $this->assertIsString($store->getRegion());
            $this->assertIsString($store->getCountry());
            $this->assertIsString($store->getCity());
            $this->assertIsString($store->getPhoneNumber());
            $this->assertIsFloat($store->getLatitude());
            $this->assertIsFloat($store->getLongitude());
            $this->assertIsFloat($store->getDistanceInKms());
            $this->assertIsFloat($store->getDistanceInMiles());
            $this->assertIsInt($store->getShipmentTime());
            # Warehouse ID should be empty at this point
            $this->assertNull($store->getWarehouseId());
            # Should be ordered by distance
            $this->assertGreaterThanOrEqual($lastDistance, $store->getDistanceInMiles());
            $lastDistance = $store->getDistanceInMiles();
        }
    }

}