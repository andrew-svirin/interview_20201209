<?php

namespace AndrewSvirin\Interview\Models;

/**
 * Common Model methods.
 */
abstract class Model
{

    /**
     * Array of attributes names.
     * @var array
     */
    protected array $attributes = [];

    /**
     * Magic setter for properties.
     *
     * @param string $attribute
     *
     * @return mixed|void
     */
    public function __get(string $attribute)
    {
        // Check attribute is in attributes list or break getter.
        if (!in_array($attribute, $this->attributes)) {
            return;
        }

        return $this->{$attribute};
    }

    /**
     * Magic getter for properties.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return void
     */
    public function __set(string $attribute, $value): void
    {
        // Check attribute is in attributes list or break setter.
        if (!in_array($attribute, $this->attributes)) {
            return;
        }

        $this->{$attribute} = $value;
    }

    /**
     * Get model attributes with values.
     *
     * @return array Attributes and values.
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->attributes as $attribute) {
            $values[$attribute] = property_exists($this, $attribute) ? $this->{$attribute} : null;
        }

        return $values;
    }

    /**
     * Get model attributes with values.
     *
     * @param array $values
     *
     * @return void
     */
    public function setValues(array $values): void
    {
        foreach ($values as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }
}
