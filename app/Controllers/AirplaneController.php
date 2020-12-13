<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Exceptions\ModelNotSavedException;
use AndrewSvirin\Interview\Facades\AirplaneFacade;
use AndrewSvirin\Interview\Requests\Site\GetSiteVersionRequest;
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

    public function __construct(ApiRequestValidator $validator, AirplaneFacade $airplaneFacade)
    {
        parent::__construct($validator);
        $this->airplaneFacade = $airplaneFacade;
    }

    /**
     * Get application version.
     *
     * @param GetSiteVersionRequest $request
     *
     * @return array
     * @throws ModelNotSavedException
     */
    public function createAction(GetSiteVersionRequest $request)
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
            throw new ModelNotSavedException();
        }

        return [
            'message' => 'Airplane created.',
        ];
    }
}
