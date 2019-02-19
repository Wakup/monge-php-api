<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

$wakupClient = new \Wakup\Client();
var_dump($wakupClient->getPaginatedAttributes(0, 2));
var_dump($wakupClient->getPaginatedCategories(0, 2));