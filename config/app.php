<?php

// Configurations for the application.

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;
use AndrewSvirin\Interview\Adapters\Db\MySqlAdapter;
use AndrewSvirin\Interview\App;
use AndrewSvirin\Interview\Controllers\AirplaneController;
use AndrewSvirin\Interview\Controllers\SiteController;
use AndrewSvirin\Interview\Controllers\TicketOrderController;
use AndrewSvirin\Interview\EventListeners\SaveTicketOrderTickets;
use AndrewSvirin\Interview\Events\TicketOrderCreated;
use AndrewSvirin\Interview\Facades\AirplaneFacade;
use AndrewSvirin\Interview\Facades\TicketFacade;
use AndrewSvirin\Interview\Facades\TicketOrderFacade;
use AndrewSvirin\Interview\Factories\Http\ApiRequestFactory;
use AndrewSvirin\Interview\Factories\Http\ApiResponseFactory;
use AndrewSvirin\Interview\Factories\Http\RequestFactory;
use AndrewSvirin\Interview\Factories\Http\ResponseFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\InputStreamFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\InputStreamFactoryInterface;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Factories\Http\Stream\StreamFactory;
use AndrewSvirin\Interview\Factories\Http\UriFactory;
use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Gateways\Db\AirplaneTableGateway;
use AndrewSvirin\Interview\Gateways\Db\TicketOrderTableGateway;
use AndrewSvirin\Interview\Gateways\Db\TicketTableGateway;
use AndrewSvirin\Interview\Repositories\AirplaneRepository;
use AndrewSvirin\Interview\Repositories\TicketOrderRepository;
use AndrewSvirin\Interview\Repositories\TicketRepository;
use AndrewSvirin\Interview\Services\ApiServer;
use AndrewSvirin\Interview\Services\DbClient;
use AndrewSvirin\Interview\Services\EventDispatcher\EventDispatcher;
use AndrewSvirin\Interview\Services\Router;
use AndrewSvirin\Interview\Services\Ticket\TicketSitCalculator;
use AndrewSvirin\Interview\Services\Validator\ApiRequestValidator;
use AndrewSvirin\Interview\Services\Validator\Validator;
use AndrewSvirin\Interview\Validators\MaxValueValidator;
use AndrewSvirin\Interview\Validators\RequiredValueValidator;
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

    // TODO: services can be auto wired.
    // Services those accessible from container.
    // example: 'alias' => 'className',
    // example: 'interfaceName' => 'className',
    // example: 'className', // is equal to 'className' => 'className'
    'services' => [
        App::class,
        DbAdapterInterface::class => MySqlAdapter::class,
        DbClient::class,
        ApiServer::class,
        Router::class,
        ModelFactory::class,
        EventDispatcher::class,
        TicketSitCalculator::class,
        // Http Services.
        UriFactoryInterface::class => UriFactory::class,
        RequestFactoryInterface::class => RequestFactory::class,
        ResponseFactoryInterface::class => ResponseFactory::class,
        StreamFactoryInterface::class => StreamFactory::class,
        JsonStreamFactoryInterface::class => JsonStreamFactory::class,
        InputStreamFactoryInterface::class => InputStreamFactory::class,
        ApiRequestFactory::class,
        ApiResponseFactory::class,
        // Validator services.
        Validator::class,
        ApiRequestValidator::class,
        MaxValueValidator::class,
        RequiredValueValidator::class,
        // Controller services.
        SiteController::class,
        AirplaneController::class,
        TicketOrderController::class,
        // Gateway services.
        AirplaneTableGateway::class,
        TicketOrderTableGateway::class,
        TicketTableGateway::class,
        // Repository services.
        AirplaneRepository::class,
        TicketOrderRepository::class,
        TicketRepository::class,
        // Facade services.
        AirplaneFacade::class,
        TicketOrderFacade::class,
        TicketFacade::class,
        // Event listeners.
        SaveTicketOrderTickets::class
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
        'api/ticket-orders' => [
            'POST' => ['TicketOrder', 'create'],
        ],
    ],

    // Subscriptions event listeners on events for event dispatcher.
    'event_subscriptions' => [
        TicketOrderCreated::class => [
            SaveTicketOrderTickets::class,
        ],
    ],

    // Namespace uses for server recognize controller without trailing slash.
    'default_controller_namespace' => 'AndrewSvirin\Interview\Controllers',
];

return $config;