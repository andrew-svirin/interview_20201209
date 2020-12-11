<?php

// Configurations for the application.

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;
use AndrewSvirin\Interview\Adapters\Db\MySqlAdapter;
use AndrewSvirin\Interview\Controllers\SiteController;
use AndrewSvirin\Interview\Factories\RequestFactory;
use AndrewSvirin\Interview\Factories\UriFactory;
use AndrewSvirin\Interview\Services\ApiClient;
use AndrewSvirin\Interview\Services\ApiServer;
use AndrewSvirin\Interview\Services\DbClient;
use AndrewSvirin\Interview\Services\Router;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

$config = [
    'database' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST'),
        'name' => getenv('DB_NAME'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'port' => 3306,
    ],

    // Services those accessible from container.
    // example: 'alias' => 'className',
    // example: 'interfaceName' => 'className',
    // example: 'className', // is equal to 'className' => 'className'
    'services' => [
        DbAdapterInterface::class => MySqlAdapter::class,
        DbClient::class,
        ApiServer::class,
        ApiClient::class,
        UriFactoryInterface::class => UriFactory::class,
        RequestFactoryInterface::class => RequestFactory::class,
        Router::class,
        SiteController::class,
    ],

    // Routes those accessible from router.
    // example: 'any/route' => ['GET|POST|DELETE|PUT|PATCH|OPTIONS' => ['ControllerName', 'actionName']],
    // TODO: Allow to pass in ControllerName class path.
    'routes' => [
        'api/version' => [
            'GET' => ['Site', 'version'],
        ],
    ],

    // Namespace uses for server recognize controller without trailing slash.
    'default_controller_namespace' => 'AndrewSvirin\Interview\Controllers',
];

return $config;