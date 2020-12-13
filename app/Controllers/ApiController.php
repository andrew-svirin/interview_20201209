<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Requests\ApiRequest;
use AndrewSvirin\Interview\Services\Validator\ApiRequestValidator;

/**
 * Common Api Controller implementation.
 */
abstract class ApiController
{

    /**
     * Validator for API Request.
     *
     * @var ApiRequestValidator
     */
    private ApiRequestValidator $validator;

    public function __construct(ApiRequestValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Validate APIRequest.
     *
     * @param ApiRequest $apiRequest
     *
     * @return array|null
     */
    protected function validate(ApiRequest $apiRequest)
    {
        $violations = $this->validator->validate($apiRequest);

        return $violations;
    }
}
