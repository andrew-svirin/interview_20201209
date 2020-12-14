<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Exceptions\RouteNotFoundException;
use Psr\Http\Message\RequestInterface;

/**
 * Implements mapping between request and controller action.
 */
class Router
{

    /**
     * Application Config.
     * @var Config
     */
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get from routes controller and action.
     *
     * @param RequestInterface $request
     *
     * @return array Controller and action.
     * @throws RouteNotFoundException
     */
    public function getControllerAction(RequestInterface $request): array
    {
        $routes = $this->config->get('routes');

        // Check path.
        if (!($path = $routes[$request->getUri()->getPath()] ?? null)) {
            $q = $request->getUri()->getQuery();
            throw new RouteNotFoundException(sprintf('Path `%s` not found', $request->getUri()->getPath()));
        }

        // Check method.
        if (!($controllerAction = $path[$request->getMethod()] ?? null)) {
            throw new RouteNotFoundException(sprintf('Method `%s` not found', $request->getMethod()));
        }

        // Check controller action.
        if (2 !== count($controllerAction)) {
            throw new RouteNotFoundException('Action controller incorrect.');
        }

        return $controllerAction;
    }
}
