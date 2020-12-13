<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Exceptions\ControllerActionArgumentIncorrectException;
use AndrewSvirin\Interview\Exceptions\ControllerActionNotFoundException;
use AndrewSvirin\Interview\Exceptions\RouteNotFoundException;
use AndrewSvirin\Interview\Factories\Http\ApiRequestFactory;
use AndrewSvirin\Interview\Factories\Http\ApiResponseFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Requests\ApiRequest;
use AndrewSvirin\Interview\Responses\ApiResponse;
use LogicException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Receive request and call controller action.
 */
class ApiServer
{

    /**
     * Router.
     *
     * @var Router
     */
    private Router $router;

    /**
     * Application configuration.
     *
     * @var Config
     */
    private Config $config;

    /**
     * Response factory.
     *
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * Stream factory.
     *
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    /**
     * Json Stream factory.
     *
     * @var JsonStreamFactoryInterface
     */
    private JsonStreamFactoryInterface $jsonStreamFactory;

    /**
     * ApiRequest Factory.
     *
     * @var ApiRequestFactory
     */
    private ApiRequestFactory $apiRequestFactory;

    /**
     * ApiResponse Factory.
     *
     * @var ApiResponseFactory
     */
    private ApiResponseFactory $apiResponseFactory;

    /**
     * Container for get controller service.
     *
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(
        Router $router,
        Config $config,
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        JsonStreamFactoryInterface $jsonStreamFactory,
        ApiRequestFactory $apiRequestFactory,
        ApiResponseFactory $apiResponseFactory,
        ContainerInterface $container
    ) {
        $this->router = $router;
        $this->config = $config;
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->jsonStreamFactory = $jsonStreamFactory;
        $this->apiRequestFactory = $apiRequestFactory;
        $this->apiResponseFactory = $apiResponseFactory;
        $this->container = $container;
    }

    /**
     * Handle request.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws ControllerActionArgumentIncorrectException
     * @throws ControllerActionNotFoundException
     * @throws ReflectionException
     * @throws RouteNotFoundException
     */
    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        [$controllerName, $actionName] = $this->router->getControllerAction($request);

        // Prepare controller class path and action method.
        $defaultControllerNamespace = $this->config->get('default_controller_namespace');
        $controllerClass = $controllerName . 'Controller';
        $actionMethod = $actionName . 'Action';
        $controllerClassPath = $defaultControllerNamespace . '\\' . $controllerClass;
        $controller = $this->container->get($controllerClassPath);

        // Check controller action method.
        if (!method_exists($controller, $actionMethod)) {
            throw new ControllerActionNotFoundException(sprintf(
                'Controller action `%s:%s` not found.',
                $controllerClassPath,
                $actionMethod
            ));
        }

        $apiRequest = $this->resolveRequest($controllerClassPath, $actionMethod, $request);
        // Call Controller action method.
        $apiResponse = $controller->{$actionMethod}($apiRequest);

        $response = $this->resolveResponse($apiResponse);

        return $response;
    }

    /**
     * Use reflection to build api request instance.
     *
     * @param string $controllerClassPath
     * @param string $actionMethod
     * @param RequestInterface $request
     *
     * @return ApiRequest
     * @throws ReflectionException
     * @throws ControllerActionArgumentIncorrectException
     */
    private function resolveRequest(
        string $controllerClassPath,
        string $actionMethod,
        RequestInterface $request
    ): ?ApiRequest {
        // If registry service is class name.
        if (!class_exists($controllerClassPath)) {
            throw new LogicException('Controller class not found.');
        }
        $class = new ReflectionClass($controllerClassPath);
        $method = $class->getMethod($actionMethod);
        $parameters = $method->getParameters();

        // Check that action method expect only one argument of request.
        if (1 > count($parameters)) {
            throw new ControllerActionArgumentIncorrectException(
                'Allowed for 1 argument.'
            );
        }

        // Return null if not need to return api request.
        if (empty($parameters)) {
            return null;
        }

        $parameter = reset($parameters);

        // Check that argument is child of api request.
        if (!($parameterClass = $parameter->getClass())) {
            throw new ControllerActionArgumentIncorrectException('Allowed argument is instance of class.');
        }

        // Create new instance of api request.
        $apiRequest = $this->apiRequestFactory->createApiRequest($parameter->getClass()->getName(), $request);
        // Populate body if it exists.
        if (!empty($request->getBody())) {
            $apiRequest->withBody($request->getBody());
        }

        return $apiRequest;
    }

    /**
     * Convert api response to http response.
     *
     * @param mixed $apiResponse
     *
     * @return ResponseInterface
     */
    private function resolveResponse($apiResponse): ResponseInterface
    {
        if ($apiResponse instanceof ApiResponse) {
            $apiResponseInstance = $apiResponse;
        } else {
            $apiResponseInstance = $this->apiResponseFactory->createApiResponse(200, '');
            $body = $this->jsonStreamFactory->createStreamFromJson($apiResponse);
            $apiResponseInstance->withBody($body);
        }

        $response = $this->responseFactory->createResponse(
            $apiResponseInstance->getStatusCode(),
            $apiResponseInstance->getReasonPhrase()
        );
        $response->withBody($apiResponseInstance->getBody());

        return $response;
    }
}
