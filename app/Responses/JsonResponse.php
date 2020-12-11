<?php

namespace AndrewSvirin\Interview\Responses;

use AndrewSvirin\Interview\Http\Response;

/**
 * Common json response model implementation.
 */
class JsonResponse extends Response
{
    /**
     * Get json data from body.
     *
     * @return array|null
     */
    public function getJson(): ?array
    {
        return !empty($this->body) ? json_decode($this->body, true) : null;
    }
}
