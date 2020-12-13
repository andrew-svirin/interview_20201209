<?php

namespace AndrewSvirin\Interview\Factories\Http\Stream;

use Psr\Http\Message\StreamInterface;

/**
 * Produce stream.
 */
interface JsonStreamFactoryInterface
{

    /**
     * Create stream by json encoding data.
     *
     * @param mixed $json
     *
     * @return StreamInterface
     */
    public function createStreamFromJson($json = ''): StreamInterface;
}
