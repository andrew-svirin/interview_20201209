<?php

namespace AndrewSvirin\Interview\Models;

/**
 * Model Airplane class.
 *
 * @property int $id
 * @property string $aircraft_type
 * @property int $sits_count
 * @property int $rows
 * @property string $row_arrangement
 */
class Airplane extends Model
{

    /**
     * @inheritDoc
     */
    protected array $attributes = [
        'id',
        'aircraft_type',
        'sits_count',
        'rows',
        'row_arrangement',
    ];
}
