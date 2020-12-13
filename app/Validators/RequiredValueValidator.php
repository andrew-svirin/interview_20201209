<?php

namespace AndrewSvirin\Interview\Validators;

use AndrewSvirin\Interview\Services\Validator\ValueValidator;

/**
 * Validate value to be settled.
 * Example:
 *   'field' => [['RequiredValueValidator']]
 */
class RequiredValueValidator implements ValueValidator
{

    /**
     * Possible messages.
     *
     * @var array|string[]
     */
    protected array $messages = [
        'is_empty' => 'Field :field can not be empty.',
    ];

    /**
     * @inheritDoc
     */
    public function validate($value, array $options = null): ?array
    {
        $violations = null;

        // Validate value is not empty.
        if (empty($value)) {
            $violations[] = $this->messages['is_empty'];
        }

        return $violations;
    }
}
