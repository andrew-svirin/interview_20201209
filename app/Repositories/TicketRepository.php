<?php

namespace AndrewSvirin\Interview\Repositories;

use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Gateways\Db\TicketTableGateway;
use AndrewSvirin\Interview\Models\Ticket;

/**
 * Implements db layer operations with model Ticket.
 */
class TicketRepository
{

    /**
     * Ticket table gateway.
     *
     * @var TicketTableGateway
     */
    private TicketTableGateway $ticketTableGateway;

    /**
     * Model factory to create Airplane model.
     *
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    public function __construct(TicketTableGateway $ticketTableGateway, ModelFactory $modelFactory)
    {
        $this->ticketTableGateway = $ticketTableGateway;
        $this->modelFactory = $modelFactory;
    }

    /**
     * Save model to storage.
     * This method will add model primary id.
     *
     * @param Ticket $model
     */
    public function save(Ticket $model): bool
    {
        $row = $model->getValues();
        $id = $this->ticketTableGateway->save($row);
        if (null === $id) {
            return false;
        }
        $model->id = $id;
        return true;
    }

    /**
     * Find Ticket model by id.
     *
     * @param int $id
     *
     * @return Ticket|null
     */
    public function findById(int $id): ?Ticket
    {
        $models = $this->findMultiple(['id' => $id]);

        // Check if any models were found.
        if (empty($models)) {
            return null;
        }

        // Extract single model.
        $model = reset($models);

        return !empty($model) ? $model : null;
    }

    /**
     * Find Ticket models by conditions.
     *
     * @param array $conditions
     *
     * @return Ticket[]|null
     */
    public function findMultiple(array $conditions): ?array
    {
        $rows = $this->ticketTableGateway->findMultiple($conditions);

        // Check if any records were found.
        if (empty($rows)) {
            return null;
        }

        $models = [];

        foreach ($rows as $row) {
            /* @var $model Ticket */
            $model = $this->modelFactory->createModel(Ticket::class);
            $model->setValues($row);

            $models[] = $model;
        }

        return $models; // @phpstan-ignore-line
    }


    /**
     * Count Ticket models by conditions.
     *
     * @param array $conditions
     *
     * @return int
     */
    public function count(array $conditions): int
    {
        return $this->ticketTableGateway->count($conditions);
    }
}
