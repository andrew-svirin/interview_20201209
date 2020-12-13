<?php

namespace AndrewSvirin\Interview\Factories\Http;

use AndrewSvirin\Interview\Requests\ApiRequest;
use LogicException;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Produce api request.
 */
class ApiRequestFactory
{

    /**
     * Create API request.
     *
     * @param string $className
     * @param RequestInterface $request
     *
     * @return ApiRequest
     * @throws ReflectionException
     */
    public function createApiRequest(string $className, RequestInterface $request): ApiRequest
    {
        if (!class_exists($className)) {
            throw new LogicException(sprintf('Request class `%s` not found.', $className));
        }
        $class = new ReflectionClass($className);

        /* @var $apiRequest ApiRequest */
        $apiRequest = $class->newInstanceArgs([
            $request->getMethod(),
            $request->getUri()
        ]);

        return $apiRequest; // @phpstan-ignore-line
    }
}
