<?php

namespace AndrewSvirin\Interview\Requests;

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
        $body = $this->getBody();
        return !empty($body) ? json_decode($body, true) : null;
    }
}
