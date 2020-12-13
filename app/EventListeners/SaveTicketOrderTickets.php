<?php

namespace AndrewSvirin\Interview\EventListeners;

use AndrewSvirin\Interview\Events\TicketOrderCreated;
use AndrewSvirin\Interview\Facades\AirplaneFacade;
use AndrewSvirin\Interview\Facades\TicketFacade;
use AndrewSvirin\Interview\Services\EventDispatcher\EventInterface;
use AndrewSvirin\Interview\Services\EventDispatcher\EventListenerInterface;

/**
 * Ticket order model created.
 */
class SaveTicketOrderTickets implements EventListenerInterface
{

    /**
     * Airplane facade.
     *
     * @var AirplaneFacade
     */
    private AirplaneFacade $airplaneFacade;

    /**
     * Ticket facade.
     *
     * @var TicketFacade
     */
    private TicketFacade $ticketFacade;

    public function __construct(AirplaneFacade $airplaneFacade, TicketFacade $ticketFacade)
    {
        $this->airplaneFacade = $airplaneFacade;
        $this->ticketFacade = $ticketFacade;
    }

    /**
     * @inheritDoc
     *
     * @param TicketOrderCreated $event
     */
    public function perform(EventInterface $event): void
    {
        $airplane = $this->airplaneFacade->findById($event->getTicketOrder()->airplane_id);
        $sits = $this->ticketFacade->calculateSits($airplane, $event->getSitsCount());

        // Go over sits to store tickets.
        foreach ($sits as $sit) {
            // Extract row number and sit number from sit.
            [$rowNumber, $sitNumber] = $sit;

            // Create ticket model.
            $ticket = $this->ticketFacade->create([
                'ticket_order_id' => $event->getTicketOrder()->id,
                'row_number' => $rowNumber,
                'sit_number' => $sitNumber,
            ]);

            $this->ticketFacade->save($ticket);
        }
    }
}
