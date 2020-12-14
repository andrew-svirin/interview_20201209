<?php

namespace AndrewSvirin\Interview\Repositories;

use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Gateways\Db\AirplaneTableGateway;
use AndrewSvirin\Interview\Models\Airplane;

/**
 * Implements db layer operations with model Airplane.
 */
class AirplaneRepository
{

    /**
     * Airplane table gateway.
     *
     * @var AirplaneTableGateway
     */
    private AirplaneTableGateway $airplaneTableGateway;

    /**
     * Model factory to create Airplane model.
     *
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    public function __construct(AirplaneTableGateway $airplaneTableGateway, ModelFactory $modelFactory)
    {
        $this->airplaneTableGateway = $airplaneTableGateway;
        $this->modelFactory = $modelFactory;
    }

    /**
     * Save model to storage.
     * This method will add model primary id.
     *
     * @param Airplane $model
     */
    public function save(Airplane $model): bool
    {
        $row = $model->getValues();
        $id = $this->airplaneTableGateway->save($row);
        if (null === $id) {
            return false;
        }
        $model->id = $id;
        return true;
    }

    /**
     * Find airplane model by id.
     *
     * @param int $id
     *
     * @return Airplane|null
     */
    public function findById(int $id): ?Airplane
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
     * Find airplane models by conditions.
     *
     * @param array|null $conditions
     *
     * @return Airplane[]|null
     */
    public function findMultiple(array $conditions = null): ?array
    {
        $rows = $this->airplaneTableGateway->findMultiple($conditions);

        // Check if any records were found.
        if (empty($rows)) {
            return null;
        }

        $models = [];

        foreach ($rows as $row) {
            /* @var $model Airplane */
            $model = $this->modelFactory->createModel(Airplane::class);
            $model->setValues($row);

            $models[] = $model;
        }

        return $models; // @phpstan-ignore-line
    }
}
