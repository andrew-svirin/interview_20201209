<?php

namespace AndrewSvirin\Interview\Facades;

use AndrewSvirin\Interview\Factories\Models\ModelFactory;
use AndrewSvirin\Interview\Models\Airplane;
use AndrewSvirin\Interview\Repositories\AirplaneRepository;

/**
 * Airplane facade.
 * Collect methods about model Airplane.
 */
class AirplaneFacade
{

    /**
     * Airplane model repository.
     *
     * @var AirplaneRepository
     */
    private AirplaneRepository $airplaneRepository;

    /**
     * Model factory.
     *
     * @var ModelFactory
     */
    private ModelFactory $modelFactory;

    public function __construct(AirplaneRepository $airplaneRepository, ModelFactory $modelFactory)
    {
        $this->airplaneRepository = $airplaneRepository;
        $this->modelFactory = $modelFactory;
    }

    /**
     * Create Airplane model from array of values.
     *
     * @param array $values
     *
     * @return Airplane
     */
    public function create(array $values): Airplane
    {
        /* @var $model Airplane */
        $model = $this->modelFactory->createModel(Airplane::class);
        $model->setValues($values);

        return $model; // @phpstan-ignore-line
    }

    /**
     * Save model to repository.
     *
     * @param Airplane $model
     *
     * @return bool
     */
    public function save(Airplane $model): bool
    {
        return $this->airplaneRepository->save($model);
    }

    /**
     * Find model in repository.
     *
     * @param int $id
     *
     * @return Airplane|null
     */
    public function findById(int $id): ?Airplane
    {
        return $this->airplaneRepository->findById($id);
    }
}
