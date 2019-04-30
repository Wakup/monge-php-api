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

final class UserRequestsTest extends TestCase
{
    const TEST_LOGIN_EMAIL = 'testcasesUser@gmail.com';
    const TEST_LOGIN_NEW_EMAIL = 'secondTestCase@gmail.com';
    const TEST_LOGIN_PASSWORD = 'P@ssword!';
    const TEST_LOGIN_NEW_PASSWORD = 'NewP@ssword!';

    private static function getClient() : \Wakup\Client
    {
        return new Wakup\Client();
    }

    public function testRegisterUser() : void
    {
        $result = static::getClient()->register(self::TEST_LOGIN_EMAIL, self::TEST_LOGIN_PASSWORD);
        $this->assertInstanceOf(\Wakup\AzureUser::class, $result);
        $this->assertIsString($result->getObjectId());
    }

    public function testIsUserRegisteredTrue() : void
    {
        $result = static::getClient()->isUserRegistered(self::TEST_LOGIN_EMAIL);
        $this->assertTrue($result);
    }

    public function testIsUserRegisteredFalse() : void
    {
        $result = static::getClient()->isUserRegistered(self::TEST_LOGIN_NEW_EMAIL);
        $this->assertFalse($result);
    }

    public function testCorrectLogin() : void
    {
        $result = static::getClient()->login(self::TEST_LOGIN_EMAIL, self::TEST_LOGIN_PASSWORD);
        $this->assertTrue($result);
    }

    public function testIncorrectLogin() : void
    {
        $result = static::getClient()->login(self::TEST_LOGIN_EMAIL, self::TEST_LOGIN_NEW_PASSWORD);
        $this->assertFalse($result);
    }

    public function testFindUser() : void
    {
        $result = static::getClient()->findUser(self::TEST_LOGIN_EMAIL);
        $this->assertInstanceOf(\Wakup\AzureUser::class, $result);
        $this->assertIsString($result->getObjectId());
    }

    public function testPasswordChange() : void
    {
        $result = static::getClient()->resetPassword(self::TEST_LOGIN_EMAIL, self::TEST_LOGIN_NEW_PASSWORD);
        $this->assertTrue($result);
    }

    public function testCorrectLoginAfterPasswordChange() : void
    {
        $result = static::getClient()->login(self::TEST_LOGIN_EMAIL, self::TEST_LOGIN_NEW_PASSWORD);
        $this->assertTrue($result);
    }

    public function testEmailChange() : void
    {
        $result = static::getClient()->changeEmail(self::TEST_LOGIN_EMAIL, self::TEST_LOGIN_NEW_EMAIL);
        $this->assertTrue($result);
    }

    public function testCorrectLoginAfterEmailChange() : void
    {
        $result = static::getClient()->login(self::TEST_LOGIN_NEW_EMAIL, self::TEST_LOGIN_NEW_PASSWORD);
        $this->assertTrue($result);
    }

    public function testUserDelete() : void
    {
        $result = static::getClient()->deleteUser(self::TEST_LOGIN_NEW_EMAIL);
        $this->assertTrue($result);
    }

}