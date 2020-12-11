<?php

namespace AndrewSvirin\Interview\Tests\Components;

use AndrewSvirin\Interview\App;
use AndrewSvirin\Interview\Factories\ResponseFactory;
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
trait ApiTrait
{

    /**
     * Make request.
     *
     * @param string $method
     * @param string $uri
     * @param string|null $body
     *
     * @return ResponseInterface
     */
    protected function request(string $method, string $uri, $body = null): ResponseInterface
    {
        /* @var $app App */
        $app = $this->container->get(App::class);

        // Simulate request.
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $uri;

        // Convert body to string by json encoding.
        if (!is_string($body)) {
            $requestBody = json_encode($body);
        } else {
            $requestBody = $body;
        }
        // Put body into request.
        $stream = fopen('php://input', 'w');
        fwrite($stream, $requestBody);
        fclose($stream);

        // Run application and catch response body.
        ob_start();
        $app->run();
        $responseBody = ob_get_contents();
        ob_end_clean();

        // Simulate response.
        $responseCode = http_response_code();

        /* @var $responseFactory ResponseFactory */
        $responseFactory = $this->container->get(ResponseFactoryInterface::class);
        $response = $responseFactory->createResponse($responseCode, '');

        /* @var $streamFactory StreamFactoryInterface */
        $streamFactory = $this->container->get(StreamFactoryInterface::class);
        $body = $streamFactory->createStream($responseBody);
        $response->withBody($body);

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
