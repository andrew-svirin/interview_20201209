<?php

namespace AndrewSvirin\Interview\Factories\Http;

use AndrewSvirin\Interview\Http\Request;
use LogicException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * Produce request.
 */
class RequestFactory implements RequestFactoryInterface
{

    /**
     * URI factory.
     *
     * @var UriFactoryInterface
     */
    private UriFactoryInterface $uriFactory;

    public function __construct(UriFactoryInterface $uriFactory)
    {
        $this->uriFactory = $uriFactory;
    }

    /**
     * @inheritDoc
     */
    public function createRequest(string $method, $uri): RequestInterface
    {
        // Detect URI or by string or by instance.
        if (is_string($uri)) {
            $uriInstance = $this->uriFactory->createUri($uri);
        } elseif ($uri instanceof UriInterface) {
            $uriInstance = $uri;
        } else {
            throw new LogicException('$uri is incorrect.');
        }

        // Create request.
        $request = new Request($method, $uriInstance);

        return $request;
    }
}
