<?php

namespace AndrewSvirin\Interview\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Http response model implementation.
 */
class Response implements ResponseInterface
{

    /**
     * Status code.
     *
     * @var int
     */
    protected int $statusCode;

    /**
     * Reason phrase.
     *
     * @var string
     */
    protected string $reasonPhrase;

    /**
     * Body.
     * @var StreamInterface|null
     */
    protected ?StreamInterface $body = null;

    public function __construct(int $code, string $reasonPhrase = '')
    {
        $this->statusCode = $code;
        $this->reasonPhrase = $reasonPhrase;
    }

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
        $this->statusCode = $code;
        $this->reasonPhrase = $reasonPhrase;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
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
        $this->body = $body;

        return $this;
    }
}
