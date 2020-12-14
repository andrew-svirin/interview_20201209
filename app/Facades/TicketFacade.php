<?php

namespace AndrewSvirin\Interview\Facades;

use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Models\Airplane;
use AndrewSvirin\Interview\Models\Ticket;
use AndrewSvirin\Interview\Repositories\TicketRepository;
use AndrewSvirin\Interview\Services\Ticket\TicketSitCalculator;

/**
 * Ticket facade.
 * Collect methods about model Ticket.
 */
class TicketFacade
{

    /**
     * Ticket model repository.
     *
     * @var TicketRepository
     */
    private TicketRepository $ticketRepository;

    /**
     * Model factory.
     *
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    /**
     * Ticket sits calculator.
     *
     * @var TicketSitCalculator
     */
    private TicketSitCalculator $ticketSitCalculator;

    public function __construct(
        TicketRepository $ticketRepository,
        ModelFactory $modelFactory,
        TicketSitCalculator $ticketSitCalculator
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->modelFactory = $modelFactory;
        $this->ticketSitCalculator = $ticketSitCalculator;
    }

    /**
     * Create Ticket model from array of values.
     *
     * @param array $values
     *
     * @return Ticket
     */
    public function create(array $values): Ticket
    {
        /* @var $model Ticket */
        $model = $this->modelFactory->createModel(Ticket::class);
        $model->setValues($values);

        return $model; // @phpstan-ignore-line
    }

    /**
     * Save ticket model to repository.
     *
     * @param Ticket $model
     *
     * @return bool
     */
    public function save(Ticket $model): bool
    {
        return $this->ticketRepository->save($model);
    }

    /**
     * Find model in repository.
     *
     * @param int $id
     *
     * @return Ticket|null
     */
    public function findById(int $id): ?Ticket
    {
        return $this->ticketRepository->findById($id);
    }

    /**
     * Find models in repository.
     *
     * @param array $conditions
     *
     * @return Ticket[]|null
     */
    public function findMultiple(array $conditions): ?array
    {
        return $this->ticketRepository->findMultiple($conditions);
    }

    /**
     * Count models in repository by airplane.
     *
     * @param int $airplaneId
     *
     * @return int
     */
    public function countByAirplaneId(int $airplaneId): int
    {
        return $this->ticketRepository->count(['airplane_id' => $airplaneId]);
    }

    /**
     * Calculate sits.
     *
     * @param Airplane $airplane
     * @param int $amount
     *
     * @return array
     */
    public function calculateSits(Airplane $airplane, int $amount): array
    {
        return $this->ticketSitCalculator->calculate($airplane, $amount);
    }
}
