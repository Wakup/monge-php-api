<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

$wakupClient = new \Wakup\Client();
$pagination = $wakupClient->getPaginatedAttributes(0, 2);
$attributes = $pagination->getAttributes();
var_dump($pagination);