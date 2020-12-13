<?php

namespace AndrewSvirin\Interview\Tests\Components;

use AndrewSvirin\Interview\App;
use AndrewSvirin\Interview\Factories\Http\ResponseFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Tests\BaseTestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Include api requests functionality to tests.
 *
 * @mixin BaseTestCase
 *
 * @property ContainerInterface $container
 *
 */
trait ApiServerTrait
{

    /**
     * Make request.
     *
     * @param string $method
     * @param string $uri
     * @param mixed|null $json Can be encoded string or encoding able data.
     *
     * @return ResponseInterface
     */
    protected function request(string $method, string $uri, $json = null): ResponseInterface
    {
        /* @var $app App */
        $app = $this->container->get(App::class);

        // Simulate request.
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        // Put json to the body stream.
        if (!is_string($json)) {
            /* @var $inputStreamFactory JsonStreamFactoryInterface */
            $inputStreamFactory = $this->container->get(JsonStreamFactoryInterface::class);
            $body = $inputStreamFactory->createStreamFromJson($json);
        } else {
            /* @var $inputStreamFactory StreamFactoryInterface */
            $inputStreamFactory = $this->container->get(StreamFactoryInterface::class);
            $body = $inputStreamFactory->createStream($json);
        }

        $response = $app->resolveResponse($method, $uri, $body);

        return $response;
    }

    /**
     * Assert response body.
     *
     * @param ResponseInterface $response
     * @param array $json
     */
    protected function assertResponseJson(ResponseInterface $response, array $json)
    {
        $this->assertEquals(
            json_encode($json, true),
            $response->getBody(),
            'Failed asserting that response body not equal.'
        );
    }
}
