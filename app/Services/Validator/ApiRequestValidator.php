<?php

namespace AndrewSvirin\Interview\Services\Validator;

use AndrewSvirin\Interview\Requests\ApiRequest;

/**
 * Validates api requests by rules.
 */
class ApiRequestValidator
{

    public function __construct()
    {
    }

    /**
     * Validate API request and response violations on errors.
     *
     * @param ApiRequest $apiRequest
     *
     * @return array|null
     */
    public function validate(ApiRequest $apiRequest): ?array
    {
        return [];
    }
}
