<?php

namespace AndrewSvirin\Interview\Tests;

/**
 * Tests for @see \AndrewSvirin\Interview\Controllers\AirplaneController
 *
 * @group airplane-controller
 */
class AirplaneControllerTest extends BaseTestCase
{

    /**
     * Send request to create airplane.
     * @group airplane-controller-create
     */
    public function testCreate()
    {
        $response = $this->request('POST', 'api/airplanes', [
            'aircraft_type' => 'short_range',
            'sits_count' => 156,
            'rows' => 26,
            'row_arrangement' => 'A B C _ D E F',
        ]);

        $this->assertResponseJson($response, ['message' => 'Airplane created.']);
    }
}
