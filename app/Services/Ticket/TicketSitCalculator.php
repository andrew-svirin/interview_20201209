<?php

namespace AndrewSvirin\Interview\Services\Ticket;

use AndrewSvirin\Interview\Gateways\Db\TicketTableGateway;
use AndrewSvirin\Interview\Models\Airplane;
use RuntimeException;

/**
 * Implements calculation of sits for tickets.
 */
class TicketSitCalculator
{

    /**
     * Ticket Table Gateway.
     *
     * @var TicketTableGateway
     */
    private TicketTableGateway $ticketTableGateway;

    public function __construct(TicketTableGateway $ticketTableGateway)
    {
        $this->ticketTableGateway = $ticketTableGateway;
    }

    /**
     * Calculate sits in airplane.
     *
     * @param Airplane $airplane
     * @param int $amount
     *
     * @return array = [
     *     ['<row_number>', '<sit_number>']
     * ]
     */
    public function calculate(Airplane $airplane, int $amount): array
    {
        if (($row = $this->checkSitsInOneRow($airplane, $amount))) {
            // TODO: Make logic for calculation sits.
        }
        // TODO: Stub.
        return [[1, 'A']];
    }

    /**
     * If passengers can all fit in a row, the system will book them in the same row.
     * (ex. ['A1', 'B1', 'C1'] or ['E1', 'F1']).
     *
     * @param Airplane $airplane
     * @param int $amount
     *
     * @return null|int Number of row with able sits amount. Null on no one row can hold all sits.
     */
    private function checkSitsInOneRow(Airplane $airplane, int $amount)
    {
        // Sits in row in airplane.
        $airplaneRowSits = 6;

        // Check sits limit.
        if ($airplaneRowSits < $amount) {
            return null;
        }

        $countTicketsByRow = $this->ticketTableGateway->countByRowAndAirplaneId(['airplane_id' => $airplane->id]);

        // Check if any tickets exists.
        if (empty($countTicketsByRow)) {
            return 1;
        }

        // Combine rows and sits count.
        $rowsCount = array_combine(
            array_column($countTicketsByRow, 'row_number'),
            array_column($countTicketsByRow, 'COUNT')
        );

        // Check combine method did correct.
        if (false === $rowsCount) {
            throw new RuntimeException('Combine was not correct.');
        }

        $selectedRow = null;

        for ($row = 1; $row <= $airplane->rows; $row++) {
            // Check if in row are able all sits.
            if (empty($rowsCount[$row])) {
                $selectedRow = $row;
                break;
            }

            // Check that in row are able amount of sits.
            if ($airplaneRowSits - $rowsCount[$row] >= $amount) {
                $selectedRow = $row;
                break;
            }
        }

        return $selectedRow;
    }
}
