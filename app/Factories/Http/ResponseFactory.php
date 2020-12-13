<?php

namespace AndrewSvirin\Interview\Factories\Http;

use AndrewSvirin\Interview\Http\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Produce response.
 */
class ResponseFactory implements ResponseFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return new Response($code, $reasonPhrase);
    }
}
