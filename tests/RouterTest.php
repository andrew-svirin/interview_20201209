<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Services\Router;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Tests for @see \AndrewSvirin\Interview\Services\Router
 *
 * @group router
 */
class RouterTest extends BaseTestCase
{

    /**
     * Get controller action `site.version` by request.
     * @group router-get-controller-action
     */
    public function testGetControllerAction()
    {
        /* @var $router Router */
        $router = $this->container->get(Router::class);

        /* @var $requestFactory RequestFactoryInterface */
        $requestFactory = $this->container->get(RequestFactoryInterface::class);
        $request = $requestFactory->createRequest('GET', 'api/version');

        $this->assertEquals(['Site', 'version'], $router->getControllerAction($request));
    }
}
