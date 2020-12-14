<?php

namespace AndrewSvirin\Interview\Factories\Http;

use AndrewSvirin\Interview\Http\Uri;
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
    public function createUri(string $url = ''): UriInterface
    {
        $uri = new Uri();

        // Parse uri.
        $parsedUrl = parse_url(urldecode($url));

        // Check that url was parsed.
        if (!is_array($parsedUrl)) {
            return $uri;
        }

        if (isset($parsedUrl['path'])) {
            $uri->withPath($parsedUrl['path']);
        }

        if (isset($parsedUrl['query'])) {
            $uri->withQuery($parsedUrl['query']);
        }

        return $uri;
    }
}
