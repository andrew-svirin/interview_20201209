<?php

namespace AndrewSvirin\Interview\Factories\Stream;

use Psr\Http\Message\StreamInterface;

/**
 * Produce stream.
 */
interface JsonStreamFactoryInterface
{

    /**
     * Create stream from json encoding data.
     *
     * @param mixed $content
     *
     * @return StreamInterface
     */
    public function createStreamFromJson($content = ''): StreamInterface;
}
