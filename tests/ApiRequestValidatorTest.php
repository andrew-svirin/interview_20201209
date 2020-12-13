<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Requests\Airplane\CreateAirplaneRequest;
use AndrewSvirin\Interview\Services\Validator\ApiRequestValidator;
use AndrewSvirin\Interview\Tests\Components\ApiRequestTrait;

/**
 * Tests for @see \AndrewSvirin\Interview\Services\Validator
 *
 * @group api-request-validator
 */
class ApiRequestValidatorTest extends BaseTestCase
{

    use ApiRequestTrait;

    /**
     * Validate request for create airplane.
     * @group api-request-validator-validate
     */
    public function testValidate()
    {
        $apiRequest = $this->createApiRequest(CreateAirplaneRequest::class, 'POST', 'api/airplanes', [
            'sits_count' => 2000,
            'rows' => 26,
            'row_arrangement' => 'A B C _ D E F'
        ]);

        /* @var $apiRequestValidator ApiRequestValidator */
        $apiRequestValidator = $this->container->get(ApiRequestValidator::class);

        $violations = $apiRequestValidator->validate($apiRequest);

        $this->assertEquals([
            'aircraft_type' => [
                [
                    'Field :field can not be empty.',
                ],
            ],
            'sits_count' => [
                [
                    'Field :field can not be more than 1000.',
                ],
            ],
        ], $violations);
    }
}
