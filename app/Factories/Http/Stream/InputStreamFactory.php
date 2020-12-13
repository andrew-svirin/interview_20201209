<?php

namespace AndrewSvirin\Interview\Factories\Http\Stream;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Produce input stream.
 */
class InputStreamFactory implements InputStreamFactoryInterface
{

    /**
     * Stream Factory.
     *
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    public function __construct(StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromInput(): StreamInterface
    {
        // Create stream from STDIN (read-only).
        $resource = fopen('php://input', 'r');
        if (false === $resource) {
            throw new RuntimeException('Resource not opened.');
        }

        return $this->streamFactory->createStreamFromResource($resource);
    }
}
