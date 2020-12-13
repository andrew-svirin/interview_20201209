<?php

namespace AndrewSvirin\Interview\Responses;

use AndrewSvirin\Interview\Http\Json\JsonMessage;
use AndrewSvirin\Interview\Http\Response;

/**
 * Common json response model implementation.
 */
class JsonResponse extends Response implements JsonMessage
{
    /**
     * @inheritDoc
     */
    public function getJson(): ?array
    {
        return !empty($this->body) ? json_decode($this->body, true) : null;
    }
}
