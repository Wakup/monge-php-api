<?php
declare(strict_types=1);

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ParentRequestsTest extends TestCase {

    static function getClient() : \Wakup\Client
    {
        $logger = new Logger('TEST');
        // Now add some handlers
        $logger->pushHandler(new StreamHandler(getcwd().'/my_app.log', Logger::ERROR));
        return new Wakup\Client($logger);
    }

}