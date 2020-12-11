<?php

namespace AndrewSvirin\Interview\Requests;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use RuntimeException;

/**
 * Common request model implementation.
 */
class Request implements RequestInterface
{

    /**
     * Method.
     * @var string
     */
    private string $method;

    /**
     * URI of request.
     * @var UriInterface
     */
    private UriInterface $uri;

    /**
     * Body.
     * @var mixed|null
     */
    private $body;

    /**
     * Request constructor.
     *
     * @param string $method
     * @param UriInterface $uri
     * @param mixed|null $body
     */
    public function __construct(string $method, UriInterface $uri, $body = null)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
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
        throw new RuntimeException('Not implemented method withBody().');
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
