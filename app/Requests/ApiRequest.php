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
     * Example:
     *   'field' => [[<RuleClassName>, ['<option_name>' => 'option_value']]],
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

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
