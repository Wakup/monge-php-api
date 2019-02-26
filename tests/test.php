<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

$wakupClient = new \Wakup\Client();
var_dump($wakupClient->getPaginatedAttributes(0, 2));
var_dump($wakupClient->getPaginatedCategories(0, 1000)->getCategories()[0]);
$products = $wakupClient->getPaginatedProducts(new DateTime('2018-12-30 23:21:46'), 0, 2);
var_dump($products);
foreach ($products->getProducts() as $product) {
    var_dump($product);
}