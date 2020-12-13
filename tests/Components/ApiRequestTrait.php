<?php

namespace AndrewSvirin\Interview\Tests\Components;

use AndrewSvirin\Interview\Factories\Http\ApiRequestFactory;
use AndrewSvirin\Interview\Factories\Http\Stream\JsonStreamFactoryInterface;
use AndrewSvirin\Interview\Requests\ApiRequest;
use AndrewSvirin\Interview\Tests\BaseTestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * Include api requests functionality to tests.
 *
 * @mixin BaseTestCase
 *
 * @property ContainerInterface $container
 *
 */
trait ApiRequestTrait
{

    /**
     * Produce API Request.
     * It is factory method for testing.
     *
     * @param string $className
     * @param string $method
     * @param string $uri
     * @param null $json
     *
     * @return ApiRequest
     */
    protected function createApiRequest(string $className, string $method, string $uri, $json = null): ApiRequest
    {
        /* @var $requestFactory RequestFactoryInterface */
        $requestFactory = $this->container->get(RequestFactoryInterface::class);
        /* @var $apiRequestFactory ApiRequestFactory */
        $apiRequestFactory = $this->container->get(ApiRequestFactory::class);

        $apiRequest = $apiRequestFactory->createApiRequest(
            $className,
            $requestFactory->createRequest($method, $uri)
        );

        /* @var $jsonStreamFactory JsonStreamFactoryInterface */
        $jsonStreamFactory = $this->container->get(JsonStreamFactoryInterface::class);

        if (null !== $json) {
            $apiRequest->withBody($jsonStreamFactory->createStreamFromJson($json));
        }

        return $apiRequest;
    }
}
