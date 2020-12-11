<?php

namespace AndrewSvirin\Interview\Requests\Site;

use AndrewSvirin\Interview\Requests\ApiRequest;

/**
 * Get site version request.
 * @see \AndrewSvirin\Interview\Controllers\SiteController::versionAction()
 */
class GetSiteVersionRequest extends ApiRequest
{

    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        return [];
    }
}
