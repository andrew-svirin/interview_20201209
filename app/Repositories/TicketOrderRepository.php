<?php

namespace AndrewSvirin\Interview\Repositories;

use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Gateways\Db\TicketOrderTableGateway;
use AndrewSvirin\Interview\Models\TicketOrder;

/**
 * Implements db layer operations with model TicketOrder.
 */
class TicketOrderRepository
{

    /**
     * TicketOrder table gateway.
     *
     * @var TicketOrderTableGateway
     */
    private TicketOrderTableGateway $ticketOrderTableGateway;

    /**
     * Model factory to create Airplane model.
     *
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    public function __construct(TicketOrderTableGateway $ticketOrderTableGateway, ModelFactory $modelFactory)
    {
        $this->ticketOrderTableGateway = $ticketOrderTableGateway;
        $this->modelFactory = $modelFactory;
    }

    /**
     * Save model to storage.
     * This method will add model primary id.
     *
     * @param TicketOrder $model
     */
    public function save(TicketOrder $model): bool
    {
        $row = $model->getValues();
        $id = $this->ticketOrderTableGateway->save($row);
        if (null === $id) {
            return false;
        }
        $model->id = $id;
        return true;
    }

    /**
     * Find TicketOrder model by id.
     *
     * @param int $id
     *
     * @return TicketOrder|null
     */
    public function findById(int $id): ?TicketOrder
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
     * Find TicketOrder models by conditions.
     *
     * @param array $conditions
     *
     * @return TicketOrder[]|null
     */
    public function findMultiple(array $conditions): ?array
    {
        $rows = $this->ticketOrderTableGateway->findMultiple($conditions);

        // Check if any records were found.
        if (empty($rows)) {
            return null;
        }

        $models = [];

        foreach ($rows as $row) {
            /* @var $model TicketOrder */
            $model = $this->modelFactory->createModel(TicketOrder::class);
            $model->setValues($row);

            $models[] = $model;
        }

        return $models; // @phpstan-ignore-line
    }
}
