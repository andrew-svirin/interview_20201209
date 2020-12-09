<?php

// Initializing environment.

// Definition of base dir.
define('BASE_DIR', dirname(__DIR__));

// Load dependencies.
require_once __DIR__ . '/../vendor/autoload.php';

$registry = new \AndrewSvirin\Interview\Services\ServiceRegistry();
$container = new \AndrewSvirin\Interview\Services\Container($registry);

return $container;
