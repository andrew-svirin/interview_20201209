<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Requests\Site\GetSiteVersionRequest;

/**
 * Site Controller implementation.
 */
class SiteController extends ApiController
{

    /**
     * Get application version.
     *
     * @param GetSiteVersionRequest $request
     *
     * @return string
     */
    public function versionAction(GetSiteVersionRequest $request)
    {
        return '0.0.1';
    }
}
