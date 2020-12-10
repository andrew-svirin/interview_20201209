<?php

// Initializing environment.

// Definition of base dir.
define('BASE_DIR', dirname(__DIR__));

// Load dependencies.
require_once __DIR__ . '/../vendor/autoload.php';

$config = \AndrewSvirin\Interview\Factories\ConfigFactory::produceFromFile();
$registry = \AndrewSvirin\Interview\Factories\ServiceRegistryFactory::produceFromArray($config->get('services'));
$container = new \AndrewSvirin\Interview\Services\Container($config, $registry);

return $container;
