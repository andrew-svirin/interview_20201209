<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Builders\ApiResponseBuilder;
use AndrewSvirin\Interview\Facades\AirplaneFacade;
use AndrewSvirin\Interview\Requests\Airplane\CreateAirplaneRequest;
use AndrewSvirin\Interview\Services\Validator\ApiRequestValidator;

/**
 * Airplane Controller implementation.
 */
class AirplaneController extends ApiController
{

    /**
     * Airplane facade.
     *
     * @var AirplaneFacade
     */
    private AirplaneFacade $airplaneFacade;

    public function __construct(
        ApiRequestValidator $validator,
        ApiResponseBuilder $apiResponseBuilder,
        AirplaneFacade $airplaneFacade
    ) {
        parent::__construct($validator, $apiResponseBuilder);
        $this->airplaneFacade = $airplaneFacade;
    }

    /**
     * Create airplane.
     *
     * @param CreateAirplaneRequest $request
     *
     * @return ApiResponseBuilder|array
     */
    public function createAction(CreateAirplaneRequest $request)
    {
        // Validate request.
        $violations = $this->validate($request);

        // Return errors on request violations.
        if (null !== $violations) {
            return $violations;
        }

        // Create model from request validated values.
        $model = $this->airplaneFacade->create($request->validated());

        // Save model.
        if (!$this->airplaneFacade->save($model)) {
            return $this->response(401)->withMessage('Airplane not created.');
        }

        return $this->response()->withMessage('Airplane created.')->withModel($model);
    }
}
