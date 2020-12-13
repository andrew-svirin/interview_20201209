<?php

namespace AndrewSvirin\Interview;

use AndrewSvirin\Interview\Factories\Http\Stream\InputStreamFactoryInterface;
use AndrewSvirin\Interview\Services\ApiServer;
use Psr\Http\Message\RequestFactoryInterface;
use ReflectionException;

/**
 * Contains application that handles HTTP requests.
 */
class App
{

    /**
     * Request factory.
     *
     * @var RequestFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    /**
     * Input Stream factory.
     *
     * @var InputStreamFactoryInterface
     */
    private InputStreamFactoryInterface $inputStreamFactory;

    /**
     * Api server.
     *
     * @var ApiServer
     */
    private ApiServer $apiServer;

    public function __construct(
        RequestFactoryInterface $requestFactory,
        InputStreamFactoryInterface $inputStreamFactory,
        ApiServer $apiServer
    ) {
        $this->requestFactory = $requestFactory;
        $this->inputStreamFactory = $inputStreamFactory;
        $this->apiServer = $apiServer;
    }

    /**
     * Process request and output response.
     *
     * @throws Exceptions\ControllerActionArgumentIncorrectException
     * @throws Exceptions\ControllerActionNotFoundException
     * @throws Exceptions\RouteNotFoundException
     * @throws ReflectionException
     * @throws Exceptions\ResponseIncorrectException
     */
    public function run(): void
    {
        // Get $_SERVER data and STDIN stream and create request.
        $request = $this->requestFactory->createRequest(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI']
        );

        $body = $this->inputStreamFactory->createStreamFromInput();
        $request->withBody($body);

        $response = $this->apiServer->handleRequest($request);

        // Output response.
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }
}
