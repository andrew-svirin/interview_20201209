<?php

namespace AndrewSvirin\Interview\Models;

/**
 * Model Airplane class.
 */
class Airplane extends Model
{

    /**
     * @inheritDoc
     */
    protected array $attributes = [
        'aircraft_type',
        'sits_count',
        'rows',
        'row_arrangement',
    ];
}
