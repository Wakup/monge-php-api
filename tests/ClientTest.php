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

    public function testGetPaginatedAttributesValue() : void
    {
        $this->assertInstanceOf(
            \Wakup\PaginatedAttributes::class,
            static::getClient()->getPaginatedAttributes()
        );
    }

    public function testGetPaginatedCategoriesValue() : void
    {
        $this->assertInstanceOf(
            \Wakup\PaginatedCategories::class,
            static::getClient()->getPaginatedCategories()
        );
    }

    public function testGetPaginatedProductsValue() : void
    {
        $this->assertInstanceOf(
            \Wakup\PaginatedProducts::class,
            static::getClient()->getPaginatedProducts()
        );
    }

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

        $results = static::getClient()->getFinancialScenarios(145896, 302, 1,
            ['135360'], [21900], [], []);
        $this->assertIsArray($results);
        foreach ($results as $scenario) {
            $this->assertInstanceOf(\Wakup\FinancialScenario::class, $scenario);
        }
    }

}