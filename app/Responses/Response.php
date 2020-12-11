<?php

namespace AndrewSvirin\Interview\Responses;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Common response model implementation.
 */
class Response implements ResponseInterface
{

    /**
     * Status code.
     *
     * @var int
     */
    private int $statusCode;

    /**
     * Body.
     * @var mixed
     */
    private $body;

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        throw new RuntimeException('Not implemented method withStatus().');
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        throw new RuntimeException('Not implemented method getReasonPhrase().');
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
    public function getHeader($name)
    {
        throw new RuntimeException('Not implemented method getHeader().');
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
}
