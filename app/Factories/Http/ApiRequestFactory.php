<?php

namespace AndrewSvirin\Interview\Factories\Http;

use AndrewSvirin\Interview\Exceptions\ClassNamespaceIncorrectException;
use AndrewSvirin\Interview\Exceptions\ClassNotExistsException;
use AndrewSvirin\Interview\Requests\ApiRequest;
use Psr\Http\Message\RequestInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Produce child api request instance.
 * Abstract factory.
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
     * @throws ClassNotExistsException
     * @throws ClassNamespaceIncorrectException
     */
    public function createApiRequest(string $className, RequestInterface $request): ApiRequest
    {
        // Check that class name exists.
        if (!class_exists($className)) {
            throw new ClassNotExistsException(sprintf('Request class `%s` not found.', $className));
        }

        // Check that class name is child of api request.
        if (!is_subclass_of($className, ApiRequest::class)) {
            throw new ClassNamespaceIncorrectException(sprintf(
                'Allowed argument with instance of `%s`.',
                ApiRequest::class
            ));
        }

        // Create reflection class.
        $class = new ReflectionClass($className);

        // Create instance of class by reflection class.
        /* @var $apiRequest ApiRequest */
        $apiRequest = $class->newInstanceArgs([
            $request->getMethod(),
            $request->getUri()
        ]);

        return $apiRequest;
    }
}
