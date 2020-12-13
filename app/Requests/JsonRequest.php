<?php

namespace AndrewSvirin\Interview\Requests;

use AndrewSvirin\Interview\Http\Json\JsonMessage;
use AndrewSvirin\Interview\Http\Request;

/**
 * Common JSON request implementation.
 */
class JsonRequest extends Request implements JsonMessage
{

    /**
     * @inheritDoc
     */
    public function getJson(): ?array
    {
        return !empty($this->body) ? json_decode($this->body, true) : null;
    }
}
