<?php

namespace AndrewSvirin\Interview\Requests;

use AndrewSvirin\Interview\Helpers\ArrHelper;

/**
 * Common API request implementation.
 */
abstract class ApiRequest extends JsonRequest
{

    /**
     * Specifying rules for fields allowed in request.
     *
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * Get validated json.
     *
     * @return array
     */
    public function validated(): array
    {
        $json = $this->getJson();

        $rules = $this->rules();
        $validated = ArrHelper::filter($json, $rules);

        return $validated;
    }
}
