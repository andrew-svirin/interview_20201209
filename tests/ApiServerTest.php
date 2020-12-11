<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Services\ApiServer;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Tests for @see \AndrewSvirin\Interview\Services\ApiServer
 *
 * @group api-server
 */
class ApiServerTest extends BaseTestCase
{

    /**
     * Trigger controller action `site.version` by request.
     * @group api-server-handle-request
     */
    public function testHandleRequest()
    {
        /* @var $apiServer ApiServer */
        $apiServer = $this->container->get(ApiServer::class);

        /* @var $requestFactory RequestFactoryInterface */
        $requestFactory = $this->container->get(RequestFactoryInterface::class);
        $request = $requestFactory->createRequest('GET', 'api/version');

        $response = $apiServer->handleRequest($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
