<?php

namespace AndrewSvirin\Interview\Factories\Http\Stream;

use Psr\Http\Message\StreamInterface;

/**
 * Produce stream.
 */
interface InputStreamFactoryInterface
{

    /**
     * Create stream from input.
     *
     * @return StreamInterface
     */
    public function createStreamFromInput(): StreamInterface;
}
