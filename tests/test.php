<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

echo \Wakup\Greetings::sayHelloWorld();

$wakupClient = new \Wakup\Client();
$attributes = $wakupClient->getPaginatedAttributes(0, 100)->getAttributes();
$attribute = $attributes[0];
echo $attribute->getName();