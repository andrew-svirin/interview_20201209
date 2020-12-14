<?php

namespace AndrewSvirin\Interview\Services\Ticket;

use AndrewSvirin\Interview\Models\Airplane;

/**
 * Implements calculation of sits for tickets.
 */
class TicketSitCalculator
{

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
        return [['A', 1]];
    }
}
