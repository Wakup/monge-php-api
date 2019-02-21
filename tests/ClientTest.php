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

    public function testGetPaginatedAttributesValue() : void
    {
        $client = new Wakup\Client();
        $this->assertInstanceOf(
            \Wakup\PaginatedAttributes::class,
            $client->getPaginatedAttributes()
        );
    }

    public function testGetPaginatedCategoriesValue() : void
    {
        $client = new Wakup\Client();
        $this->assertInstanceOf(
            \Wakup\PaginatedCategories::class,
            $client->getPaginatedCategories()
        );
    }

    public function testGetPaginatedProductsValue() : void
    {
        $client = new Wakup\Client();
        $this->assertInstanceOf(
            \Wakup\PaginatedProducts::class,
            $client->getPaginatedProducts()
        );
    }

}