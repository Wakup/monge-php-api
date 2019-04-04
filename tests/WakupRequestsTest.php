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

}