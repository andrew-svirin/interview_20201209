<?php

namespace AndrewSvirin\Interview\Requests;

use AndrewSvirin\Interview\Http\Request;

/**
 * Common JSON request implementation.
 */
class JsonRequest extends Request
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
