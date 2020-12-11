<?php

namespace AndrewSvirin\Interview\Factories;

use AndrewSvirin\Interview\Responses\ApiResponse;

/**
 * Produce api response.
 */
class ApiResponseFactory
{

    /**
     * Create API response from body string.
     *
     * @param int $code
     * @param string $reasonPhrase
     *
     * @return ApiResponse
     */
    public function createApiResponse(int $code = 200, string $reasonPhrase = ''): ApiResponse
    {
        return new ApiResponse($code, $reasonPhrase);
    }
}
