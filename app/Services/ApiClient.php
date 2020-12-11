<?php

namespace AndrewSvirin\Interview\Services;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Receive request and send it to server.
 */
class ApiClient implements ClientInterface
{

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        throw new \RuntimeException('Not implemented method sendRequest().');
    }
}
