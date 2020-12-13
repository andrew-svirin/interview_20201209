<?php

namespace AndrewSvirin\Interview;

use AndrewSvirin\Interview\Factories\Http\Stream\InputStreamFactoryInterface;
use AndrewSvirin\Interview\Services\ApiServer;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
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
     * Prepare request and output response.
     *
     * @throws Exceptions\ControllerActionArgumentIncorrectException
     * @throws Exceptions\ControllerActionNotFoundException
     * @throws Exceptions\RouteNotFoundException
     * @throws ReflectionException
     */
    public function run(): void
    {
        // Get $_SERVER data and STDIN stream and create request.
        $body = $this->inputStreamFactory->createStreamFromInput();
        $response = $this->resolveResponse($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $body);

        // Output response.
        http_response_code($response->getStatusCode());
        echo $response->getBody();
    }

    /**
     * Create Request and handle it to resolve response.
     *
     * @param string $method
     * @param string $uri
     * @param StreamInterface $body
     *
     * @return ResponseInterface
     * @throws Exceptions\ControllerActionArgumentIncorrectException
     * @throws Exceptions\ControllerActionNotFoundException
     * @throws Exceptions\RouteNotFoundException
     * @throws ReflectionException
     */
    public function resolveResponse(string $method, string $uri, StreamInterface $body)
    {
        // Create request.
        $request = $this->requestFactory->createRequest($method, $uri);
        $request->withBody($body);

        $response = $this->apiServer->handleRequest($request);

        return $response;
    }
}
