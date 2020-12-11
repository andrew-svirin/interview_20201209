<?php

namespace AndrewSvirin\Interview\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;

/**
 * Http request model implementation.
 */
class Request implements RequestInterface
{

    /**
     * Method.
     *
     * @var string
     */
    protected string $method;

    /**
     * URI of request.
     *
     * @var UriInterface
     */
    protected UriInterface $uri;

    /**
     * Body.
     *
     * @var StreamInterface|null
     */
    protected ?StreamInterface $body = null;

    /**
     * Request constructor.
     *
     * @param string $method
     * @param UriInterface $uri
     */
    public function __construct(string $method, UriInterface $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        throw new RuntimeException('Not implemented method getProtocolVersion().');
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        throw new RuntimeException('Not implemented method withProtocolVersion().');
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        throw new RuntimeException('Not implemented method getHeaders().');
    }

    public function getHeader($name)
    {
        throw new RuntimeException('Not implemented method getHeader().');
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        throw new RuntimeException('Not implemented method hasHeader().');
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        throw new RuntimeException('Not implemented method getHeaderLine().');
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        throw new RuntimeException('Not implemented method withHeader().');
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        throw new RuntimeException('Not implemented method withAddedHeader().');
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        throw new RuntimeException('Not implemented method withoutHeader().');
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        throw new RuntimeException('Not implemented method getRequestTarget().');
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        throw new RuntimeException('Not implemented method withRequestTarget().');
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        throw new RuntimeException('Not implemented method withMethod().');
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        throw new RuntimeException('Not implemented method withUri().');
    }
}
