<?php

namespace AndrewSvirin\Interview\Http\Json;

/**
 * Describe Json methods for Message
 */
interface JsonMessage
{
    /**
     * Get json array from body.
     *
     * @return array|null
     */
    public function getJson(): ?array;
}
