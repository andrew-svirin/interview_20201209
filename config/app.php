<?php

// Configurations for the application.

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;
use AndrewSvirin\Interview\Adapters\Db\MySqlAdapter;
use AndrewSvirin\Interview\App;
use AndrewSvirin\Interview\Controllers\AirplaneController;
use AndrewSvirin\Interview\Controllers\SiteController;
use AndrewSvirin\Interview\Factories\ApiResponseFactory;
use AndrewSvirin\Interview\Factories\Stream\InputStreamFactory;
use AndrewSvirin\Interview\Factories\Stream\InputStreamFactoryInterface;
use AndrewSvirin\Interview\Factories\Stream\JsonStreamFactory;
use AndrewSvirin\Interview\Factories\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Factories\RequestFactory;
use AndrewSvirin\Interview\Factories\ResponseFactory;
use AndrewSvirin\Interview\Factories\Stream\StreamFactory;
use AndrewSvirin\Interview\Factories\UriFactory;
use AndrewSvirin\Interview\Services\ApiServer;
use AndrewSvirin\Interview\Services\DbClient;
use AndrewSvirin\Interview\Services\Router;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
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
        App::class,
        DbAdapterInterface::class => MySqlAdapter::class,
        DbClient::class,
        ApiServer::class,
        UriFactoryInterface::class => UriFactory::class,
        RequestFactoryInterface::class => RequestFactory::class,
        ResponseFactoryInterface::class => ResponseFactory::class,
        StreamFactoryInterface::class => StreamFactory::class,
        JsonStreamFactoryInterface::class => JsonStreamFactory::class,
        InputStreamFactoryInterface::class => InputStreamFactory::class,
        ApiResponseFactory::class,
        Router::class,
        SiteController::class,
        AirplaneController::class,
    ],

    // Routes those accessible from router.
    // example: 'any/route' => ['GET|POST|DELETE|PUT|PATCH|OPTIONS' => ['ControllerName', 'actionName']],
    // TODO: Allow to pass in ControllerName class path.
    'routes' => [
        'api/version' => [
            'GET' => ['Site', 'version'],
        ],
        'api/airplanes' => [
            'POST' => ['Airplane', 'create'],
        ],
    ],

    // Namespace uses for server recognize controller without trailing slash.
    'default_controller_namespace' => 'AndrewSvirin\Interview\Controllers',
];

return $config;