<?php

namespace AndrewSvirin\Interview\Services\Validator;

use AndrewSvirin\Interview\Requests\ApiRequest;

/**
 * Validates api requests by rules.
 */
class ApiRequestValidator
{

    /**
     * Value validator.
     *
     * @var Validator
     */
    private Validator $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
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
        $values = $apiRequest->validated();
        $rules = $apiRequest->rules();

        $violations = null;

        // Go over rules because, validated values can be less than rules.
        foreach ($rules as $field => $fieldRules) {
            $fieldViolations = $this->validator->validate($values[$field] ?? null, $fieldRules);

            // Ignore when value does not violate rules.
            if (null === $fieldViolations) {
                continue;
            }

            $violations[$field] = $fieldViolations;
        }

        return $violations;
    }
}
