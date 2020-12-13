<?php

namespace AndrewSvirin\Interview\Services\Validators;

use AndrewSvirin\Interview\Services\Validator\ValueValidator;

/**
 * Validate value on maximum value.
 * Example:
 *   'field' => [['MaxValueValidator', ['max' => 100]]]
 */
class MaxValueValidator implements ValueValidator
{

    /**
     * Possible messages.
     *
     * @var array|string[]
     */
    protected array $messages = [
        'is_more' => 'Field :field can not be more than %d.',
    ];

    /**
     * @inheritDoc
     *
     * @param array $options = [
     *   'max' => '<int>',
     * ]
     */
    public function validate($value, array $options = null): ?array
    {
        $violations = null;

        // No need to validate on empty value.
        if (empty($value)) {
            return $violations;
        }

        // Validate value is less than max.
        if ((int)$value > $options['max']) {
            $violations[] = sprintf($this->messages['is_more'], $options['max']);
        }

        return $violations;
    }
}
