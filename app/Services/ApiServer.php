<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Exceptions\ControllerActionArgumentIncorrectException;
use AndrewSvirin\Interview\Exceptions\ControllerActionNotFoundException;
use AndrewSvirin\Interview\Exceptions\RouteNotFoundException;
use AndrewSvirin\Interview\Requests\ApiRequest;
use AndrewSvirin\Interview\Responses\Response;
use LogicException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(Router $router, Config $config, ContainerInterface $container)
    {
        $this->router = $router;
        $this->config = $config;
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
        if (!($parameterClass = $parameter->getClass()) ||
            !is_subclass_of($parameterClass->getName(), ApiRequest::class)
        ) {
            throw new ControllerActionArgumentIncorrectException(
                'Allowed argument with instance of ApiRequest.'
            );
        }

        // Create new instance of api request.
        /* @var $apiRequest ApiRequest */
        $apiRequest = $parameter->getClass()->newInstanceArgs([
            $request->getMethod(),
            $request->getUri(),
            $request->getBody()
        ]);

        return $apiRequest; // @phpstan-ignore-line
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
        return new Response();
    }
}
