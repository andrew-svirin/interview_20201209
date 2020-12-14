<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Builders\ApiResponseBuilder;
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
    private ApiRequestValidator $apiRequestValidator;

    /**
     * Builder for API Response.
     * @var ApiResponseBuilder
     */
    private ApiResponseBuilder $apiResponseBuilder;

    public function __construct(ApiRequestValidator $apiRequestValidator, ApiResponseBuilder $apiResponseBuilder)
    {
        $this->apiRequestValidator = $apiRequestValidator;
        $this->apiResponseBuilder = $apiResponseBuilder;
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
        $violations = $this->apiRequestValidator->validate($apiRequest);

        return $violations;
    }

    /**
     * Make api response.
     *
     * @param int $code
     * @param string $reasonPhrase
     *
     * @return ApiResponseBuilder
     */
    protected function response(int $code = 200, string $reasonPhrase = ''): ApiResponseBuilder
    {
        return $this->apiResponseBuilder->createApiResponse($code, $reasonPhrase);
    }
}
