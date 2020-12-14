<?php

namespace AndrewSvirin\Interview\Http;

use Psr\Http\Message\UriInterface;
use RuntimeException;

/**
 * Http uri model implementation.
 */
class Uri implements UriInterface
{

    /**
     * URI path.
     * @var string
     */
    private string $path;

    /**
     * URI query.
     * @var string
     */
    private string $query;

    /**
     * @inheritDoc
     */
    public function getScheme()
    {
        throw new RuntimeException('Not implemented method getScheme().');
    }

    /**
     * @inheritDoc
     */
    public function getAuthority()
    {
        throw new RuntimeException('Not implemented method getAuthority().');
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        throw new RuntimeException('Not implemented method getUserInfo().');
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        throw new RuntimeException('Not implemented method getHost().');
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        throw new RuntimeException('Not implemented method getPort().');
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getFragment()
    {
        throw new RuntimeException('Not implemented method getFragment().');
    }

    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        throw new RuntimeException('Not implemented method withScheme().');
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        throw new RuntimeException('Not implemented method withUserInfo().');
    }

    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        throw new RuntimeException('Not implemented method withHost().');
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        throw new RuntimeException('Not implemented method withPort().');
    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        throw new RuntimeException('Not implemented method withFragment().');
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        throw new RuntimeException('Not implemented method __toString().');
    }
}
