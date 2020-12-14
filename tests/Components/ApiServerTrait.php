<?php

namespace AndrewSvirin\Interview\Tests\Components;

use AndrewSvirin\Interview\App;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Helpers\ArrHelper;
use AndrewSvirin\Interview\Tests\BaseTestCase;
use Psr\Container\ContainerInterface;
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
     * Assert response json.
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

    /**
     * Assert response json has values.
     *
     * @param ResponseInterface $response
     * @param array $values
     */
    protected function assertResponseJsonHas(ResponseInterface $response, array $values)
    {
        $json = json_decode($response->getBody(), true);

        $has = true;
        foreach ($values as $key => $value) {
            $this->assertArrayHasKey($key, $json);
            $this->assertEquals($value, $json[$key]);
        }

        $this->assertTrue($has);
    }

    /**
     * Get json value.
     *
     * @param ResponseInterface $response
     * @param string|null $key Dot syntax path.
     *
     * @return mixed|null
     */
    protected function getJson(ResponseInterface $response, string $key = null)
    {
        $json = json_decode($response->getBody(), true);

        // Check if json is empty.
        if (empty($json)) {
            return null;
        }

        // Check if key path is empty.
        if (null === $key) {
            return $json;
        }

        return ArrHelper::get($json, $key);
    }
}
