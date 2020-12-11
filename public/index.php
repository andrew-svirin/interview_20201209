<?php

// Enter point for application.

use AndrewSvirin\Interview\App;

$container = require_once __DIR__ . '/../bootstrap/app.php';

// Run application.
/* @var $app App */
$app = $container->get(App::class);

$app->run();
