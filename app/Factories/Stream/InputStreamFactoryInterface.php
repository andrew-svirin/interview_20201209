<?php

namespace AndrewSvirin\Interview\Factories\Stream;

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
