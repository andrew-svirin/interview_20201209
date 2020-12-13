<?php

namespace AndrewSvirin\Interview\Facades;

use AndrewSvirin\Interview\Events\TicketOrderCreated;
use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Models\TicketOrder;
use AndrewSvirin\Interview\Repositories\TicketOrderRepository;
use AndrewSvirin\Interview\Services\EventDispatcher\EventDispatcher;

/**
 * TicketOrder facade.
 * Collect methods about model TicketOrder.
 */
class TicketOrderFacade
{

    /**
     * TicketOrder model repository.
     *
     * @var TicketOrderRepository
     */
    private TicketOrderRepository $ticketOrderRepository;

    /**
     * Model factory.
     *
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    /**
     * Event dispatcher.
     *
     * @var EventDispatcher
     */
    private EventDispatcher $eventDispatcher;

    public function __construct(
        TicketOrderRepository $ticketOrderRepository,
        ModelFactory $modelFactory,
        EventDispatcher $eventDispatcher
    ) {
        $this->ticketOrderRepository = $ticketOrderRepository;
        $this->modelFactory = $modelFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Create TicketOrder model from array of values.
     *
     * @param array $values
     *
     * @return TicketOrder
     */
    public function create(array $values): TicketOrder
    {
        /* @var $model TicketOrder */
        $model = $this->modelFactory->createModel(TicketOrder::class);
        $model->setValues($values);

        return $model; // @phpstan-ignore-line
    }

    /**
     * Save ticket order model to repository.
     * Trigger event to save tickets.
     *
     * @param TicketOrder $model
     * @param int $ticketsCount
     *
     * @return bool
     */
    public function save(TicketOrder $model, int $ticketsCount): bool
    {
        $result = $this->ticketOrderRepository->save($model);
        $this->eventDispatcher->dispatch(new TicketOrderCreated($model, $ticketsCount));

        return $result;
    }

    /**
     * Find model in repository.
     *
     * @param int $id
     *
     * @return TicketOrder|null
     */
    public function findById(int $id): ?TicketOrder
    {
        return $this->ticketOrderRepository->findById($id);
    }
}
