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
     * Get json values those are present in rules.
     *
     * @return array
     */
    public function validated(): array
    {
        $json = $this->getJson();

        // Prepare json field names by rules.
        $fields = array_keys($this->rules());

        // If rules were not specified any fields.
        if (empty($fields)) {
            return [];
        }

        $validated = ArrHelper::filter($json, $fields);

        return $validated;
    }

    /**
     * Get conditions from query.
     * @return array|null
     */
    public function conditions(): ?array
    {
        parse_str($this->uri->getQuery(), $queryArray);
        return $queryArray['conditions'] ?? null;
    }
}
