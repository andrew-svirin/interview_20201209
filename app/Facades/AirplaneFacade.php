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
     * Create Airplane model from array.
     *
     * @param array $attributes
     *
     * @return Airplane
     */
    public function create(array $attributes): Airplane
    {
        /* @var $model Airplane */
        $model = $this->modelFactory->createModel(Airplane::class);

        return $model; // @phpstan-ignore-line
    }

    /**
     * Save model to storage.
     * This method will add model primary id.
     *
     * @param Airplane $model
     *
     * @return bool
     */
    public function save(Airplane $model): bool
    {
        return true;
    }
}