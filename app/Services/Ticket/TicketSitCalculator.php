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
     * @return array
     */
    public function calculate(Airplane $airplane, int $amount): array
    {
        return [];
    }
}
