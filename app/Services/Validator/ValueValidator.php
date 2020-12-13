<?php

namespace AndrewSvirin\Interview\Services\Validator;

/**
 * Implements validation for value.
 */
interface ValueValidator
{
    /**
     * @param mixed $value Value for validations
     * @param array|null $options Additional options for validator.
     *
     * @return ?array Return array on found errors.
     */
    public function validate($value, array $options = null): ?array;
}
