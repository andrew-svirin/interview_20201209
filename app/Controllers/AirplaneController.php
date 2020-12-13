<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Requests\Site\GetSiteVersionRequest;

/**
 * Airplane Controller implementation.
 */
class AirplaneController extends ApiController
{

    /**
     * Get application version.
     *
     * @param GetSiteVersionRequest $request
     *
     * @return array
     */
    public function createAction(GetSiteVersionRequest $request)
    {
        return [
            'message' => 'Airplane created.',
        ];
    }
}
