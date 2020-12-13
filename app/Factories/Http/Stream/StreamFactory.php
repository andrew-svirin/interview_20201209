<?php

namespace AndrewSvirin\Interview\Factories\Http\Stream;

use AndrewSvirin\Interview\Http\Stream;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Produce stream.
 */
class StreamFactory implements StreamFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createStream(string $content = ''): StreamInterface
    {
        $resource = fopen('php://temp', 'w+');
        if (false === $resource) {
            throw new RuntimeException('Resource not opened.');
        }
        $stream = $this->createStreamFromResource($resource);
        $stream->write($content);
        $stream->rewind();
        return $stream;
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        $resource = fopen($filename, $mode);
        if (false === $resource) {
            throw new RuntimeException('Resource not opened.');
        }

        return $this->createStreamFromResource($resource);
    }

    /**
     * @inheritDoc
     */
    public function createStreamFromResource($resource): StreamInterface
    {
        return new Stream($resource);
    }
}
