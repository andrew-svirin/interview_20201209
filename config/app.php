<?php

// Configurations for the application.

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;
use AndrewSvirin\Interview\Adapters\Db\MySqlAdapter;

$config = [
    'database' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST'),
        'name' => getenv('DB_NAME'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'port' => 3306,
    ],

    'services' => [
        DbAdapterInterface::class => MySqlAdapter::class,
    ],
];

return $config;