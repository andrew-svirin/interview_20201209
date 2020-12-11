<?php

namespace AndrewSvirin\Interview\Factories;

use AndrewSvirin\Interview\Requests\Uri;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

/**
 * Produce uri.
 */
class UriFactory implements UriFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createUri(string $uri = ''): UriInterface
    {
        return new Uri($uri);
    }
}
