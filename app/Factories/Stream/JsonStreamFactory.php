<?php

namespace AndrewSvirin\Interview\Factories\Stream;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

/**
 * Produce json stream.
 */
class JsonStreamFactory implements JsonStreamFactoryInterface
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
    public function createStreamFromJson($json = ''): StreamInterface
    {
        $content = json_encode($json);
        if (false === $content) {
            throw new RuntimeException('Json not encoded.');
        }

        return $this->streamFactory->createStream($content);
    }
}
