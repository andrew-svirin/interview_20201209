<?php

namespace AndrewSvirin\Interview\Tests;

/**
 * Tests for @see \AndrewSvirin\Interview\Controllers\TicketOrderController
 *
 * @group ticket-order-controller
 */
class TicketOrderControllerTest extends BaseTestCase
{

    /**
     * Send request to create ticket-order.
     * @see \AndrewSvirin\Interview\Controllers\TicketOrderController::createAction()
     * @group ticket-order-create
     */
    public function testCreate()
    {
        $response = $this->request('POST', 'api/airplanes', [
            'aircraft_type' => 'short_range',
            'sits_count' => 156,
            'rows' => 26,
            'row_arrangement' => 'A B C _ D E F',
        ]);

        $airplaneId = $this->getJson($response, 'data.id');

        $response = $this->request('POST', 'api/ticket-orders', [
            'airplane_id' => $airplaneId,
            'sits_count' => 4,
            'person_name' => 'Marco',
        ]);

        $this->assertResponseJsonHas($response, ['message' => 'Ticket order created.']);
    }
}
