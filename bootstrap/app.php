<?php

// Initializing environment.

use AndrewSvirin\Interview\Factories\ConfigFactory;
use AndrewSvirin\Interview\Factories\ServiceRegistryFactory;
use AndrewSvirin\Interview\Services\Container;

// Definition of base dir.
define('BASE_DIR', dirname(__DIR__));

// Load dependencies.
require_once __DIR__ . '/../vendor/autoload.php';

// Build container.
$config = ConfigFactory::createFromFile();
$registry = ServiceRegistryFactory::createFromArray($config->get('services'));
$container = new Container($config, $registry);

return $container;
