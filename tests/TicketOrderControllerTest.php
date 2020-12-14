<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Helpers\ArrHelper;

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

    /**
     * Send request to create ticket-order.
     *   Marco: 4 people;
     *   Gerard: 2 people; Result:
     *   Marco seats: 'A1', 'B1', 'A2', 'B2';
     *   Gerard seats: 'E1', 'F1';
     * @see \AndrewSvirin\Interview\Controllers\TicketOrderController::createAction()
     * @group ticket-order-booking-1
     */
    public function testBooking1()
    {
        // Register airplane.
        $response = $this->request('POST', 'api/airplanes', [
            'aircraft_type' => 'short_range',
            'sits_count' => 156,
            'rows' => 26,
            'row_arrangement' => 'A B C _ D E F',
        ]);

        $airplaneId = $this->getJson($response, 'data.id');

        // Make ticket orders.
        $response = $this->request('POST', 'api/ticket-orders', [
            'airplane_id' => $airplaneId,
            'sits_count' => 4,
            'person_name' => 'Marco',
        ]);

        $ticketOrderId1 = $this->getJson($response, 'data.id');

        $response = $this->request('POST', 'api/ticket-orders', [
            'airplane_id' => $airplaneId,
            'sits_count' => 2,
            'person_name' => 'Gerard',
        ]);

        $ticketOrderId2 = $this->getJson($response, 'data.id');

        // Get tickets by ticket orders.
        $response = $this->request('GET', 'api/tickets?' . http_build_query([
                'conditions' => ['ticket_order_id' => $ticketOrderId1],
            ]));

        $tickets1 = $this->getJson($response, 'data');
        $tickets1Sits = ArrHelper::filter($tickets1, ['row_number', 'sit_number']);

        $response = $this->request('GET', 'api/tickets?' . http_build_query([
                'conditions' => ['ticket_order_id' => $ticketOrderId2],
            ]));

        $tickets2 = $this->getJson($response, 'data');
        $tickets2Sits = ArrHelper::filter($tickets2, ['row_number', 'sit_number']);

        $this->assertEquals([
            [
                'row_number' => 1,
                'sit_number' => 'A',
            ],
        ], $tickets1Sits);

        $this->assertEquals([
            [
                'row_number' => 1,
                'sit_number' => 'A',
            ],
        ], $tickets2Sits);
        return;
    }
}
