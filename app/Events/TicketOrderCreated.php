<?php

namespace AndrewSvirin\Interview\Events;

use AndrewSvirin\Interview\Models\TicketOrder;
use AndrewSvirin\Interview\Services\EventDispatcher\EventInterface;

/**
 * Ticket order model created.
 */
class TicketOrderCreated implements EventInterface
{

    /**
     * Created ticket order.
     *
     * @var TicketOrder
     */
    private TicketOrder $ticketOrder;

    /**
     * Sits count.
     *
     * @var int
     */
    private int $airplaneId;

    /**
     * Sits count.
     *
     * @var int
     */
    private int $sitsCount;

    public function __construct(TicketOrder $ticketOrder, int $airplaneId, int $sitsCount)
    {
        $this->ticketOrder = $ticketOrder;
        $this->airplaneId = $airplaneId;
        $this->sitsCount = $sitsCount;
    }

    /**
     * Getter for ticketOrder.
     *
     * @return TicketOrder
     */
    public function getTicketOrder(): TicketOrder
    {
        return $this->ticketOrder;
    }

    /**
     * Getter for airplaneId.
     *
     * @return int
     */
    public function getAirplaneId(): int
    {
        return $this->airplaneId;
    }

    /**
     * Getter for sitsCount.
     * @return int
     */
    public function getSitsCount(): int
    {
        return $this->sitsCount;
    }
}
